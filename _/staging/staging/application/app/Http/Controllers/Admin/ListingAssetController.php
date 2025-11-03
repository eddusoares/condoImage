<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Building;
use App\Models\ListingUnit;
use Illuminate\Support\Str;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use App\Models\ListingImages;
use App\Models\StorageProvider;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ListingAssetController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Listing Units';
        $buildings = Building::where('status', 1)->orderBy('id', 'desc')->get();
        $listingUnits = ListingUnit::with(['building', 'userable'])->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.listing_image.index', compact('pageTitle', 'listingUnits', 'buildings'));
    }

    public function myList()
    {
        $pageTitle = 'My Listing Images';
        $listingUnits = ListingUnit::with(['building', 'userable'])->where('userable_type', 'admin')
            ->where('userable_id', auth('admin')->id())->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.listing_image.index', compact('pageTitle', 'listingUnits'));
    }

    public function create()
    {
        $pageTitle = 'Listing Units & Image Create';
        $buildings = Building::where('status', 1)->orderBy('id', 'desc')->get();
        $listingUnits = ListingUnit::with(['building', 'userable'])->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.listing_image.create', compact('pageTitle', 'listingUnits', 'buildings'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Listing Units';
        $listingUnits = ListingUnit::with(['building', 'userable'])->pending()->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.listing_image.index', compact('pageTitle', 'listingUnits'));
    }

    public function active()
    {
        $pageTitle = 'Active Listing Units';
        $listingUnits = ListingUnit::with(['building', 'userable'])->active()->orderBy('id', 'desc')->paginate(getPaginate(20));
        return view('admin.listing_image.index', compact('pageTitle', 'listingUnits'));
    }

    public function view($id)
    {
        $pageTitle = 'View Listing Units';
        $listingUnit = ListingUnit::with(['building', 'userable', 'listingImages'])->active()->first();
        return view('admin.listing_image.view', compact('pageTitle', 'listingUnit'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'unit_number' => 'required|string|max:60',
            'building_id' => 'required|numeric|exists:buildings,id',
            'price' => ['required', 'numeric', 'between:0.00,99999999.99', 'regex:/^\d{1,8}(\.\d{2})?$/'],
            'zip_url' => ['nullable', 'string'],
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:1,2'],
        ]);

        DB::beginTransaction();
        try {
            $listingUnit = new ListingUnit();
            $purifier = new \HTMLPurifier();
            $zipUrl = 'zip_' . now()->timestamp . '_' . Str::random(8) . '_' . $request->unit_number . '.zip';
            $listingUnit->unit_number = $request->unit_number;
            $listingUnit->building_id = $request->building_id;
            $listingUnit->userable_id = auth('admin')->id();
            $listingUnit->userable_type = 'admin';
            $listingUnit->price = $request->price;
            $listingUnit->zip_url = asset($zipUrl);

            $listingUnit->description = $purifier->purify($request->description);
            $listingUnit->status = $request->status;
            $listingUnit->step = 1;
            if ($request->hasFile('image')) {
                $listingUnit->image = fileUploader($request->image, getFilePath('listing_asset_image'), getFileSize('listing_asset_image'), null, getFileThumbSize('listing_asset_image'));
            }
            $listingUnit->save();
            DB::commit();

            $notify[] = ['success', 'Listing create successfully'];
            return to_route('admin.listing.asset.upload', $listingUnit->id)->withNotify($notify);
        } catch (\Exception $exp) {
            DB::rollBack();
            $notify[] = ['error', 'Something went wrong! Cattle creation failed.'];
            return back()->withNotify($notify);
        }
    }


    public function imageUpload($id)
    {
        $pageTitle = 'Upload Listing Images';
        $listingUnit = ListingUnit::with('listingImages')->where('id', $id)->orderBy('id', 'desc')->first();
        return view('admin.listing_image.image_upload', compact('pageTitle', 'listingUnit'));
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
                'finalize_url' => route('admin.listing.asset.upload.store')
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
                'finalize_url' => route('admin.listing.asset.upload.store')
            ]);
        }

        return response()->json(['status' => 'chunk uploaded']);
    }


    public function upload(Request $request)
    {
        $listingUnitId = $request->get('listingUnitId');
        $listingUnit = ListingUnit::where('id', $listingUnitId)->first();
        $storageProvider = StorageProvider::where('status', 1)->first();

        if (!$listingUnit) {
            return response()->json(['error' => 'Listing Unit id is not found']);
        }

        $extension = $request->get('extension', 'jpg');
        $uuid = $request->get('uuid');
        $filename = $request->get('name');


        //  check storage provider AWS is connect or not, upload image and chunk file delete.
        if ($storageProvider  && $storageProvider->alias == "s3") {
   
            $data = s3ConnectOrNot($uuid, $filename);
            if ($data && $data['status'] == 'error') {
                return response()->json([$data['status'] => $data['message']]);
            }
        }

        if (!$uuid || !$filename) {
            return response()->json(['error' => 'Invalid UUID or filename']);
        }

        //  Upload image chunk file delete.
        $finalPath = fileChunkDelete($filename, $uuid);


        // ####### move to another file #######
        $sourcePath = $finalPath;
        $newDir = getFilePath('listing_asset_image');

        if (!is_dir($newDir)) {
            mkdir($newDir, 0777, true);
        }

        $newFileName = uniqid() . time() . '.' . $extension;
        $newPath = $newDir . '/' . $newFileName;
        if (File::exists($sourcePath)) {

            if ($storageProvider  && $storageProvider->alias == "s3") {
                // AWS upload
                $awsData = awsUploader($sourcePath, $newFileName,getFileWatermarkSize('listing_asset_image'));
            } else {
                //locally
                $localData = localUploader($sourcePath, $newPath, $newFileName,getFileWatermarkSize('listing_asset_image'),getFilePath('listing_asset_image_watermark'));
            }

            //  save listing image path in database
            $listingImage = new ListingImage();
            $listingImage->listing_unit_id = $listingUnit->id;
            $listingImage->image = $newFileName;
            $listingImage->userable_id = auth('admin')->id();
            $listingImage->userable_type = 'admin';
            $listingImage->storage = isset($awsData) ? $storageProvider->alias : 'local';
            $listingImage->save();

            return response()->json([
                'success' => true,
                'message' => 'Image moved successfully.',
                'url' => $newPath,
                'listingImageId' => $listingImage->id,
            ]);
        }
        //  ########### end move to another file ###########

        return response()->json(['success' => true, 'path' => asset("storage/uploads/{$filename}")]);
    }


    public function chunkOrImageDelete(Request $request)
    {
        $uuid = $request->get('uuid');
        $file_path = $request->get('file_path');
        $storageProvider = StorageProvider::where('status', 1)->first();

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

        if ($file_path || $request->listingImageId) {
            $listingImage = ListingImage::where('id', $request->listingImageId)->first();

            if ($listingImage->storage == "s3") {
                // AWS delete
                //main image
                Storage::disk('s3')->delete($listingImage->image);

                // watermark delete
                Storage::disk('s3')->delete('/watermark_' . $listingImage->image);
            } else {
                //locally
                if (File::exists(getFilePath('listing_asset_image') . '/' . $listingImage->image)) {
                    fileManager()->removeFile(getFilePath('listing_asset_image') . '/' . $listingImage->image);
                }

                // if (File::exists(getFilePath('listing_asset_image') . '/thumb_' . $listingImage->image)) {
                //     fileManager()->removeFile(getFilePath('listing_asset_image') . '/thumb_' . $listingImage->image);
                // }

                if (File::exists(getFilePath('listing_asset_image_watermark') . '/watermark_' . $listingImage->image)) {
                    fileManager()->removeFile(getFilePath('listing_asset_image_watermark') . '/watermark_' . $listingImage->image);
                }


                if (File::exists($file_path)) {
                    fileManager()->removeFile($file_path);
                }
            }


            if ($listingImage) {
                $listingImage->delete();
            }
        }

        return response()->json(['error' => 'Chunk directory not found'], 404);
    }


    public function edit($id)
    {
        
        $pageTitle = 'Listing Units & Image Edit';
        $buildings = Building::where('status', 1)->orderBy('id', 'desc')->get();
        $listingUnit = ListingUnit::with('listingImages')->where('id', $id)->orderBy('id', 'desc')->first();
        abort_unless($listingUnit->userable_type == 'admin', 403, 'Unauthorized action.');
        return view('admin.listing_image.edit', compact('pageTitle', 'listingUnit', 'buildings'));
    }

    public function update(Request $request, $id)
    {

        $listingUnit = ListingUnit::with('listingImages')->findOrFail($id);
        $purifier = new \HTMLPurifier();

        $this->validate($request, [
            'unit_number' => 'required|string|max:60',
            'building_id' => 'required|numeric|exists:buildings,id',
            'price' => ['required', 'numeric', 'between:0.00,99999999.99', 'regex:/^\d{1,8}(\.\d{2})?$/'],
            'zip_url' => ['nullable', 'string'],
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:1,2'],
        ]);

        DB::beginTransaction();
        try {
            $zipUrl = asset('zip_' . now()->timestamp . '_' . Str::random(8) . '_' . $request->unit_number . '.zip');
            $listingUnit->unit_number = $request->unit_number;
            $listingUnit->building_id = $request->building_id;
            $listingUnit->userable_id = auth('admin')->id();
            $listingUnit->userable_type = 'admin';
            $listingUnit->price = $request->price;
            $listingUnit->zip_url = ($listingUnit->unit_number == $request->unit_number) ? $listingUnit->zip_url : $zipUrl;
            $listingUnit->description = $purifier->purify($request->description);
            $listingUnit->status = $request->status;
            if ($request->hasFile('image')) {
                $old = $listingUnit->image;
                $listingUnit->image = fileUploader($request->image, getFilePath('listing_asset_image'), getFileSize('listing_asset_image'), $old, getFileThumbSize('building'));
            }
            $listingUnit->save();

            DB::commit();
            $notify[] = ['success', 'Listing update successfully'];
            return to_route('admin.listing.asset.upload', $listingUnit->id)->withNotify($notify);
        } catch (\Exception $exp) {
            DB::rollBack();
            $notify[] = ['error', 'Something went wrong! Listing image creation failed.'];
            return back()->withNotify($notify);
        }
    }

    public function statusChange($id)
    {

        $listingUnit = ListingUnit::findOrFail($id);
        try {
            $listingUnit->status = ($listingUnit->status == 1) ? 2 : 1;
            $listingUnit->save();
            $notify[] = ['success', 'Listing change status successfully'];
            return back()->withNotify($notify);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Something went wrong! Listing change status update failed.'];
            return back()->withNotify($notify);
        }
    }

    public function ListingImageDelete($id)
    {
        $listingImage = ListingImage::findOrFail($id);
        try {
            fileManager()->removeFile(getFilePath('listing_asset_image') . '/' . $listingImage->image);
            fileManager()->removeFile(getFilePath('listing_asset_image_watermark') . '/watermark_' . $listingImage->image);
            $listingImage->delete();
            $notify[] = ['success', 'Listing image delete successfully.'];
            return back()->withNotify($notify);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Something went wrong! Listing image delete failed.'];
            return back()->withNotify($notify);
        }
    }

    public function delete($id)
    {
        $listingUnit = ListingUnit::with('listingImages')->findOrFail($id);
        try {
            foreach ($listingUnit->listingImages ?? [] as $key => $item) {
                $fullImagePath = getFilePath('listing_asset_image') . '/' . $item->image;
                if ($fullImagePath) {
                    fileManager()->removeFile($fullImagePath);
                    $item->delete();
                }
            }
            $mainImagePath = getFilePath('listing_asset_image') . '/' . $listingUnit->image;
            if (file_exists($mainImagePath)) {
                fileManager()->removeFile($mainImagePath);
                $listingUnit->delete();
            }
            $listingUnit->delete();
            $notify[] = ['success', 'Listing image delete successfully.'];
            return back()->withNotify($notify);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Something went wrong! Listing image delete failed.'];
            return back()->withNotify($notify);
        }
    }


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'errors' => $exception->errors()
                ], 422);
            }
        }

        return parent::render($request, $exception);
    }
}
