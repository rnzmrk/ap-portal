<?php

namespace App\Imports;

use App\Models\JoEvaluation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JoEvaluationImport implements ToModel, WithHeadingRow
{
   public function model(array $row)
    {

        $record = JoEvaluation::find($row['id']);

        if (!$record) {
            return null;
        }

        $record->update([
        'invoice_no' => $row['invoice_no'],
        'accomplishment_no' => $row['accomplishment_no'],
        'jo_reference' => $row['jo_reference'],
        'dr_no'      => $row['dr_no'] ?? null,
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
