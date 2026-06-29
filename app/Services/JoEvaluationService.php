<?php

namespace App\Services;

use App\Models\JoEvaluation;
use Illuminate\Support\Facades\Auth;
use App\Enums\JoEvaluationStatusEnum;
use App\Enums\RoleEnum;
use App\Http\Requests\JoEvaluation\StoreJoEvaluationRequest;
use App\Http\Requests\JoEvaluation\UpdateJoEvaluationRequest;

use App\Mail\JoEvaluation\SubmittedMail;
use App\Mail\JoEvaluation\OperationRejectedMail;
use App\Mail\JoEvaluation\EvaluationApprovedMail;
use App\Mail\JoEvaluation\PaymentForReleaseMail;
use App\Mail\JoEvaluation\CounteredMail;
use App\Mail\JoEvaluation\PaidMail;
use App\Mail\JoEvaluation\ReleasedMail;


class JoEvaluationService
{
    public function __construct(
        protected AuditLogService $auditLogService,
        protected MailService $mailService,
    ) {}

    /**
     * =========================
     * EMAIL HANDLER
     * =========================
     */
    private function sendStatusEmail(JoEvaluation $joEvaluation): void
    {
        $joEvaluation->loadMissing('user');

        $email = $joEvaluation->user?->email;

        if (!$email) {
            return;
        }

        $status = $joEvaluation->status;

        if (is_string($status)) {
            $status = JoEvaluationStatusEnum::tryFrom($status);
        }

        if (!$status instanceof JoEvaluationStatusEnum) {
            return;
        }

        match ($status) {
            JoEvaluationStatusEnum::PENDING =>
                $this->mailService->send($email, new SubmittedMail($joEvaluation)),

            JoEvaluationStatusEnum::OPERATION_REJECTED =>
                $this->mailService->send($email, new OperationRejectedMail($joEvaluation)),

            JoEvaluationStatusEnum::EVALUATION_APPROVED =>
                $this->mailService->send($email, new EvaluationApprovedMail($joEvaluation)),

            JoEvaluationStatusEnum::COUNTERED =>
                $this->mailService->send($email, new CounteredMail($joEvaluation)),

            JoEvaluationStatusEnum::PAYMENT_FOR_RELEASE =>
                $this->mailService->send($email, new PaymentForReleaseMail($joEvaluation)),

            JoEvaluationStatusEnum::RELEASED =>
            $this->mailService->send($email, new ReleasedMail($joEvaluation)),

            JoEvaluationStatusEnum::PAID =>
                $this->mailService->send($email, new PaidMail($joEvaluation)),

            default => null,
        };
    }
    /**
     * =========================
     * GET RECORDS
     * =========================
     */


    public function getRecords(?string $search = null, $status = null, ?string $fromDate = null, ?string $toDate = null)
    {
        return JoEvaluation::with('user')
            ->latest()

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('invoice_no','like',"%{$search}%")
                    ->orWhere('accomplishment_no','like',"%{$search}%")
                    ->orWhere('jo_reference','like',"%{$search}%")

                    ->orWhereHas('user', function($u) use ($search){

                            $u->where('name','like',"%{$search}%");

                    });

                });

            })

            ->when($status,function($query,$status){

                if($status instanceof JoEvaluationStatusEnum){
                    $status=$status->value;
                }

                $query->where('status',$status);

            })

            ->when($fromDate,function($query,$fromDate){

                $query->whereDate('created_at','>=',$fromDate);

            })

            ->when($toDate,function($query,$toDate){

                $query->whereDate('created_at','<=',$toDate);

            })

            ->paginate(15)
            ->withQueryString();
    }


    /**
     * =========================
     * STORE
     * =========================
     */
    public function store(StoreJoEvaluationRequest $request): JoEvaluation
    {

        $files = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $files[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $file->store('jo-evaluation', 'public'),
                ];
            }
        }

        $record = JoEvaluation::create([
            'user_id' => Auth::id(),
            'invoice_no' => $request->invoice_no,
            'accomplishment_no' => $request->accomplishment_no,
            'jo_reference' => $request->jo_reference,
            'dr_no' => $request->dr_no,
            'amount' => $request->amount,
            'files' => $files,
            'status' => JoEvaluationStatusEnum::PENDING,
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
            'JO-EVALUATION',
            'CREATE',
            $record->id,
            [],
            $record->toArray()
        );

        $this->sendStatusEmail($record);

        return $record;
    }

      /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update(
        JoEvaluation $joEvaluation,
        UpdateJoEvaluationRequest $request
    ): JoEvaluation {

        $oldValues = $joEvaluation->toArray();
        $data = $request->validated();

        /**
         * =========================
         * FILE HANDLING
         * =========================
         */
        $removedFiles = [];

        if ($request->has('removed_files')) {
            $removed = json_decode($request->input('removed_files'), true);

            if (is_array($removed)) {
                $removedFiles = array_column($removed, 'path');
            }
        }

        $files = [];

        if (is_array($joEvaluation->files)) {
            foreach ($joEvaluation->files as $file) {
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
                    'path' => $file->store('jo-evaluation', 'public'),
                ];
            }
        }
        $evaluationFiles = [];

        // Keep existing files
        if (is_array($joEvaluation->evaluation_files)) {
            foreach ($joEvaluation->evaluation_files as $file) {
                $evaluationFiles[] = $file;
            }
        }

        // Upload new files
        if ($request->hasFile('evaluation_files')) {
            foreach ($request->file('evaluation_files') as $file) {
                $evaluationFiles[] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $file->store('evaluation-files', 'public'),
                ];
            }
        }

        if (!empty($evaluationFiles)) {
            $data['evaluation_files'] = $evaluationFiles;
        }

        if (!empty($files)) {
            $data['files'] = $files;
        }

        /**
         * =========================
         * STATUS CHANGE CHECK
         * =========================
         */
        $oldStatus = $joEvaluation->getOriginal('status');

        $joEvaluation->update($data);
        $joEvaluation->refresh();

        $newStatus = $joEvaluation->status;

        // normalize old
        if (is_string($oldStatus)) {
            $oldStatus = JoEvaluationStatusEnum::tryFrom($oldStatus);
        }

        // normalize new
        if (is_string($newStatus)) {
            $newStatus = JoEvaluationStatusEnum::tryFrom($newStatus);
        }

        // send email ONLY once
        if ($oldStatus !== $newStatus) {
            $this->sendStatusEmail($joEvaluation);
        }

        /**
         * =========================
         * AUDIT LOG
         * =========================
         */
        $this->auditLogService->log(
            Auth::id(),
            'JO-EVALUATION',
            'UPDATE',
            $joEvaluation->id,
            $oldValues,
            $joEvaluation->toArray()
        );

        return $joEvaluation;
    }
    /**
     * =========================
     * DELETE
     * =========================
     */
       public function delete(JoEvaluation $joEvaluation): void
    {
        $oldValues = $joEvaluation->toArray();

        $joEvaluation->delete();

        $this->auditLogService->log(
            Auth::id(),
            'JO-EVALUATION',
            'DELETE',
            $oldValues,
            []
        );
    }
}


