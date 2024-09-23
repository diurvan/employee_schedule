<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Schedule_User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "schedule_user";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'schedule_date',
        'id_user'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function detail()
    {
        return $this->hasMany(Schedule_User_Detail::class, 'id_schedule_user');
    }

}
