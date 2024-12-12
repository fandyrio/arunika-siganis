<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewer_artikel extends Model
{
    use HasFactory;
    protected $table="reviewer_artikel";
    protected $fillable=["id_review", "id_pegawai", "id_artikel", 'tgl_pilih', 'tgl_mulai', 'tgl_estimasi_selesai', 'status'];
}
