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
        'image',
        'desc',
        'locality',
        'num_ppl',
        'owner'
    ];

    public function hasReservations(){
        return $this->belongsTo(Reservation::class,'id');
    }
}
