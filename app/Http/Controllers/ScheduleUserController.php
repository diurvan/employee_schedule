<?php

namespace App\Http\Controllers;

use App\Models\Schedule_User;
use App\Models\Schedule_User_Detail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class ScheduleUserController extends Controller
{

    protected function compare_times_in_hours($start_time, $end_time){
        $inicioTimestamp = strtotime($start_time);
        $finTimestamp = strtotime($end_time);

        $diferenciaSegundos = $finTimestamp - $inicioTimestamp;
        $diferenciaHoras = $diferenciaSegundos / 3600;
        return $diferenciaHoras;
    }

    public function index()
    {
        $schedules = Schedule_User::join('schedule_user_detail', 'schedule_user.id', '=', 'schedule_user_detail.id_schedule_user')
        ->select(
            'schedule_user.id',
            'schedule_user.id_user',
            'schedule_user.schedule_date',
            DB::raw("MAX(CASE WHEN schedule_user_detail.type = 'available' THEN schedule_user_detail.schedule_start END) AS available_start"),
            DB::raw("MAX(CASE WHEN schedule_user_detail.type = 'available' THEN schedule_user_detail.schedule_end END) AS available_end"),
            DB::raw("MAX(CASE WHEN schedule_user_detail.type = 'eating' THEN schedule_user_detail.schedule_start END) AS eating_start"),
            DB::raw("MAX(CASE WHEN schedule_user_detail.type = 'eating' THEN schedule_user_detail.schedule_end END) AS eating_end")
        )
        ->groupBy('schedule_user.id', 'schedule_user.id_user', 'schedule_user.schedule_date')
        ->get();
        return view('schedule.index', compact('schedules'));           
    }

    public function create()
    {
        $users = User::where('profile', 'medic')->get();
        return view('schedule.create', compact('users'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'id_user' => 'required|integer',
            'schedule_start' => 'required|date_format:H:i',
            'schedule_end' => 'required|date_format:H:i',
            'eating_schedule_start' => 'required|date_format:H:i',
            'eating_schedule_end' => 'required|date_format:H:i'
        ]);

        try{
            // echo $this->compare_times_in_hours($request->schedule_start, $request->schedule_end);
            // echo $this->compare_times_in_hours($request->eating_schedule_start, $request->eating_schedule_end);
            // return;


            if($this->compare_times_in_hours($request->schedule_start, $request->schedule_end) != 7){
                return redirect()->route('admin.scheduleuser.index')
                ->withErrors(['general' => 'Available times must be 7 hours']);
            }
            if($this->compare_times_in_hours($request->eating_schedule_start, $request->eating_schedule_end) != 1){
                return redirect()->route('admin.scheduleuser.index')
                ->withErrors(['general' => 'Eating times must be 1 hour']);
            }

            DB::begintransaction();
    
            $schedule_created = Schedule_User::create($request->all());
            Schedule_User_Detail::create(array(
                'id_schedule_user' => $schedule_created->id,
                'type' => 'available',
                'schedule_start' => $request->schedule_start,
                'schedule_end' => $request->schedule_end
            ));
            Schedule_User_Detail::create(array(
                'id_schedule_user' => $schedule_created->id,
                'type' => 'eating',
                'schedule_start' => $request->eating_schedule_start,
                'schedule_end' => $request->eating_schedule_end
            ));
            DB::commit();

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.scheduleuser.index')
            ->withErrors(['general' => 'There was an error on saving times.Try again.']);
        }
        return redirect()->route('admin.scheduleuser.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $schedule = Schedule_User::findOrFail($id);
        return view('schedule.edit', compact('schedule'));
    }

    public function update(Request $request, string $id)
    {
         // Validar los datos del formulario
         $request->validate([
            'type' => 'required|in:available,eating,out'
        ]);

        // Buscar el estudiante por su ID
        $schedule = Schedule_User::findOrFail($id);

        // Actualizar los datos del estudiante
        $schedule->update($request->all());

        // Redireccionar a la vista de listado de estudiantes
        return redirect()->route('admin.scheduleuser.index');
    }

    public function destroy(string $id)
    {
        $schedule = Schedule_User::findOrFail($id);

        $schedule->delete();

        return redirect()->route('admin.scheduleuser.index');
    }


    // public function date(Integer $id)
    // {
    //     $bookings = Schedule_User_Booking::where('id_schedule_user', $id);
    //     Log::debug('entro');
    //     return view('schedule.date', compact('bookings'));
    // }    
    // public function datestore(Request $request)
    // {
    //     $request->validate([
    //         'id_schedule_user' => 'required|integer',
    //         'type' => 'required|in:meeting,other',
    //         'book_start' => 'required|date_format:H:i',
    //         'book_end' => 'required|date_format:H:i'
    //     ]);

    //     try{
    //         Schedule_User_Booking::create($request->all());
    //     }catch(Exception $ex){
    //         return redirect()->route('admin.scheduleuser.date')
    //         ->withErrors(['general' => 'Hubo un error al guardar el horario. Por favor, inténtalo de nuevo.']);
    //     }
    //     return redirect()->route('admin.scheduleuser.date');
    // }

}
