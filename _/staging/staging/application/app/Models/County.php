<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class County extends Model
{
    use HasFactory;

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }
    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }

    public function neighborhoods(){
        return $this->hasMany(Neighborhood::class,'county_id','id');
    }


    public function badgeData(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--danger">'.trans('Deactivated').'</span>';
        }
        elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Activated').'</span>';
        }
        return $html;
    }
}
