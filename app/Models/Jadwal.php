<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'hari',
        'nama_guru',
        'pelajaran',
        'jam_masuk',
        'jam_keluar',
        'foto_guru',
    ];
}
