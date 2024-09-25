<?php

namespace App\Exports;

use App\Models\Schedule_User;
use App\Models\Schedule_User_Booking;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


use Maatwebsite\Excel\Concerns\WithHeadings;

class MiPrimeraHoja implements FromCollection, WithHeadings
{
    protected $query_datetime;
    function __construct($query_datetime) {
        $this->query_datetime = $query_datetime;
    }
    public function collection()
    {
        // date_default_timezone_set('America/Los_Angeles');

        $query_datetime = $this->query_datetime;
        
        $dateTime = new DateTime($query_datetime);
        // Obtenemos la fecha y la hora por separado
        $fecha = $dateTime->format('Y-m-d');
        $hora = $dateTime->format('H:i');
        
        $dateTime->modify('+59 minutes');
        $hora_end = $dateTime->format('H:i');
        DB::enableQueryLog();
        $schedule_user_found = Schedule_User::where('schedule_user.schedule_date', $fecha)
        ->join('schedule_user_detail', 'schedule_user_detail.id_schedule_user', 'schedule_user.id')
        // ->rightjoin('schedule_user_booking', 'schedule_user_booking.id_schedule_user', 'schedule_user.id')
        ->whereBetween('schedule_user_detail.schedule_start', [$hora, $hora_end])
        ->where('type', 'available')
        // ->whereNotBetween('book_start', [$hora, $hora_end])
        ->get();
        Log::debug(DB::getQueryLog());
        // $schedule_user_booking_found = Schedule_User_Booking::whereBetween('book_start', [$hora, $hora_end])
        // ->where('book_date', $fecha)
        // ->get();
        return $schedule_user_found;
    }

    public function headings(): array
    {
        // Define los encabezados de las columnas
        return ['', '', '', '','', '', '', '',''];
    }
}
class MiSegundaHoja implements FromCollection, WithHeadings
{
    protected $query_datetime;
    function __construct($query_datetime) {
        $this->query_datetime = $query_datetime;
    }
    public function collection()
    {
        // date_default_timezone_set('America/Los_Angeles');

        $query_datetime = $this->query_datetime;
        
        $dateTime = new DateTime($query_datetime);
        // Obtenemos la fecha y la hora por separado
        $fecha = $dateTime->format('Y-m-d');
        $hora = $dateTime->format('H:i');
        
        $dateTime->modify('+59 minutes');
        $hora_end = $dateTime->format('H:i');
        
        // $schedule_user_found = Schedule_User::where('schedule_user.schedule_date', $fecha)
        // ->join('schedule_user_detail', 'schedule_user_detail.id_schedule_user', 'schedule_user.id')
        // // ->rightjoin('schedule_user_booking', 'schedule_user_booking.id_schedule_user', 'schedule_user.id')
        // ->whereBetween('schedule_user_detail.schedule_start', [$hora, $hora_end])
        // ->where('type', 'available')
        // // ->whereNotBetween('book_start', [$hora, $hora_end])
        // ->get();

        $schedule_user_booking_found = Schedule_User_Booking::whereBetween('book_start', [$hora, $hora_end])
        ->where('book_date', $fecha)
        ->get();

        return $schedule_user_booking_found;
    }

    public function headings(): array
    {
        // Define los encabezados de las columnas
        return ['', '', '', '','', '', '', '',''];
    }
}


class BookingExport implements WithMultipleSheets
{
    use Exportable;
    
    protected $query_datetime;
    function __construct($query_datetime) {
        $this->query_datetime = $query_datetime;
    }

    public function sheets(): array
    {
        date_default_timezone_set('America/Los_Angeles');

        $query_datetime = $this->query_datetime;

        $sheets = [];
        array_push($sheets, new MiPrimeraHoja($query_datetime));
        array_push($sheets, new MiSegundaHoja($query_datetime));

        return $sheets;
    }

}
