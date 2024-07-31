<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasicInformationModel extends Model

{
    protected $table = 'basic_information';
    protected $fillable = [
        'id',
        'key',
        'value',

    ];
}
