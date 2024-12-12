<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unique_visitor extends Model
{
    use HasFactory;
    protected $table="unique_visitor";
    protected $fillable=['id', 'ip_address', 'cookie_id', 'device_info', 'last_access'];
}
