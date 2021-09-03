<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelajaran extends Model
{
    public $table = "pelajaran";

    use HasFactory;

    protected $fillable = [
        'nama',
        'kkm',
        'tapel_nama',
        'kelas_nama',
        'tipepelajaran',
        'jurusan',
    ];
}