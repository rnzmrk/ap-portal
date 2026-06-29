@extends('components.email')

@section('title', 'Payment Successfully Paid')

@section('content')

<h2 style="
    margin-top:0;
    color:#16a34a;
    font-size:24px;
    font-weight:700;
">
    Payment Successfully Paid
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
    We are pleased to inform you that your billing has been successfully processed and your payment has been released.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Thank you for your patience and for doing business with us. We look forward to serving you again.
</p>

<br/>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Regards,<br>
    <strong>Accounts Payable Portal</strong>
</p>

@endsection
