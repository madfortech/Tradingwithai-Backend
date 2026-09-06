<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'title',
    'slug',
    'content',
    'is_published',
])]
class Page extends Model
{
    //
}
