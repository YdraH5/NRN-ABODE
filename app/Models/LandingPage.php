<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $table = 'settings';
    public $timestamps = false; // Since your table doesn't have timestamps
    use HasFactory;
    protected $fillable = [
        'discover_description',
        'designed_description',
        'neary_description',
        'apartment_description'
];
}
