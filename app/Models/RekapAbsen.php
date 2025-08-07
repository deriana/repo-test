<?php

// app/Models/Attendance.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'date',
        'time_in',
        'time_out',
        'latlon_in',
        'latlon_out',
        'user_id',
        'school_name',
        'jurusan',
    ];

    public function getStatusAttribute($value)
{
    if ($value) return $value;

    if (!$this->time_in) return null;

    $jamMasuk = Carbon::createFromFormat('H:i:s', $this->time_in);
    $batasMasuk = Carbon::createFromTime(8, 0, 0); // jam 8 pagi

    return $jamMasuk->gt($batasMasuk) ? 'Terlambat' : 'Hadir';
}

}


