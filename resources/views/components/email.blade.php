<!DOCTYPE html>
<html>
<head>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>@yield('title', 'AP Portal')</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:40px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0"
                style="
                    background:#ffffff;
                    border-radius:12px;
                    overflow:hidden;
                    box-shadow:0 4px 12px rgba(0,0,0,0.08);
                ">

                <!-- Header -->
                <tr>
                    <td style="
                        background:#dc2626;
                        padding:30px;
                        text-align:center;
                    ">
                        <h1 style="
                            margin:0;
                            color:#ffffff;
                            font-size:28px;
                            font-weight:bold;
                        ">
                            AP Portal
                        </h1>

                        <p style="
                            margin-top:8px;
                            color:#fecaca;
                            font-size:14px;
                        ">
                            AP Management System
                        </p>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:35px;">
                        @yield('content')
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="
                        background:#fef2f2;
                        padding:20px;
                        text-align:center;
                        border-top:1px solid #fecaca;
                    ">
                        <p style="
                            margin:0;
                            color:#7f1d1d;
                            font-size:12px;
                        ">
                            © {{ date('Y') }} AP Portal. All rights reserved.
                        </p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
