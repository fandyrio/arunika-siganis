<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist_review_result extends Model
{
    use HasFactory;
    protected $table="checklist_review_result";
    protected $primaryKey="id";
    protected $fillable=['id_pertanyaan', 'hasil', 'keterangan'];
}
