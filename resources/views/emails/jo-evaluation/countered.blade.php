@extends('components.email')

@section('title', 'Billing Successfully Countered/Receive')

@section('content')

<h2 style="
    margin-top:0;
    color:#2563eb;
    font-size:24px;
    font-weight:700;
">
    Billing Successfully Countered/Receive
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
    Your billing documents have been successfully continued and accepted for processing.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for your continued cooperation.
</p>

<br/>

@endsection
