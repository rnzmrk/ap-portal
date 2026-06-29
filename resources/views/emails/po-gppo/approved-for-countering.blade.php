@extends('components.email')

@section('title', 'Billing Approved for Countering')

@section('content')

<h2 style="
    margin-top:0;
    color:#166534;
    font-size:24px;
    font-weight:700;
">
    Billing Approved for Countering
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
    We are pleased to inform you that your billing has been
    <strong>approved for countering</strong>.
</p>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Please bring the required original documents to the Head Office for verification and further processing.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    You will receive another notification regarding any further updates to your billing.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for your cooperation.
</p>

@endsection
