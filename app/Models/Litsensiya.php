<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litsensiya extends Model
{
    use HasFactory;
    protected $fillable=['uzrotl_id','status'];

    public function special()
    {
       return $this->belongsTo(Specialization::class);
    }
    public function users()
    {
       return $this->belongsTo(User::class);
    }
}
