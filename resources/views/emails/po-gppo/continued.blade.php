```blade
@extends('components.email')

@section('title', 'Continuing Completed')

@section('content')

<h2 style="
    margin-top:0;
    color:#166534;
    font-size:24px;
    font-weight:700;
">
    Continuing Completed
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
    We are pleased to inform you that the continuing process for your billing has been completed successfully.
</p>

<p style="
    margin-top:24px;
    color:#4b5563;
    font-size:15px;
    line-height:1.8;
">
    You will receive another notification regarding the next stage of processing.
</p>

<p style="
    color:#4b5563;
    font-size:15px;
">
    Thank you for your cooperation.
</p>

@endsection
```
