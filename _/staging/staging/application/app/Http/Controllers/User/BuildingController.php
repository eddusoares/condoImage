<?php

namespace App\Http\Controllers\User;

use App\Models\Tag;
use App\Models\Order;
use App\Models\Building;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use App\Models\BuildingImage;
use App\Models\ImageCategory;
use App\Models\StorageProvider;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\ImageCategoryDescription;

class BuildingController extends Controller
{
    public function index()
    {

        $pageTitle = 'All Buildings';
        $orders = Order::with('buildingListingUnit', 'building.neighborhood.county')->where('status', 1)->where('user_id', auth()->id())->latest()->pluck('id');
        $buildings = Building::with(["neighborhood.county", "buildingListingUnits", "buildingImages"])->whereIn('id',$orders)->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view($this->activeTemplate . 'user.building.index', compact('pageTitle', 'buildings'));
    }

    public function create($id)
    {

        $pageTitle = 'Add new Condo Building Images';
        $building = Building::with('buildingImagesCategoryDescriptions', 'buildingImages')
            ->findOrFail($id);

        abort_unless($building->userHasClaimed($building), 403, 'Unauthorized action.');

        $imageCategories = ImageCategory::get();
        return view($this->activeTemplate . 'user.building.create', compact('pageTitle', 'building', 'imageCategories'));
    }

    public function claimed($id)
    {
        $building = Building::with('buildingImages')->where('id', $id)->first();
        $building->claim_by = auth()->id();
        $building->save();


        $notify[] = ['success', 'Building has been claimed by you.'];
        return redirect()->back()->withNotify($notify);
    }


    public function uploadChunk(Request $request)
    {

        if (!$request->has('dztotalchunkcount')) {

            // Small file fallback (not chunked)
            $uuid = Str::uuid()->toString();
            $chunkDir = storage_path("app/chunks/{$uuid}");
            mkdir($chunkDir, 0777, true);

            $filename = $request->file('file')->getClientOriginalName();
            $chunkPath = "{$chunkDir}/0.part";

            $written = file_put_contents($chunkPath, file_get_contents($request->file('file')->getRealPath()));

            return response()->json([
                'done' => true,
                'uuid' => $uuid,
                'name' => $filename,
                'finalize_url' => route('user.building.upload.store')
            ]);
        }

        $uuid = $request->get('dzuuid');
        $index = $request->get('dzchunkindex');
        $total = $request->get('dztotalchunkcount');
        $filename = $request->file('file')->getClientOriginalName();

        $chunkDir = storage_path("app/chunks/{$uuid}");

        if (!is_dir($chunkDir)) {
            mkdir($chunkDir, 0777, true);
        }

        $chunkPath = "{$chunkDir}/{$index}.part";
        file_put_contents($chunkPath, file_get_contents($request->file('file')->getRealPath()));


        if ($index == $total - 1) {
            return response()->json([
                'done' => true,
                'uuid' => $uuid,
                'name' => $filename,
                'finalize_url' => route('user.building.upload.store')
            ]);
        }

        return response()->json(['status' => 'chunk uploaded']);
    }


    public function upload(Request $request)
    {
        $buildingId = $request->get('buildingId');
        $imageCategoryId = $request->get('imageCategoryId');
        $building = Building::where('id', $buildingId)->first();
        $storageProvider = StorageProvider::where('status', 1)->first();
        $imageCategory = ImageCategory::where('id', $imageCategoryId)->first();

        $extension = $request->get('extension', 'jpg');
        $uuid = $request->get('uuid');
        $filename = $request->get('name');

        if (!$building) {

            fileChunkDelete($filename, $uuid);
            return response()->json(
                ['error' => 'Building not found select the building first']
            );
        }

        if (!$imageCategory) {
            fileChunkDelete($filename, $uuid);
            return response()->json(['error' => 'Image Category not found']);
        }

        //  check storage provider AWS is connect or not, upload image and chunk file delete.
        if ($storageProvider  && $storageProvider->alias == "s3") {
            $data = s3ConnectOrNot($uuid, $filename);
            if ($data && $data['status'] == 'error') {
                return response()->json([$data['status'] => $data['message']]);
            }
        }

        if (!$uuid || !$filename) {
            return response()->json(['error' => 'Invalid UUID or filename'], 400);
        }

        //  Upload image chunk file delete.
        $finalPath = fileChunkDelete($filename, $uuid);

        // ####### move to another file #######
        $sourcePath = $finalPath;
        $newDir = getFilePath('building');

        if (!is_dir($newDir)) {
            mkdir($newDir, 0777, true);
        }

        $newFileName = uniqid() . time() . '.' . $extension;
        $newPath = $newDir . '/' . $newFileName;
        if (File::exists($sourcePath)) {
            if ($storageProvider  && $storageProvider->alias == "s3") {
                // AWS upload
                $awsData = awsUploader($sourcePath, $newFileName, getFileWatermarkSize('building'));
            } else {
                //locally
                $localData = localUploader($sourcePath, $newPath, $newFileName, getFileWatermarkSize('building'), getFilePath('building_watermark'));
            }

            //  save building image path in database
            $buildingImage = new BuildingImage();
            $buildingImage->building_id = $building->id;
            $buildingImage->image_category_id = $imageCategory->id;
            $buildingImage->image = $newFileName;
            $buildingImage->userable_id = auth()->id();
            $buildingImage->userable_type = 'user';
            $buildingImage->storage = isset($awsData) ? $storageProvider->alias : 'local';
            $buildingImage->save();

            return response()->json([
                'success' => true,
                'message' => 'Image moved successfully.',
                'url' => $newPath,
                'buildingId' => $building->id,
                'imageCategoryId' => $imageCategory->id,
                'buildingImageId' => $buildingImage->id,

            ]);
        }
        //  ########### end move to another file ###########

        return response()->json(['success' => true, 'path' => asset("storage/uploads/{$filename}")]);
    }


