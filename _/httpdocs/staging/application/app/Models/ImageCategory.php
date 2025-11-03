<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCategory extends Model
{
    use HasFactory;


    public function findImageCategoryDescription($buildingId, $imageCategoryId)
    {
       $imageCategoryDescription = ImageCategoryDescription::where('building_id', $buildingId)->where('image_category_id', $imageCategoryId)->first();
    
       return $imageCategoryDescription->description ?? '';
    }
}
