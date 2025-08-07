<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'alasan', 'tanggal'];

public function user()
{
    return $this->belongsTo(User::class);
}

}
