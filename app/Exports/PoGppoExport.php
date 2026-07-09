<?php

namespace App\Exports;

use App\Models\PoGppo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Services\PoGppoService;

class PoGppoExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(
        protected $search,
        protected $status,
        protected $fromDate,
        protected $toDate,
    ) {}

    public function collection()
    {
        return app(PoGppoService::class)->getExportRecords(
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
            'PO No',
            'DR No',
            'GRPO',
            'Amount',
            'Status',
            'Check No',
            'Amount Details',
            'Release Location',
            'Return Reason',
        ];
    }
}
