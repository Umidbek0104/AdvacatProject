<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'expert_id',
        'status', // waiting, in-progress, completed
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(Expert::class);
    }
}
