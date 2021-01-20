<?php

namespace App\Http\Controllers;

use App\Models\Cottage;
use App\Models\Equipment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function reserve($id,Request $request)
    {



        $user = Auth::user();
        //
        //dd($user->email);
        $cottage = DB::table('cottage')->where('id',$id)->get();

        $ownerID = DB::table('users')->where('email', $cottage[0]->owner)->get();
        if ($user != null) {
            if($this->reserved($id, $user->id))
            {
                if ($user->id != $ownerID[0]->id ) {
                    $reservation = new Reservation();
                    $reservation->customer_id = $user->id;
                    $reservation->cottage_id = $id;
                    $reservation->owner_id = $ownerID[0]->id;
                    $reservation->save();

//                    DB::table('equipment')->insert(array('mower'=>true,
//                        'television'=>false,
//                        'microwave'=>false,
//                        'blankets'=>false,
//                        'reservation_id'=>'69'));
//                    $equipment = new Equipment();
//
//                    $equipment->mower = 1;
//                    $equipment->television = 0;
//                    $equipment->microwave =  1;
//                    $equipment->blankets = 0;
//                    $equipment->reservation_id = 65;
//                    $equipment->save();


                    echo redirect()->route('homepage')->with('cottage_message', 'cottage was successfully reserved');
                } else {
                    echo redirect()->route('homepage')->with('cottage_message', 'u are owner of cottage u cant reserve');
                }
            }
            else {
                echo redirect()->route('homepage')->with('cottage_message', 'u have already reserved this cottage');
            }
        } else {
            echo redirect()->route('homepage')->with('cottage_message', 'u have to login to reserve');
        }
    }

    public function reserved($cottageID, $customer_id)
    {
        if(count(DB::table('table_reservations')
            ->where('cottage_id', $cottageID)
            ->where('customer_id', $customer_id)
            ->get())
                >0)
        {
            return false;
        }
        return true;
    }

}
