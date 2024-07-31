<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BuildingModels extends Model
{
    protected $table = 'building';
    protected $fillable = [
        'id',
        'date',
        'value',
        'building',
        'value',
    ];
}
