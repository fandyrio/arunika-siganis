<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman_arunika extends Model
{
    use HasFactory;
    protected $table="pengumuman_arunika";
    protected $fillable=["id", "judul", "edoc", "keterangan"];
}
