<?php
session_start();
include 'db.php'; // Your DB connection file

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=SHA2(?,256)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #071026, #0b1220);
      color: #e6eef6;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-card {
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(10px);
      padding: 2rem;
      border-radius: 16px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .login-card h3 {
      color: #7c3aed;
    }

    .form-control {
      background: rgba(255,255,255,0.1);
      color: #e6eef6;
      border: 1px solid rgba(255,255,255,0.2);
    }

    .form-control:focus {
      background: rgba(255,255,255,0.15);
      color: #fff;
      border-color: #7c3aed;
      box-shadow: none;
    }

    .btn-primary {
      background: #7c3aed;
      border-color: #7c3aed;
    }

    .btn-primary:hover {
      background: #a855f7;
      border-color: #a855f7;
    }

    .alert {
      backdrop-filter: blur(5px);
      background: rgba(255,0,0,0.2);
      color: #fff;
      border: none;
    }

    @media (max-width: 576px) {
      body {
        padding: 1rem;
      }
      .login-card {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-card text-center">
      <h3 class="mb-4">Admin Login</h3>
      <?php if(isset($error)) echo "<div class='alert alert-danger mb-3'>$error</div>"; ?>
      <form method="post">
          <div class="mb-3">
              <input type="text" name="username" class="form-control" placeholder="Username" required>
          </div>
          <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
      </form>
  </div>
</body>
</html>
