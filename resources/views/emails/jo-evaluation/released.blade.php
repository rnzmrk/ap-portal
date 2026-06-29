@extends('components.email')

@section('title', 'Payment Successfully Released')

@section('content')

<h2 style="
    margin-top:0;
    color:#166534;
    font-size:24px;
    font-weight:700;
">
    Payment Successfully Released
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
    We are pleased to inform you that your payment has been successfully released.
</p>
<br/>
<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for doing business with us.
</p>

@endsection
