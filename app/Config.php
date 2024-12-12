<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $table="config";
    protected $fillable=['config_name', 'config_value', 'file_value', 'active'];
}
