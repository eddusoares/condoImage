<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn () => $this->badgeData(),
        );
    }

    public function badgeData()
    {
        $html = '';
        if ($this->status == 0) {
            $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
        } elseif ($this->status == 1) {
            $html = '<span class="badge badge--base">' . trans('Approved') . '</span>';
        }
        return $html;
    }

    
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

      public function buildingListingUnit()
    {
        return $this->belongsTo(ListingUnit::class, 'listing_unit_id', 'id');
    }

    public function useName($userId){
     
         $user = User::findOrFail($userId);

         return $user->fullname;

    }
}
