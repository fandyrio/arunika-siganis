<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist_review extends Model
{
    use HasFactory;
    protected $table="checklist_review";
    protected $fillable=['pertanyaan', 'active'];
}
