<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publish_artikel extends Model
{
    use HasFactory;
    protected $table="publish_artikel";
    protected $fillable=['id', 'id_artikel', 'text_tulisan',  'edoc', 'edoc_pdf', 'publish_at'];
}
