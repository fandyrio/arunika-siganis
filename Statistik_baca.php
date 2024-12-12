<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistik_baca extends Model
{
    use HasFactory;
    protected $table="statistik_baca";
    protected $fillable=['id_artikel', 'jumlah'];
}
