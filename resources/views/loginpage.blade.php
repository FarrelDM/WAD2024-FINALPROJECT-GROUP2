<html lang="en">

<link rel ="stylesheet" href="{{asset('css/login.css')}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel ="stylesheet" href="{{asset('css/loginpage.css')}}">
</head>

<body class="bg-light" >
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4">
            <div class="text-center mb-4">
                <img src="{{asset('tempImage5ApUE0 1.png')}}" alt="HJ Barakah Logo" class="mb-3">
                <h1 class="h4">HJ Barakah</h1>
            </div>
            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
            <div class="text-center mt-3">
                <a href="/forgot-password" class="text-decoration-none">Forgot Password?</a>
                <span class="mx-2">|</span>
                <a href="/register" class="text-decoration-none">Create Account</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
