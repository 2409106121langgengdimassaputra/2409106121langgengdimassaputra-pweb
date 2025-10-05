<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['username'])) {
  header("Location: dashboard.php");
  exit();
}

// Jika form dikirim (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Login sederhana (hardcode)
  if ($username === "admin" && $password === "12345") {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Top Up UC PUBG</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Login ke Dashboard Top Up UC PUBG</h1>
  </header>

  <main class="container">
    <form method="POST" class="card">
      <label>Username:</label>
      <input type="text" name="username" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn btn-primary">Login</button>

      <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
      <?php endif; ?>
    </form>
  </main>
</body>
</html>
