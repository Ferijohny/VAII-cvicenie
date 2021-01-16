<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cottage extends Model
{
    use HasFactory;
    protected $table = 'cottage';

    protected $fillable = [
        'name',
        'img_path',
        'desc',
    ];
}
