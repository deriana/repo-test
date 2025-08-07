<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'sekolah_id',
        'jurusan_id',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function jurusan()
    {
        return $this->belongSTo(Jurusan::class);
    }
}
