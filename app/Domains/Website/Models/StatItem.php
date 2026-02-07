<?php

namespace App\Domains\Website\Models;

use Illuminate\Database\Eloquent\Model;

class StatItem extends Model
{
    protected $fillable = ['icon', 'value', 'label', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
