<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil_reviewer extends Model
{
    use HasFactory;
    protected $table="catatan_hasil_reviewer";
    protected $fillable=['id_review', 'hasil_review', 'keterangan', 'active'];
}
