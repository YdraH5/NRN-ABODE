<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'category_images';

    use HasFactory;

    protected $fillable = [
        'category_id',
        'description',
        'image'
];

    // public function categoryImage()
    // {
    //     return $this->belongsTo(Category::class);
    // }

}