    public function chunkOrImageDelete(Request $request)
    {

        $uuid = $request->get('uuid');
        $file_path = $request->get('file_path');

        if (!$uuid) {
            return response()->json(['error' => 'UUID is missing'], 400);
        }

        $chunkDir = storage_path("app/chunks/{$uuid}");

        if (is_dir($chunkDir)) {
            // Delete all files and directory
            $files = glob("{$chunkDir}/*");
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($chunkDir);

            return response()->json(['success' => true, 'message' => 'Chunks deleted']);
        }
        if ($file_path || $request->buildingImageId) {
            $buildingImage = BuildingImage::where('id', $request->buildingImageId)->first();
            $storageProvider = StorageProvider::where('status', 1)->first();

            if ($buildingImage->storage == "s3") {
                // AWS delete
                //main image
                Storage::disk('s3')->delete($buildingImage->image);

                // watermark delete
                Storage::disk('s3')->delete('/watermark_' . $buildingImage->image);
            } else {

                if (File::exists(getFilePath('building') . '/' . $buildingImage->image)) {
                    fileManager()->removeFile(getFilePath('building') . '/' . $buildingImage->image);
                }

                // if (File::exists(getFilePath('building') . '/thumb_' . $buildingImage->image)) {
                //     fileManager()->removeFile(getFilePath('building') . '/thumb_' . $buildingImage->image);
                // }

                if (File::exists(getFilePath('building_watermark') . '/watermark_' . $buildingImage->image)) {
                    fileManager()->removeFile(getFilePath('building_watermark') . '/watermark_' . $buildingImage->image);
                }


                if (File::exists($file_path)) {
                    fileManager()->removeFile($file_path);
                }
            }


            if ($buildingImage) {
                $buildingImage->delete();
            }
        }

        return response()->json(['error' => 'Chunk directory not found'], 404);
    }



    public function imageDescriptionStore(Request $request)
    {
        $building = Building::with(['buildingImages', 'neighborhood'])->where('id', $request->building_id)->first();

        $dynamicRules = [];
        foreach ($request->all() as $key => $value) {
            if (is_array($value) && isset($value['image_category_id'])) {
                $dynamicRules["$key.image_category_id"] = 'required|numeric|exists:image_categories,id';
                $dynamicRules["$key.description"] = 'nullable|string';
            }
        }

        $request->validate($dynamicRules);

        // // Process and description
        $purifier = new \HTMLPurifier();
        foreach ($request->all() as $key => $value) {
            if (is_array($value) && isset($value['image_category_id'])) {

                $imageCategoryDescription = ImageCategoryDescription::where('image_category_id', $value['image_category_id'])->where('building_id', $building->id)->first();
                if (!$imageCategoryDescription) {
                    $imageCategoryDescription = new ImageCategoryDescription();
                }
                $imageCategoryDescription->building_id = $building->id;
                $imageCategoryDescription->image_category_id = $value['image_category_id'];
                $imageCategoryDescription->description = $purifier->purify($value['description'] ?? '');
                $imageCategoryDescription->save();
            }
        }

        $notify[] = ['success', 'Building image successfully created.'];
        return to_route('user.building.index')->withNotify($notify);
    }


    public function view($id)
    {

        $pageTitle = 'View Condo Building Images';
        $building = Building::with('buildingImages')->where('id', $id)->first();
        return view($this->activeTemplate . 'user.building.edit', compact('pageTitle', 'building', 'neighborhoods', 'tags', 'imageCategories', 'categories'));
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Condo Building Images';
        $building = Building::with('buildingImages')->where('id', $id)->first();
        abort_unless($building->userable_type === 'user' && $building->userable_id === auth()->id(), 403, 'Unauthorized action.');
        $neighborhoods = Neighborhood::where('status', 1)->orderBy('id', 'desc')->paginate(getPaginate(20));
        $tags = Tag::orderBy('id', 'desc')->get();
        $imageCategories = ImageCategory::get();
        $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();
        return view($this->activeTemplate . 'user.building.edit', compact('pageTitle', 'building', 'neighborhoods', 'tags', 'imageCategories', 'categories'));
    }



    public function buildingImageDelete($id)
    {

        $buildingImage = BuildingImage::findOrFail($id);
        if (!($buildingImage->userable_id == auth()->id() && $buildingImage->userable_type == 'user')) {

            $notify[] = ['error', 'you can not delete this image because its author is admin'];
            return back()->withNotify($notify);
        }

        try {
            fileManager()->removeFile(getFilePath('building') . '/' . $buildingImage->image);
            fileManager()->removeFile(getFilePath('building') . '/watermark/watermark_' . $buildingImage->image);
            $buildingImage->delete();
            $notify[] = ['success', 'Building image delete successfully.'];
            return back()->withNotify($notify);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Something went wrong! Building image delete failed.'];
            return back()->withNotify($notify);
        }
    }
}
