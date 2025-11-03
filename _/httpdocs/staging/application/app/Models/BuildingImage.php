<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingImage extends Model
{
    use HasFactory;

    public function imageCategory()
    {
        return $this->belongsTo(ImageCategory::class, 'image_category_id', 'id');
    }
  

    
}
