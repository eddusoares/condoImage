<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;
    protected $casts = ['tags' => 'object'];

    public function userHasClaimed($building)
    {
        if (auth()->user()->user_type == 2 && $building->claim == 2 && $building->claim_by == auth()->id()) {
           
            return true;
        }
        return false;
    }

    public function adminHasClaimed($building)
    {

        if ($building->claim == 1) {
            return true;
        }
        return false;
    }

    public function imageUploadAuthor($building)
    {
        if ($building->claim == 1) {
            $admin = Admin::first();
            return $admin->name;
        } else {
            $user = User::where('id', $building->claim_by)->first();
            return optional($user)->fullname ?? 'Unknown User';
        }
    }


    public function buildingImages()
    {
        return $this->hasMany(BuildingImage::class, 'building_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'building_id', 'id');
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn() => $this->badgeData(),
        );
    }

    public function badgeData()
    {
        $html = '';
        if ($this->status == 2) {
            $html = '<span class="badge badge--danger">' . trans('Deactivated') . '</span>';
        } elseif ($this->status == 1) {
            $html = '<span class="badge badge--success">' . trans('Activated') . '</span>';
        }
        return $html;
    }


    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class, 'neighborhood_id', 'id');
    }


    public function buildingImagesCategoryDescriptions()
    {
        return $this->hasMany(ImageCategoryDescription::class, 'building_id', 'id');
    }

    public function buildingListingUnits()
    {
        return $this->hasMany(ListingUnit::class, 'building_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'building_id', 'id');
    }

    public function scopeAll()
    {
        return $this->all();
    }

    public function scopePending($query)
    {
        return $query->where('status', 2);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getStatusText()
    {
        return $this->status == 1 ? trans('Deactivated') : ($this->status == 2 ? trans('Activated') : '');
    }
}
