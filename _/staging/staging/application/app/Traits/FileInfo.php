<?php

namespace App\Traits;

trait FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This trait basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo()
    {
        $data['withdrawVerify'] = [
            'path' => 'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      => 'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      => 'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/general/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/general',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/plugins',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['storage'] = [
            'path'      => 'assets/images/storages',
            'size'      => '512x512',
        ];
        $data['userProfile'] = [
            'path'      => 'assets/images/user/profile',
            'size'      => '350x300',
        ];
        $data['adminProfile'] = [
            'path'      => 'assets/admin/images/profile',
            'size'      => '400x400',
        ];
        $data['bannerOne'] = [
            'path'      => 'assets/images/frontend/banner',
        ];
        $data['bannerTwo'] = [
            'path'      => 'assets/images/frontend/banner',
        ];
        $data['category'] = [
            'path'      => 'assets/images/category',
            'size'      => '195x146',
        ];
        $data['work'] = [
            'path'      => 'assets/images/frontend/work_process'
        ];
        $data['creative'] = [
            'path'      => 'assets/images/frontend/creative_resource'
        ];
        $data['file'] = [
            'path'      => 'assets/images/frontend/files'
        ];
        $data['media'] = [
            'path'      => 'assets/images/frontend/files/media/'
        ];
        $data['preview'] = [
            'path'      => 'assets/images/frontend/files/preview/'
        ];
        $data['watermark'] = [
            'path'      => 'assets/images/frontend/files/watermark/'
        ];
        $data['others'] = [
            'path'      => 'assets/images/frontend/others'
        ];
        $data['reviewerProfile'] = [
            'path'      => 'assets/admin/images/profile/reviewer',
            'size'      => '400x550',
        ];

        $data['neighborhood'] = [
            'path'      => 'assets/images/neighborhood',
            'size'      => '700x500',
        ];
        $data['county'] = [
            'path'      => 'assets/images/county',
            'size'      => '700x500',
        ];
        $data['building'] = [
            'path'      => 'assets/images/building',
            'size'      => '700x500',
            'thumb'      => '500x375',
            'watermark'      => '500x375',
        ];

        $data['building_watermark'] = [
            'path'      => 'assets/images/building/watermark'
        ];

        $data['listing_asset_image'] = [
            'path'      => 'assets/images/listing_asset_image',
            'size'      => '700x500',
            'thumb'      => '500x350',
            'watermark'      => '500x350',
        ];

        $data['listing_asset_image_watermark'] = [
            'path'      => 'assets/images/listing_asset_image/watermark'
        ];

        $data['zip_image_bundle'] = [
            'path'      => 'assets/images/zip_image_bundle/',

        ];
        return $data;
    }
}
