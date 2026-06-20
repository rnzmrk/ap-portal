@extends('components.email')

@section('title', 'Billing Successfully Submitted')

@section('content')

<h2 style="
    margin-top:0;
    color:#991b1b;
    font-size:24px;
    font-weight:700;
">
    Billing Successfully Submitted
</h2>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Dear <strong>{{ $joEvaluation->user->name ?? 'Supplier' }}</strong>,
</p>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Your billing has been successfully submitted and is now awaiting
    <strong>Job Order Evaluation</strong>.
</p>

<div style="
    margin-top:24px;
    background:#fef2f2;
    border:1px solid #fecaca;
    border-radius:8px;
    padding:20px;
">

    <!-- INVOICE NO -->
    <div style="margin-bottom:16px;">
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Invoice No.
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $joEvaluation->invoice_no }}
        </div>
    </div>

    <!-- ACCOMPLISHMENT NO -->
    <div style="margin-bottom:16px;">
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Accomplishment No.
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $joEvaluation->accomplishment_no }}
        </div>
    </div>

    <!-- AMOUNT -->
    <div style="margin-bottom:16px;">
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Amount
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            font-weight:600;
            color:#111827;
        ">
            ₱ {{ number_format($joEvaluation->amount, 2) }}
        </div>
    </div>

    <!-- JOB REFERENCE -->
    <div>
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Job Reference
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $joEvaluation->jo_reference }}
        </div>
    </div>

</div>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    You will receive another email once the evaluation process has been completed.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for using the AP Portal.
</p>

<br/>

@endsection
