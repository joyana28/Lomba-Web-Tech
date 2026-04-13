<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - DonorHub</title>
</head>
<body>

    <h2>Login DonorHub</h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- STATUS (RESET PASSWORD LINK SENT) --}}
    @if(session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    {{-- ERROR MESSAGE --}}
    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        {{-- 🔑 LUPA PASSWORD --}}
        <div style="margin-bottom: 10px;">
            <a href="{{ route('password.request') }}" style="font-size: 14px; color: blue;">
                Lupa password?
            </a>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>
        Belum punya akun?
        <a href="{{ route('register') }}">Register</a>
    </p>

</body>
</html>