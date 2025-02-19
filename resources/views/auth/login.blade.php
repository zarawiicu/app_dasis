<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- CSS Aplikasi -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <div class="col-md-6 d-none d-md-block ads">
    <img src="{{ asset('template/dist/img/ambis.png') }}" alt="Profile Image">
  </div>
  <div class="container login-container">
    <div class="row justify-content-end align-items-center">
      <div class="col-md-8">
        <div class="login-form">
          <h5 class="text-center mb-4">Selamat datang App Dasis! 👋</h5>
          <form action="{{ route('login.proses') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="username">Username/Email</label>
              <input type="text" class="form-control" name="login" id="username" placeholder="Username atau Email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-login">Login</button>
            <div class="text-center mt-3">
              <small>Don't have an account yet? <a href="{{ route('register') }}">Register</a></small>
            </div>
            <div class="text-center mt-2">
              <small><a href="#">Forgot Password?</a></small>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 4 JS dan dependency -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
