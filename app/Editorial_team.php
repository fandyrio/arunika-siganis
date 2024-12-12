<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial_team extends Model
{
    use HasFactory;
    protected $table="editorial_team";
    protected $fillable=['id_pegawai', 'sebagai', 'active'];
}
