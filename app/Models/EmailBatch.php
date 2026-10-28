<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailBatch extends Model
{
    protected $table = 'email_batches';

    protected $fillable = [
        'subject_id',
        'created_by',
        'target_tutor_id',
        'status',
        'last_tutor_id',
        'sent_count',
        'batch_size',
        'last_error',
        'expires_at',
        'accepted_user_id',
        'accepted_item_id',
        'accepted_at',
        'booking_id',
    ];

    protected $casts = [
        'subject_id' => 'integer',
        'created_by' => 'integer',
        'target_tutor_id' => 'integer',
        'last_tutor_id' => 'integer',
        'sent_count' => 'integer',
        'batch_size' => 'integer',
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(EmailBatchItem::class, 'batch_id');
    }

    public function targetTutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_tutor_id');
    }

    public function isDirect(): bool
    {
        return ! is_null($this->target_tutor_id);
    }
}
