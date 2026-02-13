<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailBatchItem extends Model
{
      protected $table = 'email_batch_items';

    protected $fillable = [
        'batch_id',
        'user_id',
        'position',
        'status',
        'sent_at',
        'last_error',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function batch()
    {
        return $this->belongsTo(EmailBatch::class, 'batch_id');
    }
}
