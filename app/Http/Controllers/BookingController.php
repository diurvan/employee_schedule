<?php

namespace App\Http\Controllers;

use App\Models\Schedule_User;
use App\Models\Schedule_User_Booking;
use App\Models\Schedule_User_Detail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{

    protected function isTimeBetween($start, $end, $check) {
        $startTime = strtotime($start);
        $endTime = strtotime($end);
        $checkTime = strtotime($check);
    
        return ($checkTime >= $startTime && $checkTime <= $endTime);
    }
    
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
            $schedule_user_detail = Schedule_User_Detail::where('id_schedule_user', $request->id_schedule_user)->get();

            $schedule_available = null;
            $schedule_eating = null;
            for ($i = 0; $i < count($schedule_user_detail); $i++) {
                if($schedule_user_detail[$i]->type=='eating'){
                    $schedule_eating = $schedule_user_detail[$i];
                }
                if($schedule_user_detail[$i]->type=='available'){
                    $schedule_available = $schedule_user_detail[$i];
                }
            }

            if ( !($this->isTimeBetween($schedule_available->schedule_start, $schedule_available->schedule_end, $request->book_start))) {
                $error_schedule[] = 'Start Booking out of available times';
            }
            if ( !($this->isTimeBetween($schedule_available->schedule_start, $schedule_available->schedule_end, $request->book_end))) {
                $error_schedule[] = 'End Booking out of available times';
            }

            if ($this->isTimeBetween($schedule_eating->schedule_start, $schedule_eating->schedule_end, $request->book_start)) {
                $error_schedule[] = 'Start Booking out of eating times';
            }
            if ($this->isTimeBetween($schedule_eating->schedule_start, $schedule_eating->schedule_end, $request->book_end)) {
                $error_schedule[] = 'End Booking out of eating times';
            }



            $schedule_user_booking_found = Schedule_User_Booking::whereBetween('book_start', [$request->book_start, $request->book_end])
            ->orWhereBetween('book_end', [$request->book_start, $request->book_end])
            ->where('id_schedule_user', $request->id_schedule_user)
            ->get();
            if($schedule_user_booking_found){
                $error_schedule[] = 'Time between '.$request->book_start.' and '.$request->book_end.' is busy ';
            }










            if(isset($error_schedule)){
                return redirect()->route('admin.booking.show', $request->id_schedule_user)
                ->withErrors($error_schedule);
            }else{
                $data_booking = array(
                    'id_user' => $schedule_user->id_user,
                    'id_schedule_user'=>$request->id_schedule_user,
                    'book_date'=>$schedule_user->schedule_date,
                    'type'=>$request->type,
                    'book_start'=>$request->book_start,
                    'book_end'=>$request->book_end
                );
                Schedule_User_Booking::create($data_booking);
            }
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
