<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageModels extends Model
{
    protected $table = 'images';
    protected $fillable = [
        'id',
        'id_basic_info',
        'name_img',
        'content',
        'display',
    ];
}
