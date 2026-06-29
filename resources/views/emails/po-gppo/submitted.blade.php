
@extends('components.email')

@section('title', 'PO Submitted Successfully')

@section('content')

<h2 style="
    margin-top:0;
    color:#991b1b;
    font-size:24px;
    font-weight:700;
">
    PO-GPPO Submitted Successfully
</h2>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Dear <strong>{{ $poGppo->supplier->name ?? 'N/A' }}</strong>,
</p>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Your billing has been successfully submitted through the
    <strong>AP Portal</strong>.
</p>

<div style="
    margin-top:24px;
    background:#fef2f2;
    border:1px solid #fecaca;
    border-radius:8px;
    padding:20px;
">

    <div style="margin-bottom:16px;">
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Inoice No.
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $poGppo->invoice_no }}
        </div>
    </div>

    <div>
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
            ₱ {{ number_format($poGppo->amount, 2) }}
        </div>
    </div>

</div>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    You will receive another email once the review process has been completed.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for using the AP Portal.
</p>

<br/>

@endsection
