<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    
    public function product()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
