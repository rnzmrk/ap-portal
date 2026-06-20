<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PoGppoStatusEnum;

class PoGppo extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_no',
        'po_no',
        'amount',
        'files',
        'status',
        'return_reason',
        'payment_details',
        'check_no',
        'release_location',
    ];

    protected $casts = [
        'files' => 'array',
    ];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
