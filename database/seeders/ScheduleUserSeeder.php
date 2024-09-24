<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Schedule_User;
use App\Models\Schedule_User_Booking;
use App\Models\Schedule_User_Detail;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ScheduleUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $fechaInicio = new DateTime('2024-10-01');
        $fechaFin = new DateTime('+2 months');
        // Creamos un arreglo para almacenar las fechas válidas
        $fechasValidas = [];
        
        while ($fechaInicio <= $fechaFin) {
            // Verificamos si el día de la semana es Lunes a Viernes (1 a 5)
            $diaSemana = $fechaInicio->format('N'); // 1 (Lunes) a 7 (Domingo)
            if ($diaSemana >= 1 && $diaSemana <= 5) {
                $fechasValidas[] = $fechaInicio->format('Y-m-d');
            }
            $fechaInicio->modify('+1 day');
        }
        
        for($j=0; $j < count($fechasValidas); $j++){
            for ($i = 1; $i <= 10; $i++) {
                $schedule_user = Schedule_User::create([
                    'id_user' => $i,
                    'schedule_date'=>$fechasValidas[$j]
                ]);
                
                Schedule_User_Detail::create([
                    'id_schedule_user' => $schedule_user->id,
                    'type'=>'available',
                    'schedule_start'=>'09:00',
                    'schedule_end'=>'16:00'
                ]);
                Schedule_User_Detail::create([
                    'id_schedule_user' => $schedule_user->id,
                    'type'=>'eating',
                    'schedule_start'=>'13:00',
                    'schedule_end'=>'14:00'
                ]);
            }

            // $timestamp = strtotime($fechasValidas[$j]);
            // $day = date('l', $timestamp);

            // if($day > 1 && $day < 8){
            //     for ($b = 1; $b <= 5; $b++) {
            //         Schedule_User_Booking::create([
            //             'id_user' => $i,
            //             'id_schedule_user' => $schedule_user->id,
            //             'book_date' => $schedule_user->schedule_date,
            //             'type'=>'meeting',
            //             'book_start'=>'09:00',
            //             'book_end'=>'10:00'
            //         ]); 
            //     }
            // }
        }

        



        // $schedule_user = Schedule_User::get()->sortBy('id_user');
        // $current_user = 0; $count_booking = 0;
        // if(count($schedule_user)){
        //     $current_user = $schedule_user[0]->id_user;
        // }
        // for ($i = 0; $i < count($schedule_user); $i++) {
        //     if($current_user == $schedule_user[$i]->id_user){                
        //         // $timestamp = strtotime($schedule_user[$i]->schedule_date);
        //         // $day = date('l', $timestamp);
        //         if($count_booking < 2){
        //             $data = [
        //                 ['id_user' => $current_user, 'id_schedule_user' => $schedule_user[$i]->id, 'book_date' => $schedule_user[$i]->schedule_date,
        //                 'type'=>'meeting', 'book_start'=>'09:00', 'book_end'=>'09:59'],
        //                 ['id_user' => $current_user, 'id_schedule_user' => $schedule_user[$i]->id, 'book_date' => $schedule_user[$i]->schedule_date,
        //                 'type'=>'meeting', 'book_start'=>'10:00', 'book_end'=>'10:59'],
        //                 ['id_user' => $current_user, 'id_schedule_user' => $schedule_user[$i]->id, 'book_date' => $schedule_user[$i]->schedule_date,
        //                 'type'=>'meeting', 'book_start'=>'11:00', 'book_end'=>'11:59'],
        //                 ['id_user' => $current_user, 'id_schedule_user' => $schedule_user[$i]->id, 'book_date' => $schedule_user[$i]->schedule_date,
        //                 'type'=>'meeting', 'book_start'=>'12:00', 'book_end'=>'12:59'],
        //                 ['id_user' => $current_user, 'id_schedule_user' => $schedule_user[$i]->id, 'book_date' => $schedule_user[$i]->schedule_date,
        //                 'type'=>'meeting', 'book_start'=>'14:00', 'book_end'=>'14:59'],
        //                 ['id_user' => $current_user, 'id_schedule_user' => $schedule_user[$i]->id, 'book_date' => $schedule_user[$i]->schedule_date,
        //                 'type'=>'meeting', 'book_start'=>'15:00', 'book_end'=>'15:59']
        //             ];                
        //             Schedule_User_Booking::insert($data);
        //             $count_booking++;
        //             $data = [];
        //         }
        //         // Schedule_User_Booking::create([
        //         //     'id_user' => $current_user,
        //         //     'id_schedule_user' => $schedule_user[$i]->id,
        //         //     'book_date' => $schedule_user[$i]->schedule_date,
        //         //     'type'=>'meeting',
        //         //     'book_start'=>'09:00',
        //         //     'book_end'=>'10:00'
        //         // ]);
        //     }else{
        //         $count_booking = 0;
        //     }
        //     // if( isset($schedule_user[$i+1]) && $current_user != $schedule_user[$i+1]->id_user){
        //     //     $count_booking = 0;
        //     // }
        //     $current_user = $schedule_user[$i]->id_user;
        // }
        
    }
}
