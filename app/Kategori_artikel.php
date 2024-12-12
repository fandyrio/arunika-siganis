<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_artikel extends Model
{
    use HasFactory;
    protected $table='kategori_artikel';
    protected $fillable=['kode', 'kategori'];
}
