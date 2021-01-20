<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';

    protected $fillable = [
        'blankets'=>'boolean',
        'television'=>'boolean',
        'mower'=>'boolean',
        'microwave'=>'boolean',
        'reservation_id'
    ];
    /**
     * @var mixed
     */

    public function reservations(){
        return $this->belongsTo(Reservation::class,'reservation_id','id');
    }
}
