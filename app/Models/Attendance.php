<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
    'date',
    'time_in',
    'time_out',
    // 'latlon_in',
    // 'latlon_out',
    'user_id',
    'school_name',
    'jurusan',
];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
