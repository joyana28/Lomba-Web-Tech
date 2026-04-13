<h2>Lupa Password</h2>

@if(session('status'))
    <p style="color:green">{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Masukkan Email" required>
    <button type="submit">Kirim Link Reset</button>
</form>