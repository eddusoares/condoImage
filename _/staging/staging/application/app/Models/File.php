<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class File extends Model
{
    use HasFactory;

    protected $casts = [
        'tags' => 'object',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reviewer(){
        return $this->belongsTo(Reviewer::class, 'reviewer_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function badgeData(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }
        elseif($this->status == 1){
            $html = '<span class="badge badge--primary">'.trans('Published').'</span>';
        }
        elseif($this->status == 2){
            $html = '<span class="badge badge--danger">'.trans('Rejected').'</span>';
        }
        elseif($this->status == 3){
            $html = '<span class="badge bg-dark">'.trans('On Reviewing').'</span>';
        }
        return $html;
    }
}
