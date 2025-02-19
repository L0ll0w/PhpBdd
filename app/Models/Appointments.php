<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time',
        'details',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
