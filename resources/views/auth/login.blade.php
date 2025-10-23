<!-- resources/views/auth/login.blade.php -->
<h2>Login</h2>
<form method="POST" action="/login">
    @csrf
    <label>Email:</label><input type="email" name="email"><br>
    <label>Password:</label><input type="password" name="password"><br>
    <button type="submit">Login</button>
</form>
<p>Belum memiliki akun?
    <a href="{{ route('register') }}">daftar disini</a>
</p>
<a href="{{ route('about') }}">kembali ke beranda</a>