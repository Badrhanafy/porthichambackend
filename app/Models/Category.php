<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'coverpath'
    ];
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
