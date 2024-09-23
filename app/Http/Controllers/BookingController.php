<?php

namespace App\Http\Controllers;

use App\Models\Schedule_User;
use App\Models\Schedule_User_Booking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    
    public function index()
    {
        //
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_schedule_user' => 'required|integer',
            'type' => 'required|in:meeting,other',
            'book_start' => 'required|date_format:H:i',
            'book_end' => 'required|date_format:H:i'
        ]);

        try{
            $schedule_user = Schedule_User::findOrFail($request->id_schedule_user)->first();
            $data_booking = array(
                'id_user' => $schedule_user->id_user,
                'id_schedule_user'=>$request->id_schedule_user,
                'book_date'=>$schedule_user->schedule_date,
                'type'=>$request->type,
                'book_start'=>$request->book_start,
                'book_end'=>$request->book_end
            );
            Schedule_User_Booking::create($data_booking);
        }catch(Exception $ex){
            Log::debug($ex);
            return redirect()->route('admin.booking.show', $request->id_schedule_user)
            ->withErrors(['general' => 'Hubo un error al guardar el horario. Por favor, inténtalo de nuevo.']);
        }
        return redirect()->route('admin.booking.show', $request->id_schedule_user);
    }

    public function show(string $id)
    {
        $bookings = Schedule_User_Booking::where('id_schedule_user', $id)->get();
        $schedule_user = Schedule_User::where('id', $id)->with('user')->first();
        Log::debug($schedule_user);
        
        return view('booking.index', ['bookings'=>$bookings, 'schedule_user'=>$schedule_user]);
    }

    public function edit(string $id)
    {
        return view('booking.create', ['id' => $id]);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
