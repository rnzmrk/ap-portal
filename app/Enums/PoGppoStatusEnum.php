<?php

namespace App\Enums;

enum PoGppoStatusEnum:string
{
    case PENDING = 'pending';
    case UNDER_REVIEW = 'under_review';
    case APPROVED_FOR_CONTINUING = 'approved_for_continuing';
    case RETURNED_FOR_COMPLIANCE = 'returned_for_compliance';
    case CONTINUED = 'continued';
    case CHECK_READY_FOR_RELEASE = 'check_ready_for_release';
    case RELEASED = 'released';
}
