<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function reserve($cottageID, $owner)
    {
        $user = Auth::user();
        //dd($owner);
        //dd($user->email);
        $ownerID = DB::table('users')->where('email', $owner)->get();
        if ($user != null) {
            if($this->reserved($cottageID, $user->id))
            {
                if ($user->id != $ownerID[0]->id ) {
                    $reservation = new Reservation();
                    $reservation->customer_id = $user->id;
                    $reservation->cottage_id = $cottageID;
                    $reservation->owner_id = $ownerID[0]->id;
                    $reservation->save();
                    return redirect()->route('homepage')->with('cottage_message', 'cottage was successfully reserved');
                } else {
                    return redirect()->route('homepage')->with('cottage_message', 'u are owner of cottage u cant reserve');
                }
            }
            else {
                return redirect()->route('homepage')->with('cottage_message', 'u have already reserved this cottage');
            }
        } else {
            return redirect()->route('homepage')->with('cottage_message', 'u have to login to reserve');
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
