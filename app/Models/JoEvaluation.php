<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoEvaluation extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_no',
        'accomplishment_no',
        'jo_reference',
        'amount',
        'files',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
