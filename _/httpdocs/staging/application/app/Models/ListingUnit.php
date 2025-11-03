<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingUnit extends Model
{
    use HasFactory;

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


    public function userable()
    {
        return $this->morphTo();
    }


    public function author()
    {
        if (!$this->userable) return '';

        if ($this->userable_type === 'user' && $this->userable) {
            return "<a href='" . route('admin.users.detail', $this->userable->id) . "'>" . $this->userable->username . "</a>";
        }

        if ($this->userable_type === 'admin' && $this->userable) {
            return "<a href='javascript:void(0)'>" . $this->userable->name . "</a>";
        }
    }

    public function isAdminAuthor(){

        if (!$this->userable) return 0;
        
        if ($this->userable_type === 'admin' && $this->userable_id == auth('admin')->id()) {
            return 1;
        }
        return 0;
    }

    public function isUserAuthor(){

        if (!$this->userable) return 0;
        if ($this->userable_type === 'user' && $this->userable_id == auth()->id()) {
            return 1;
        }
        return 0;
    }


    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id', 'id');
    }

    public function listingImages()
    {
        return $this->hasMany(ListingImage::class, 'listing_unit_id', 'id');
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
