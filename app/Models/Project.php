<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'path',
        'is_video',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected $casts = [
        'is_video' => 'boolean',
    ];
}