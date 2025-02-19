<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
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
          <h3 class="text-center mb-4">Register</h3>
          <form action="{{ route('register.proses') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-login">Register</button>
            <div class="text-center mt-3">
              <small>Already have an account? <a href="{{ route('login') }}">Login</a></small>
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
