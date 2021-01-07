<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous"/>

    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v27.0.3/dist/font-face.css" rel="stylesheet"
          type="text/css"/>

    <style>
        body {
            direction: {{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }};
            text-align: {{ app()->getLocale() == 'fa' ? 'right' : 'left' }};
        }
    </style>


    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
<div class="container mt-5">
    <div class="jumbotron">
        <div class="d-table border border-light py-2 rounded-circle">
            @if($payment->status == 1)
                <i class="fas fa-check fa-4x fa-fw" style="color: #20c997;"></i>
            @else
                <i class="fas fa-times fa-4x fa-fw" style="color: #ff6b6b;"></i>
            @endif
        </div>
        <h1 class="display-4">
            نتیجه پرداخت
        </h1>
        <p class="lead">
            @if($payment->status == 1)
                شماره تراکنش:
                {{ $last_response->refID }}

                <br>
            @endif

            مبلغ تراکنش:
            {{ $payment->amount }}
            تومان
        </p>
        <hr class="my-4">
        <p>{{ $last_response->message }}</p>
        <a class="btn btn-primary btn-lg" href="{{ $payment->callback }}" role="button">بازگشت به سایت</a>
    </div>
</div>

</body>
</html>
