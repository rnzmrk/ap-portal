<?php

namespace App\Enums;

enum JoEvaluationStatusEnum:string
{
    case PENDING = 'pending';
    // Operations
    case OPERATION_APPROVED = 'operation_approved';
    case OPERATION_REJECTED = 'operation_rejected';

    // Procurement
    case EVALUATION_APPROVED = 'evaluation_approved';
    case PROCUREMENT_REJECTED = 'procurement_rejected';

    // Finance
    case COUNTERED = 'countered';
    case PAYMENT_FOR_RELEASE = 'payment_for_release';

    case RELEASED = 'released';
    case PAID = 'paid';
}
