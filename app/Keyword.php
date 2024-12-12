<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    use HasFactory;
    protected $table="keyword_artikel";
    protected $fillable=['id_artikel', 'keyword'];
}
