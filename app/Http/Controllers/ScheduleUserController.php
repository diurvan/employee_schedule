<?php

namespace App\Http\Controllers;

use App\Models\Schedule_User;
use App\Models\Schedule_User_Booking;
use App\Models\Schedule_User_Detail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class ScheduleUserController extends Controller
{
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
            Log::debug($ex);
            DB::rollback();
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



    public function date(Integer $id)
    {
        $booking = Schedule_User_Booking::where('', $id);
        return view('schedule.date', compact('schedule'));
    }

}
