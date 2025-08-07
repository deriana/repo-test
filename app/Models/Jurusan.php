<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'sekolah_id'
    ];

    protected $table = 'jurusan';

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
