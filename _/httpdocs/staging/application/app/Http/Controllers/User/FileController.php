<?php

namespace App\Http\Controllers\User;

use App\Models\File;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\StorageProvider;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $pageTitle = 'Files';
        $user = auth()->user();
        $pendingFiles = File::where('user_id', $user->id)->where('status', 0)->with(['reviewer', 'category'])->latest()->paginate(10);
        $publishedFiles = File::where('user_id', $user->id)->where('status', 1)->with(['reviewer', 'category'])->latest()->paginate(10);
        $rejectedFiles = File::where('user_id', $user->id)->where('status', 2)->with(['reviewer', 'category'])->latest()->paginate(10);
        $onReviewingFiles = File::where('user_id', $user->id)->where('status', 3)->with(['reviewer', 'category'])->latest()->paginate(10);
        $pendingFilesCount = File::where('user_id', $user->id)->where('status', 0)->count();
        $publishedFilesCount = File::where('user_id', $user->id)->where('status', 1)->count();
        $rejectedFilesCount = File::where('user_id', $user->id)->where('status', 2)->count();
        $onReviewingFilesCount = File::where('user_id', $user->id)->where('status', 3)->count();
        return view($this->activeTemplate . 'user.file.index', compact(
            'pageTitle',
            'pendingFiles',
            'publishedFiles',
            'rejectedFiles',
            'onReviewingFiles',
            'pendingFilesCount',
            'publishedFilesCount',
            'rejectedFilesCount',
            'onReviewingFilesCount',
        ));
    }

    public function fileStore(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg'
        ], [
            'title.required' => 'Please enter a title to submit.',
            'category_id.required' => 'Please select a category to submit.',
            'tags.required' => 'Please select desired tags.',
            'description.required' => 'Please write a description to submit.',
            'file.required' => 'Please select a file to submit.',
            'file.mimes' => 'File type must be jpeg, png or jpg.'
        ]);

        $file = $request->file('file');
        $storageProvider = StorageProvider::where('status', 1)->first();

        // save main image
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(getFilePath('file'), $fileName);
        if ($storageProvider->alias !== 'local') {
            $this->cloudStorageUpload(getFilePath('file'), $fileName, getImage(getFilePath('file') . '/' . $fileName), '');
        }

        // save watermark image original size and preview size 
        $image = Image::make(getFilePath('file') . '/' . $fileName);
        $watermark = Image::make(getFilePath('others') . '/' . 'watermark.png');

        $imageWidth = $image->width();
        $imageHeight = $image->height();

        if ($imageHeight > $imageWidth) {
            $percentage = 40;
        } else {
            $percentage = 30;
        }

        $watermarkWidth = $imageWidth * $percentage / 100;
        $watermarkHeight = $watermarkWidth * ($watermark->height() / $watermark->width());
        $watermark->resize($watermarkWidth, $watermarkHeight);

        $positionX = ($imageWidth - $watermarkWidth) / 2;
        $positionY = ($imageHeight - $watermarkHeight) / 2;

        // Ensure the position values are integers
        $positionX = (int) round($positionX);
        $positionY = (int) round($positionY);

        // inserting watermark
        $image->insert($watermark, 'top-left', $positionX, $positionY);

        // preview size
        $preview = getFilePath('preview');
        $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imageStream = $image->encode();
        $this->cloudStorageUpload($preview, $fileName, $imageStream, 'preview');

        // Create a thumbnail while maintaining aspect ratio
        $imagePath = getFilePath('file') . '/' . $fileName;
        $thumbnailPath = getFilePath('media');
        $thumbnail = Image::make($imagePath);
        $thumbnail->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $thumbnailImageStream = $thumbnail->encode();
        $this->cloudStorageUpload($thumbnailPath, $fileName, $thumbnailImageStream, "media");


        if ($storageProvider->alias !== 'local') {
            fileManager()->removeFile(getFilePath('file') . '/' . $fileName);
        }

        $file = new File();
        $file->user_id = auth()->user()->id;
        $file->category_id = $request->category_id;
        $file->title = $request->title;
        $file->width = $imageWidth;
        $file->height = $imageHeight;
        $file->file_path = ($storageProvider->alias != 'local') ? $storageProvider->credentials->url : getFilePath('file');
        $file->file_name = $fileName;
        $file->type = $storageProvider->alias;
        $file->tags =  $request->tags;
        $file->description =  $request->description;
        $file->status =  0;
        $file->is_premium = isset($request->isPremium) ? 1 : null;
        $file->save();

        return ['upload' => true];
    }

    public function edit($id)
    {
        $pageTitle = 'Edit File';
        $file = File::find($id);
        return view($this->activeTemplate . 'user.file.edit', compact('pageTitle', 'file'));
    }

    public function fileEdit(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'Please enter a title to submit.',
            'category_id.required' => 'Please select a category to submit.',
            'tags.required' => 'Please select desired tags.',
            'description.required' => 'Please write a description to submit.',
        ]);


        $file = File::find($id);
        $file->category_id = $request->category_id;
        $file->title = $request->title;
        $file->tags =  $request->tags;
        $file->description =  $request->description;
        $file->is_premium = isset($request->isPremium) ? 1 : null;
        $file->save();

        $notify[] = ['success', 'Your Image has been updated successfully.'];
        return to_route('user.file.index')->withNotify($notify);
    }

    public function fileDelete($id)
    {
        $storageProvider = StorageProvider::where('status', 1)->first();
        if (!$storageProvider) {
            throw new \Exception("No active storage provider found.");
        }

        $file = File::findOrFail($id);
        $filePaths = [
            'file'      => getFilePath('file'),
            'media'     => getFilePath('media'),
            'preview'   => getFilePath('preview'),
            'watermark' => getFilePath('watermark')
        ];
        $cloudDisks = ['s3', 'wasabi'];
        if (in_array($file->type, $cloudDisks)) {
            foreach (['', 'media', 'preview'] as $folder) {
                if (Storage::disk($storageProvider->alias)->exists("$folder/{$file->file_name}")) {
                    Storage::disk($storageProvider->alias)->delete("$folder/{$file->file_name}");
                }
            }
        } else {
            foreach ($filePaths as $path) {
                fileManager()->removeFile("$path/{$file->file_name}");
            }
        }

        $file->delete();
        $notify[] = ['success', 'File has been successfully deleted'];
        return back()->withNotify($notify);
    }
    public function download($id)
    {
        $file = File::where('status', 1)->find($id);
        $file->download_count += 1;
        $file->save();


        $cloudDisks = ['s3', 'wasabi'];
        $downloadFilePath = $file->file_path . '/' . $file->file_name;
        if (in_array($file->type, $cloudDisks)) {
            $disk = Storage::disk($file->type); // Dynamically select cloud disk
            if (!$disk->exists($downloadFilePath)) {
                abort(404, 'File not found.');
            }

            return Storage::disk('s3')->response($downloadFilePath);
        } elseif ($file->type === "local") {
            return response()->download($file->file_path . '/' . $file->file_name, 'downloaded_image.jpg');
        } else {
            $notify[] = ['error', 'Sorry, Image not found.'];
            return back()->withNotify($notify);
        }
    }

    public function downloadBySubscription($id)
    {
        $user = auth()->user();
        if ($user->image_count == 0) {
            $subscription = Subscription::where('user_id', $user->id)->first();
            $subscription->delete();

            $user->image_count = null;
            $user->save();

            $notify[] = ['error', 'Sorry, Your have finished your download limit.'];
            return back()->withNotify($notify);
        }

        $file = File::where('status', 1)->find($id);
        $file->download_count += 1;
        $file->save();

        $user->image_count -= 1;
        $user->save();

        $cloudDisks = ['s3', 'wasabi'];
        $downloadFilePath = $file->file_path . '/' . $file->file_name;
        if (in_array($file->type, $cloudDisks)) {
            $disk = Storage::disk($file->type); // Dynamically select cloud disk
            if (!$disk->exists($downloadFilePath)) {
                abort(404, 'File not found.');
            }

            return Storage::disk('s3')->response($downloadFilePath);
        } elseif ($file->type === "local") {
            return response()->download($file->file_path . '/' . $file->file_name, 'downloaded_image.jpg');
        } else {
            $notify[] = ['error', 'Sorry, Image not found.'];
            return back()->withNotify($notify);
        }
    }

    public function cloudStorageUpload($filePath, $fileName, $file, $filetype = '')
    {
        $storageProvider = StorageProvider::where('status', 1)->first();
        if (!$storageProvider) {
            throw new \Exception("No active storage provider found.");
        }

        $cloudDisks = ['s3', 'wasabi'];
        $filetype = trim($filetype, '/') . '/';

        $fullPath = $filetype . $fileName;
        if (in_array($storageProvider->alias, $cloudDisks)) {
            if (!Storage::disk($storageProvider->alias)->exists($filetype)) {
                Storage::disk($storageProvider->alias)->makeDirectory($filetype);
            }
            Storage::disk($storageProvider->alias)->put($fullPath, $file);
        } else {
            $file->save($filePath . $fileName);
        }
    }
}
