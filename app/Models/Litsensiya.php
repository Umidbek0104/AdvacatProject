<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litsensiya extends Model
{
    use HasFactory;
    protected $fillable=['uzrotl_id','status'];
}
