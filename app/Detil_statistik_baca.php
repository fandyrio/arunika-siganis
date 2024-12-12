<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detil_statistik_baca extends Model
{
    use HasFactory;
    protected $table="detil_statistik_baca";
    protected $fillable=["id", 'unique_visitor_id', 'id_artikel'];
}
