```blade
@extends('components.email')

@section('title', 'Check Available for Release')

@section('content')

<h2 style="
    margin-top:0;
    color:#166534;
    font-size:24px;
    font-weight:700;
">
    Check Available for Release
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
    We are pleased to inform you that your payment is now available for release.
</p>

<div style="
    margin-top:24px;
    background:#f0fdf4;
    border:1px solid #bbf7d0;
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
            Payment Details
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $poGppo->payment_details }}
        </div>
    </div>

    <div style="margin-bottom:16px;">
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Check Number
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $poGppo->check_no }}
        </div>
    </div>

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
            ₱ {{ number_format($poGppo->amount, 2) }}
        </div>
    </div>

    <div style="margin-bottom:16px;">
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Invoice Reference
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $poGppo->invoice_reference }}
        </div>
    </div>

    <div>
        <div style="
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:bold;
        ">
            Releasing Location
        </div>

        <div style="
            margin-top:4px;
            font-size:16px;
            color:#111827;
        ">
            {{ $poGppo->release_location }}
        </div>
    </div>

</div>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Please bring a valid government-issued ID and any required authorization documents when claiming your payment.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for your cooperation.
</p>

@endsection
```
