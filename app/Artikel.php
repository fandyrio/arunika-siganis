<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;
    protected $table='artikel';
    protected $fillable=['id_penulis', 'foto_penulis', 'judul', 'kategori_artikel_kode', 'edoc_artikel', 'tentang_artikel', 'step'];
}
