@extends('components.email')

@section('title', 'Payment Available for Release')

@section('content')

<h2 style="
    margin-top:0;
    color:#d97706;
    font-size:24px;
    font-weight:700;
">
    Payment Available for Release
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
    Your payment is now available for pickup or release processing.
</p>

<div style="
    margin-top:24px;
    background:#fffbeb;
    border:1px solid #fde68a;
    border-radius:8px;
    padding:20px;
">

    <!-- AMOUNT -->
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
            font-size:18px;
            font-weight:700;
            color:#111827;
        ">
            ₱ {{ number_format($joEvaluation->amount, 2) }}
        </div>
    </div>

</div>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Please coordinate with the Finance Department for the release or claiming of your payment.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for your cooperation.
</p>

<br/>

@endsection