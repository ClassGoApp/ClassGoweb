<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailBatch extends Model
{
    protected $table = 'email_batches';

    protected $fillable = [
        'subject_id',
        'created_by',
        'status',
        'last_tutor_id',
        'sent_count',
        'batch_size',
        'last_error',
        'expires_at',
    ];

    protected $casts = [
        'subject_id' => 'integer',
        'created_by' => 'integer',
        'last_tutor_id' => 'integer',
        'sent_count' => 'integer',
        'batch_size' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(EmailBatchItem::class, 'batch_id');
    }
}
