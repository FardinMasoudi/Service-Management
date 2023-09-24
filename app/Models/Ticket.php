<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Ticket extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['title', 'description', 'user_id', 'service_id', 'status'];

    public const STATUSES = [
        'PENDING' => 'pending',
        'SEENBYADMIN' => 'seenByAdmin',
        'CANCEL' => 'cancel',
        'COMPLETED' => 'completed',
        'CLOSE' => 'close'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(service::class);
    }
}
