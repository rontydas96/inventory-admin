<!DOCTYPE html>
<html>

<head>
  <title>Admin Login</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f7fb;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      width: 400px;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #0f172a;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .error {
      color: red;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>
  <div class="login-box">
    <h2>Admin Login</h2>

    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>

</html>