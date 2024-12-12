<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step_master extends Model
{
    use HasFactory;
    protected $table="step_master";
    protected $fillable=['step_id', 'step_text'];
}
