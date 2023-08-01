<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionList extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $appends = ['original', 'converted'];

    public function getOriginalAttribute()
    {
        return imageRecoverNull($this->original_url);
    }

    public function getConvertedAttribute()
    {
        return imageRecoverNull($this->file_url);
    }

    public function history()
    {
        return $this->belongsTo(ConversionHistory::class, 'conversion_history_id', 'id');
    }
}
