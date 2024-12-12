<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue_artikel extends Model
{
    use HasFactory;
    protected $table="issue_artikel";
    protected $fillable=['id', 'code_issue', 'name', 'description', 'status', 'cfp', 'year', 'flyer'];
}
