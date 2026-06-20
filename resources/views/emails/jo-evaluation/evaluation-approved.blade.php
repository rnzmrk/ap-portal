@extends('components.email')

@section('title', 'Approved Evaluation Document for Continuing')

@section('content')

<h2 style="
    margin-top:0;
    color:#16a34a;
    font-size:24px;
    font-weight:700;
">
    Approved Evaluation Document for Continuing
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
    Your service evaluation has been <strong>approved</strong>.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    Attached are the signed evaluation documents required for continuing the process.
</p>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    You may now proceed with the transmittal of documents for the next stage of the job order evaluation process.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for your cooperation.
</p>

<br/>

@endsection