<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'table_reservations';

    protected $fillable = [
            'customer_id',
            'owner_id',
            'cottage_id'
    ];


    public function owners(){
        return $this->belongsTo(User::class, 'owner_id','id');
    }

    public function customers(){
        return $this->belongsTo(User::class, 'customer_id','id');
    }

    public function hasCottages(){
        return $this->hasMany(Cottage::class,'id');
    }
    public function hasEquipment(){
        return $this->hasMany(Equipment::class, 'reservation_id','id');
    }
}
