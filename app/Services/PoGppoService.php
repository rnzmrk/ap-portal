<?php

namespace App\Services;

use App\Models\PoGppo;
use Illuminate\Support\Facades\Auth;

use App\Enums\PoGppoStatusEnum;
use App\Enums\RoleEnum;


use App\Http\Requests\PoGppo\StorePoGppoRequest;
use App\Http\Requests\PoGppo\UpdatePoGppoRequest;

use App\Mail\PoGppo\SubmittedMail;
use App\Mail\PoGppo\ReturnedForComplianceMail;
use App\Mail\PoGppo\CheckReadyForReleaseMail;
use App\Mail\PoGppo\ReleasedMail;
use App\Mail\PoGppo\ApprovedForCounteringMail;
use App\Mail\PoGppo\CounteredMail;
use App\Mail\PoGppo\PaidMail;



class PoGppoService
{
    public function __construct(
        protected AuditLogService $auditLogService,
        protected MailService $mailService,

    ) {}


    private function sendStatusEmail(PoGppo $poGppo): void
    {
        $poGppo->loadMissing('supplier');

        if (!$poGppo->supplier?->email) {
            return;
        }

        $email = $poGppo->supplier->email;
        $status = PoGppoStatusEnum::tryFrom($poGppo->status);

        if (!$status) {
            return;
        }

        switch ($status) {

            case PoGppoStatusEnum::APPROVED_FOR_COUNTERING:
                $this->mailService->send(
                    $email,
                    new ApprovedForCounteringMail($poGppo)
                );
                break;

            case PoGppoStatusEnum::RETURNED_FOR_COMPLIANCE:
                $this->mailService->send(
                    $email,
                    new ReturnedForComplianceMail($poGppo)
                );
                break;

            case PoGppoStatusEnum::COUNTERED:
                $this->mailService->send(
                    $email,
                    new CounteredMail($poGppo)
                );
                break;

            case PoGppoStatusEnum::CHECK_READY_FOR_RELEASE:
                $this->mailService->send(
                    $email,
                    new CheckReadyForReleaseMail($poGppo)
                );
                break;

            case PoGppoStatusEnum::RELEASED:
                $this->mailService->send(
                    $email,
                    new ReleasedMail($poGppo)
                );
                break;
            case PoGppoStatusEnum::PAID:
                $this->mailService->send(
                    $email,
                    new PaidMail($poGppo)
                );
                break;
        }
    }


    public function getRecords(?string $search = null, ?string $status = null, ?string $fromDate = null, ?string $toDate = null)
    {
        return PoGppo::with('supplier')
            ->latest()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('invoice_no', 'like', "%{$search}%")
                        ->orWhere('po_no', 'like', "%{$search}%")
                        ->orWhereHas('supplier', function($u) use ($search){

                            $u->where('name','like',"%{$search}%");

                    });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($fromDate,function($query,$fromDate){

                $query->whereDate('created_at','>=',$fromDate);

            })
            ->paginate(15)
            ->withQueryString();
    }

    public function store(StorePoGppoRequest $request): PoGppo
    {
        $files = [];

    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $files[] = [
                'original_name' => $file->getClientOriginalName(),
                'path' => $file->store('po-gppo', 'public'),
            ];
        }
    }

    $record = PoGppo::create([
        'user_id' => Auth::id(),
        'invoice_no' => $request->invoice_no,
        'po_no' => $request->po_no,
        'dr_no' => $request->dr_no,
        'grpo' => $request->grpo,
        'amount' => $request->amount,
        'files' => $files,
        'status' => PoGppoStatusEnum::PENDING,
    ]);

        $this->mailService->sendToRole(
        RoleEnum::FINANCE->value,
        new SubmittedMail($record)
    );

        $this->mailService->send(
        Auth::user()->email,
        new SubmittedMail($record)
    );

    $this->auditLogService->log(
        Auth::id(),
        'PO-GPPO',
        'CREATE',
        $record->id,
        [],
        $record->toArray()
    );

    return $record;
}
    public function update(
        PoGppo $poGppo,
        UpdatePoGppoRequest $request
    ): PoGppo {

        $oldValues = $poGppo->toArray();

        $data = $request->validated();

        if (auth()->user()->role === 'supplier') {
            $removedFiles = [];
            if ($request->has('removed_files')) {
                $removed = json_decode($request->input('removed_files'), true);
                if (is_array($removed)) {
                    $removedFiles = array_column($removed, 'path');
                }
            }

            $files = [];
            if (is_array($poGppo->files)) {
                foreach ($poGppo->files as $file) {
                    $filePath = is_array($file) ? ($file['path'] ?? '') : $file;
                    if (!in_array($filePath, $removedFiles)) {
                        $files[] = is_array($file) ? $file : [
                            'original_name' => basename($filePath),
                            'path' => $filePath,
                        ];
                    }
                }
            }

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $files[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'path' => $file->store('po-gppo', 'public'),
                    ];
                }
            }

            $data['files'] = $files;
        }

        $oldStatus = $poGppo->status;

        $poGppo->update($data);

        $poGppo->refresh();

        if (
            Auth::user()->role !== RoleEnum::SUPPLIER->value &&
            $oldStatus !== $poGppo->status
        ) {
            $this->sendStatusEmail($poGppo);
        }



        $this->auditLogService->log(
            Auth::id(),
            'PO-GPPO',
            'UPDATE',
            $poGppo->id,
            $oldValues,
            $poGppo->fresh()->toArray()
        );

        return $poGppo;
    }

    public function delete(PoGppo $poGppo): void
    {
        $oldValues = $poGppo->toArray();

        $poGppo->delete();

        $this->auditLogService->log(
            Auth::id(),
            'PO-GPPO',
            'DELETE',
            $poGppo->id,
            $oldValues,
            []
        );
    }
}
