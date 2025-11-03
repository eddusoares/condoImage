<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\BuildingDescription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\ImageCategoryDescription;

class BuildingController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Buildings';
        $buildings = Building::with(["neighborhood", "buildingListingUnits"])->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.building.index', compact('pageTitle', 'buildings'));
    }

    public function pending()
    {
        $pageTitle = 'My Buildings';
        $buildings = Building::with(["neighborhood", "buildingListingUnits"])->pending()->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.building.index', compact('pageTitle', 'buildings'));
    }

    public function active()
    {
        $pageTitle = 'My Buildings';
        $buildings = Building::with(["neighborhood", "buildingListingUnits"])->active()->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.building.index', compact('pageTitle', 'buildings'));
    }

    public function create()
    {
        $pageTitle = 'Add new Condo Building';
        $buildings = Building::orderBy('id', 'desc')->paginate(getPaginate(20));
        $neighborhoods = Neighborhood::where('status', 1)->orderBy('id', 'desc')->get();
        $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();
        $imageCategories = ImageCategory::get();
        $tags = Tag::orderBy('id', 'desc')->get();
        return view('admin.building.create', compact('pageTitle', 'buildings', 'neighborhoods', 'categories', 'tags'));
    }

    public function store(Request $request)
    {
        // Static validation rules
        $staticRules = [
            'name' => 'required|string|max:60|unique:buildings,name',
            'neighborhood_id' => 'required|numeric|exists:neighborhoods,id',
            'address' => 'required|string|max:1000',
            'year_built' => ['required', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'price' => ['required', 'numeric', 'between:0.00,99999999.99', 'regex:/^\d{1,8}(\.\d{2})?$/'],
            'units' => 'required|string',
            'stories' => 'required|string',
            'description' => 'required|string',
            'copyright_description' => 'required|string',
            'status' => 'required|in:1,2',
            'claim' => ['nullable', 'in:1,2'],
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ];

        // Dynamic validation rules for image categories
        $dynamicRules = [];

        // Merge and validate all rules at once
        $request->validate(array_merge($staticRules, $dynamicRules));
        DB::beginTransaction();

        try {
            $buildingName = strtolower(preg_replace('/[^A-Za-z0-9]/', '_', $request->name));
            $zipUrl = asset('zip_' . now()->timestamp . '_' . Str::random(8) . '_' . $buildingName . '.zip');
            $purifier = new \HTMLPurifier();
            $building = new Building();
            $building->name = $request->name;
            $building->neighborhood_id = $request->neighborhood_id;
            $building->year_built = substr($request->year_built, 0, 4);
            $building->price = $request->price;
            $building->address = $request->address;
            $building->units = $request->units;
            $building->stories = $request->stories;
            $building->zip_url = $zipUrl;
            $building->description = $purifier->purify($request->description);
            $building->copyright_description = $purifier->purify($request->copyright_description);
            $building->status = $request->status;
            $building->claim = $request->claim;

            // Upload main image
            if ($request->hasFile('image')) {
                try {
                    $building->image = fileUploader($request->image, getFilePath('building'), getFileSize('building'), null, getFileThumbSize('building'));
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
            }
            // Save building first to get its ID
            $building->save();

            DB::commit();
            $notify[] = ['success', 'Building has been created successfully'];
            $route = $building->claim == 1
                ? route('admin.building.upload', $building->id)
                : route('admin.building.index', $building->id);
            return redirect($route)->withNotify($notify);
        } catch (\Exception $exp) {
            DB::rollBack();
            $notify[] = ['error', 'Something went wrong! Building image creation failed.'];
            return back()->withNotify($notify);
        }
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
        foreach ($request->all() as $key => $value) {
            if (is_array($value) && isset($value['image_category_id']) && isset($value['description'])) {
                $imageCategoryDescription = new ImageCategoryDescription();
                $imageCategoryDescription->building_id = $building->id;
                $imageCategoryDescription->image_category_id = $value['image_category_id'];
                $imageCategoryDescription->description = $value['description'];
                $imageCategoryDescription->save();
            }
        }

        $notify[] = ['success', 'Building image successfully created.'];
        return to_route('admin.building.index')->withNotify($notify);
    }

    public function imageUpload($id)
    {
        $pageTitle = 'Upload Building Images';
        $building = Building::with('buildingImages', 'buildingImagesCategoryDescriptions')->where('id', $id)->orderBy('id', 'desc')->first();
        abort_unless($building->adminHasClaimed($building), 403, 'Unauthorized action.');
        $imageCategories = ImageCategory::get();
        return view('admin.building.image_upload', compact('pageTitle', 'building', 'imageCategories'));
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
                'finalize_url' => route('admin.building.upload.store')
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
                'finalize_url' => route('admin.building.upload.store')
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
            return response()->json(['error' => 'Building not found'], 404);
        }

        if (!$imageCategory) {
            fileChunkDelete($filename, $uuid);
            return response()->json(['error' => 'Image Category not found'], 404);
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
            $buildingImage->building_id = $building->id;
            $buildingImage->userable_id = auth('admin')->id();
            $buildingImage->userable_type = 'admin';
            $buildingImage->image_category_id = $imageCategory->id;
            $buildingImage->image = $newFileName;
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

    public function view($id)
    {
        $pageTitle = 'View Condo Building Images';
        $building = Building::with(['buildingImages', 'neighborhood'])->where('id', $id)->first();
        $imageCategories = ImageCategory::get();
        return view('admin.building.view', compact('pageTitle', 'building', 'imageCategories'));
    }

    public function claim(Request $request, $id)
    {
        $pageTitle = 'Edit claim';
        $building = Building::findOrFail($id);
        $building->claim = $request->claim;
        $building->claim_by = 0;
        $building->save();
        $notify[] = ['success', 'Claim author has been changed.'];
        return redirect()->back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Condo Building Images';
        $building = Building::with('buildingImages', 'buildingImagesCategoryDescriptions')->where('id', $id)->first();
        $neighborhoods = Neighborhood::where('status', 1)->orderBy('id', 'desc')->paginate(getPaginate(20));
        $tags = Tag::orderBy('id', 'desc')->get();
        $imageCategories = ImageCategory::get();
        $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();
        abort_unless($building->claim == 1, 403, 'Unauthorized action.');
        return view('admin.building.edit', compact('pageTitle', 'building', 'neighborhoods', 'tags', 'imageCategories', 'categories'));
    }



    public function editImageUpload($id)
    {
        $pageTitle = 'Upload Building Images';
        $building = Building::with('buildingImages', 'buildingImagesCategoryDescriptions')->where('id', $id)->orderBy('id', 'desc')->first();

        abort_unless($building->adminHasClaimed($building), 403, 'Unauthorized action.');
        $imageCategories = ImageCategory::get();
        return view('admin.building.edit_image_upload', compact('pageTitle', 'building', 'imageCategories'));
    }


    public function update(Request $request, $id)
    {
        $building = Building::findOrFail($id);
        // Static validation rules
        $staticRules = [
            'name' => 'required|string|max:60|unique:buildings,name,' . $building->id,
            'neighborhood_id' => 'required|numeric|exists:neighborhoods,id',
            'address' => 'required|string|max:1000',
            'year_built' => ['nullable', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'price' => ['required', 'numeric', 'between:0.00,99999999.99', 'regex:/^\d{1,8}(\.\d{2})?$/'],
            'units' => 'required|string',
            'stories' => 'required|string',
            'description' => 'required|string',
            'copyright_description' => 'required|string',
            'status' => 'required|in:1,2',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ];

        // Dynamic validation rules for image categories
        $dynamicRules = [];

        // Merge and validate all rules at once
        $request->validate(array_merge($staticRules, $dynamicRules));
        DB::beginTransaction();
        try {
            $buildingName = strtolower(preg_replace('/[^A-Za-z0-9]/', '_', $request->name));
            $zipUrl = asset('zip_' . now()->timestamp . '_' . Str::random(8) . '_' . $buildingName . '.zip');
            $purifier = new \HTMLPurifier();
            $building->name = $request->name;
            $building->neighborhood_id = $request->neighborhood_id;
            $building->year_built = $request->year_built ? substr($request->year_built, 0, 4) : $building->year_built;
            $building->price = $request->price;
            $building->address = $request->address;
            $building->units = $request->units;
            $building->stories = $request->stories;
            $building->zip_url = ($building->buildingName == $request->name) ? $building->zip_url : $zipUrl;
            $building->description = $purifier->purify($request->description);
            $building->copyright_description = $purifier->purify($request->copyright_description);
            $building->status = $request->status;
            // Upload main image
            if ($request->hasFile('image')) {
                try {
                    $old = $building->image;
                    $building->image = fileUploader($request->image, getFilePath('building'), getFileSize('building'), $old, getFileThumbSize('building'));
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
            }

            // Save building first to get its ID
            $building->save();
            DB::commit();

            $notify[] = ['success', 'Building has been Updated successfully'];
            $route = $building->claim == 1
                ? route('admin.building.edit.upload', $building->id)
                : route('admin.building.index', $building->id);
            return redirect($route)->withNotify($notify);
        } catch (\Exception $exp) {
            DB::rollBack();
            $notify[] = ['error', 'Something went wrong! Building image updated failed.'];
            return back()->withNotify($notify);
        }
    }

    public function imageDescriptionUpdate(Request $request)
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


        $notify[] = ['success', 'Building image successfully updated'];
        return to_route('admin.building.index')->withNotify($notify);
    }


    public function statusChange($id)
    {
        $building = Building::findOrFail($id);
        try {
            $building->status = ($building->status == 1) ? 2 : 1;
            $building->save();
            $notify[] = ['success', 'Building change status successfully'];
            return back()->withNotify($notify);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Something went wrong! Building change status update failed.'];
            return back()->withNotify($notify);
        }
    }


    public function buildingImageDelete($id)
    {
        $buildingImage = BuildingImage::findOrFail($id);
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


    public function delete($id)
    {
        $building = Building::with('buildingImages')->findOrFail($id);

        try {
            $buildingPath = getFilePath('building');
            $watermarkPath = $buildingPath . '/watermark';
            $thumbPath = $buildingPath . '/thumb_';

            // Delete building images & watermarks
            foreach ($building->buildingImages ?? [] as $image) {
                $imageFile = $buildingPath . '/' . $image->image;
                $watermarkFile = $watermarkPath . '/watermark_' . $image->image;

                fileManager()->removeFile($imageFile);
                fileManager()->removeFile($watermarkFile);

                $image->delete();
            }

            // Delete main building image & thumbnail
            if (!empty($building->image)) {
                $mainImage = $buildingPath . '/' . $building->image;
                $thumbImage = $thumbPath . $building->image;

                fileManager()->removeFile($mainImage);
                fileManager()->removeFile($thumbImage);
            }

            // Delete building
            $building->delete();

            $notify[] = ['success', 'Building and associated images deleted successfully.'];
            return back()->withNotify($notify);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Something went wrong! Building deletion failed.'];
            return back()->withNotify($notify);
        }
    }


    public function soldByContributor()
    {
        $pageTitle = 'Sold By Contributor';
       
        $orders = Order::with(['building','building.neighborhood','building.neighborhood.county'])->whereHas('building', function ($query) {
            $query->where('claim', 2);
        })->paginate(getPaginate());


        return view('admin.sold_by_contributor.index', compact('pageTitle', 'orders'));
    }
}
