<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Schedule_User_Booking extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "schedule_user_booking";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_schedule_user',
        'book_date',
        'type',
        'book_start',
        'book_end',
    ];
}
