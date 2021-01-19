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
}
