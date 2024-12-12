<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review_stage extends Model
{
    use HasFactory;
    protected $table="review_stage";
    protected $fillable=["id_artikel", 'review_ke', 'catatan_reviewer', 'edoc_catatan_reviewer', 'catatan_penulis', 'send_author_at', 'send_reviewer_at', 'edoc_perbaikan_penulis'];
}
