<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adds extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $appends = ['img'];

    public function getImgAttribute()
    {
        return imageRecover($this->img_body);
    }
}
