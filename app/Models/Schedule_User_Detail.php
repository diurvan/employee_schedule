<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Schedule_User_Detail extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "schedule_user_detail";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_schedule_user',
        'type',
        'schedule_start',
        'schedule_end',
    ];

    
    public function schedule()
    {
        return $this->belongsTo(Schedule_User::class, 'id_schedule_user');
    }

}
