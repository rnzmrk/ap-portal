<?php

namespace App\Enums;

enum JoEvaluationStatusEnum:string
{
    case PENDING = 'pending';
    // Operation
    case FOR_OPERATION_REVIEW = 'for_operation_review';
    case OPERATION_APPROVED = 'operation_approved';
    case OPERATION_REJECTED = 'operation_rejected';

    // Procurement
    case FOR_PROCUREMENT_REVIEW = 'for_procurement_review';
    case EVALUATION_APPROVED = 'evaluation_approved';
    case PROCUREMENT_REJECTED = 'procurement_rejected';

    // Finance
    case CONTINUED = 'continued';
    case PAYMENT_FOR_RELEASE = 'payment_for_release';
}
