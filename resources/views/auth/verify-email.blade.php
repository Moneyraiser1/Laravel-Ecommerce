<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
     <link rel="shortcut icon" href="{{ asset('images/favico.png') }}" type="image/x-icon">
    <style>
        body {
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .verify-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }
        .verify-card h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .verify-card p {
            margin-bottom: 30px;
            color: #555;
        }
        .btn-primary {
            border-radius: 50px;
            padding: 10px 25px;
        }
    </style>
</head>
<body>

<div class="verify-card">
    <h2>Verify Your Email</h2>
    <p>
        Thanks for registering! Before proceeding, please check your email for a verification link.
        If you didn’t receive the email, click below to request another.
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
    </form>

</div>

<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
@if (session('message'))
<script>
    alertify.success("{{ session('message') }}");
</script>
@endif

</body>
</html>
