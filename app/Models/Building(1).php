<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    public $table = 'buildings';

    use HasFactory,SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'name',
        'units',
        'parking_space',
    ];  
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Log all attributes, not just the specified ones
            ->useLogName('building') // Optional: name the log
            ->logOnlyDirty() // Continue to track changes
            ->dontSubmitEmptyLogs(); // Prevent empty logs if nothing is detected to be logged
    }
    // Define the apartments relationship
    public function apartments()
    {
        return $this->hasMany(Appartment::class);
    }
}


