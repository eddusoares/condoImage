<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Neighborhood extends Model
{
    use HasFactory;
    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn() => $this->badgeData(),
        );
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id', 'id');
    }

    public function buildings()
    {
        return $this->hasMany(Building::class, 'neighborhood_id', 'id');
    }

    public function badgeData()
    {
        $html = '';
        if ($this->status == 0) {
            $html = '<span class="badge badge--danger">' . trans('Deactivated') . '</span>';
        } elseif ($this->status == 1) {
            $html = '<span class="badge badge--success">' . trans('Activated') . '</span>';
        }
        return $html;
    }


    public function getTotalBuildingImagesCountAttribute()
    {
        return $this->buildings->sum(function ($building) {
            return $building->buildingImages->count();
        });
    }

    public function getTotalListingImagesCountAttribute()
    {
        return $this->buildings->sum(function ($building) {
            return $building->buildingListingUnits->sum(function ($unit) {
                return $unit->listingImages->count();
            });
        });
    }
}
