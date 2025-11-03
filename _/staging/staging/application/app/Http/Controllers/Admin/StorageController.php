<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\StorageProvider;
use App\Http\Controllers\Controller;

class StorageController extends Controller
{
    public function index()
    {
        $pageTitle = 'Storage Logs';
        $storageProviders = StorageProvider::latest()->paginate(getPaginate());
        return view('admin.storage.index', compact('pageTitle', 'storageProviders'));
    }

    public function edit(StorageProvider $storageProvider)
    {
        $pageTitle = 'Edit Storage Provider';
        return view('admin.storage.edit', compact('pageTitle', 'storageProvider'));
    }

    public function update(Request $request, StorageProvider $storageProvider)
    {
        if ($request->has('credentials')) {
            foreach ($request->credentials as $key => $value) {
                if (!array_key_exists($key, (array) $storageProvider->credentials)) {
                    if (empty($value['name'])) {
                        $notify[] = ['error', "Don't match API credentials"];
                        return back()->withNotify($notify);
                    }
                }
            }
        }
        $storageProviders = StorageProvider::all()->except($storageProvider->id);
        if ($request->status) {
            foreach ($storageProviders ?? [] as $provider) {
                $provider->status = 0;
                $provider->save();
            }
        } else {
           
            $default = StorageProvider::first();
            $default->status = 1;
            $default->save();
            updateEnvironmentVariable('FILESYSTEM_DRIVER', $default->alias);
        }
        

        $storageProvider->status = $request->status ?? 0;
        $storageProvider->credentials = $request->credentials;
       $oldImage = $storageProvider->logo;
        if ($request->hasFile('image')) {
            try {
                $storageProvider->logo = fileUploader($request->image, getFilePath('storage'), getFileSize('storage'),$oldImage);
            } catch (Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $storageProvider->save();

        if ($request->status) {

            updateEnvironmentVariable('FILESYSTEM_DRIVER', $storageProvider->alias);
            if ($storageProvider->id != 1) {
        
                $storageProvider->handler::setCredentials($storageProvider);
            }

        }
        $notify[] = ['success', 'Updated Successfully'];
        return back()->withNotify($notify);
    }


    public function defaultStatus()
    {
        $allStatusZero = StorageProvider::where('status', '!=', 0)->doesntExist();
        if ($allStatusZero) {
            $default = StorageProvider::first();
            $default->status = 1;
            $default->save();
            updateEnvironmentVariable('FILESYSTEM_DRIVER', $default->alias);
        }
        return $allStatusZero;
    }

    function status(Request $request)
    {
        $storageProviders = StorageProvider::all()->except($request->id);
        foreach ($storageProviders ?? [] as $provider) {
            $provider->status = 0;
            $provider->save();
        }
        $storageProvider = StorageProvider::where('id', $request->id)->first();
        if ($storageProvider->status == 1) {
            $storageProvider->status = 0;
            $storageProvider->save();
            $notify[] = ["success", "Status Inactive successfully."];
            $this->defaultStatus();
        } elseif ($storageProvider->status == 0) {
            $storageProvider->status = 1;
            $storageProvider->save();
            $notify[] = ["success", "Status Active successfully."];
        }
        updateEnvironmentVariable('FILESYSTEM_DRIVER', $storageProvider->alias);
        return back()->withNotify($notify);
    }
}