<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .card {
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-google {
            background-color: #db4437;
            color: white;
        }

        .btn-facebook {
            background-color: #3b5998;
            color: white;
        }

        .btn-apple {
            background-color: #000000;
            color: white;
        }

        .btn-tiktok {
            background-color: gray;
            color: white;
        }

        .btn-social {
            width: 100%;
            margin: 10px 0;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 30px;
            text-align: left;
        }

        .btn-social i {
            margin-right: 10px;
        }

    </style>
</head>
<body>
    <div class="card">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <!-- Display Error Message -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h2>Login with Social Media</h2>
        <a href="{{ url('auth/google') }}" class="btn btn-google btn-social">
            <i class="fab fa-google"></i> Login with Google
        </a>
        <a href="{{ url('auth/facebook') }}" class="btn btn-facebook btn-social">
            <i class="fab fa-facebook-f"></i> Login with Facebook
        </a>
        <a href="{{ url('auth/apple') }}" class="btn btn-apple btn-social">
            <i class="fab fa-apple"></i> Login with Apple
        </a>
        <a href="{{ url('auth/tiktok') }}" class="btn btn-tiktok btn-social">
            <i class="fab fa-tiktok"></i> Login with TikTok
        </a>
    </div>
</html>
