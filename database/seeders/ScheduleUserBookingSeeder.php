<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Schedule_User;
use App\Models\Schedule_User_Booking;
use App\Models\Schedule_User_Detail;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ScheduleUserBookingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($mes = 10; $mes <= 11; $mes++) {
            $schedule_user = Schedule_User::whereMonth('schedule_date', $mes)
            ->whereDay('schedule_date', '<=', 10)
            ->orderBy('id_user')
            ->get();
            // Log::debug(json_encode($schedule_user));
    
            for ($i = 0; $i < count($schedule_user); $i++) {
                $data = [
                    ['id_user' => $schedule_user[$i]->id_user, 'id_schedule_user' => $schedule_user[$i]->id, 'book_date' => $schedule_user[$i]->schedule_date,
                    'type'=>'meeting', 'book_start'=>'09:00', 'book_end'=>'09:59'],
                ];                
                Schedule_User_Booking::insert($data);
            }
        }
        
    }
}
