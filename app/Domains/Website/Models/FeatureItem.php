<?php

namespace App\Domains\Website\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureItem extends Model
{
    protected $fillable = ['icon', 'title', 'description', 'image', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
