<?php

namespace App\Domains\Website\Models;

use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    protected $fillable = ['question', 'answer', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
