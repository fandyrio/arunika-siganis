<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis_artikel extends Model
{
    use HasFactory;
    protected $table='penulis_artikel';
    protected $fillable=['id_pegawai', 'nama', 'nip', 'no_handphone', 'satker', 'jabatan', 'pangkat'];
}
