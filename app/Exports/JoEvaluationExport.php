<?php

namespace App\Exports;

use App\Services\JoEvaluationService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JoEvaluationExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(
        protected $search,
        protected $status,
        protected $fromDate,
        protected $toDate,
    ) {}

    public function collection()
    {
        return app(JoEvaluationService::class)->getExportRecords(
            $this->search,
            $this->status,
            $this->fromDate,
            $this->toDate
        );
    }

    public function headings(): array
    {
        return [
            'ID',
            'Invoice No',
            'Accomplishment No',
            'JO Reference',
            'DR No',
            'Amount',
            'Status',
            'Check No',
            'Amount Details',
            'Release Location',
            'Rejection Reason',
            'Created At',
        ];
    }
}
