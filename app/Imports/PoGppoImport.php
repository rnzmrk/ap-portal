<?php

namespace App\Imports;

use App\Models\PoGppo;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PoGppoImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $record = PoGppo::find($row['id']);

        if (!$record) {
            return null;
        }

        $record->update([
        'invoice_no' => $row['invoice_no'],
        'po_no'      => $row['po_no'],
        'dr_no'      => $row['dr_no'] ?? null,
        'grpo'       => $row['grpo'] ?? null,
        'amount'     => $row['amount'],
        'status'     => $row['status'],
        'check_no'         => $row['check_no'] ?? null,
        'amount_details'       => $row['amount_details'] ?? null,
        'release_location'     => $row['release_location'] ?? null,
        'return_reason'    => $row['return_reason'] ?? null,
        ]);
        return null;

    }
}
