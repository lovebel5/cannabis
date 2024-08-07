<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventModels extends Model
{
    protected $table = 'event';
    protected $fillable = [
        'id',
        'id_basic_info',
        'val_json',

    ];
}

