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
        'dr_no',
        'amount',
        'files',
        'status',
        'amount_details',
        'check_no',
        'release_location',
        'rejection_reason',
        'evaluation_files'
    ];

    protected $casts = [
        'files' => 'array',
        'evaluation_files' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
