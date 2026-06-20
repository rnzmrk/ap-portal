<?php

namespace App\Enums;

enum RoleEnum:string
{
    case SUPPLIER = 'supplier';
    case FINANCE = 'finance';
    case PROCUREMENT = 'procurement';
    case OPERATION = 'operation';
}
