<?php

namespace App\Enums;

enum PoGppoStatusEnum:string
{
    case PENDING = 'pending';
    case APPROVED_FOR_COUNTERING = 'approved_for_countering';
    case RETURNED_FOR_COMPLIANCE = 'returned_for_compliance';
    case COUNTERED = 'countered';
    case CHECK_READY_FOR_RELEASE = 'check_ready_for_release';
    case RELEASED = 'released';
    case PAID = 'paid';
}
