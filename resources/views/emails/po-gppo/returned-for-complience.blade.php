
@extends('components.email')

@section('title', 'Billing Returned for Compliance')

@section('content')

<h2 style="
    margin-top:0;
    color:#991b1b;
    font-size:24px;
    font-weight:700;
">
    Billing Returned for Compliance
</h2>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Dear <strong>{{ $poGppo->supplier->name ?? 'Supplier' }}</strong>,
</p>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Your billing has been returned due to incomplete or incorrect documents submitted for review.
</p>

<div style="
    margin-top:24px;
    background:#fef2f2;
    border:1px solid #fecaca;
    border-radius:8px;
    padding:20px;
">

    <div>
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Reason for Return
        </div>

        <div style="
            margin-top:8px;
            padding:12px;
            background:#ffffff;
            border-left:4px solid #dc2626;
            color:#111827;
            border-radius:4px;
        ">
            {{ $poGppo->return_reason }}
        </div>
    </div>

</div>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Please review the noted issue, make the necessary corrections, and resubmit your billing through the AP Portal.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for your cooperation.
</p>

@endsection
