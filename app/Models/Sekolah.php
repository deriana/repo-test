<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat'
    ];

    protected $table = 'sekolah';

    public function jurusan()
    {
        return $this->hasMany(Jurusan::class);
    }
}
