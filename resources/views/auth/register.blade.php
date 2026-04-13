<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - DonorHub</title>
</head>
<body>

    <h2>Register DonorHub</h2>

    {{-- ERROR --}}
    @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>Nama</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Register</button>
    </form>

    <p>
        Sudah punya akun?
        <a href="{{ route('login') }}">Login</a>
    </p>

</body>
</html>