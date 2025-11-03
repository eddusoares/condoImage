<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    public function buildingOrListing($id,$type){
        if($type == 'building'){
            $building = Building::where('id',$id)->first();
      
            return $building->name;
        }else{
            $listing = ListingUnit::where('id',$id)->first();
         
            return $listing->unit_number;
        }

    }
}
