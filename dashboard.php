<?php
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | Top Up UC PUBG</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Selamat Datang, <?= htmlspecialchars($username) ?>!</h1>
    <a href="logout.php" class="btn">Logout</a>
  </header>

  <main class="container">
    <h2>Form Top Up UC PUBG</h2>

    <form id="topupForm" class="card" method="GET" action="dashboard.php">
      <label for="user-id">User ID PUBG:</label>
      <input type="text" id="user-id" name="user_id" required>

      <label for="paket">Pilih Paket UC:</label>
      <select id="paket" name="paket" required>
        <option value="">-- Pilih Paket --</option>
        <option value="60">60 UC</option>
        <option value="300">300 UC</option>
        <option value="600">600 UC</option>
      </select>

      <label for="metode">Metode Pembayaran:</label>
      <select id="metode" name="metode" required>
        <option value="">-- Pilih Metode --</option>
        <option value="Dana">Dana</option>
        <option value="Gopay">Gopay</option>
        <option value="Transfer Bank">Transfer Bank</option>
      </select>

      <button type="submit" class="btn btn-primary">Kirim</button>
    </form>

    <?php
    // Tangani query string dari $_GET
    if (isset($_GET['user_id'], $_GET['paket'], $_GET['metode'])) {
      $user_id = htmlspecialchars($_GET['user_id']);
      $paket = htmlspecialchars($_GET['paket']);
      $metode = htmlspecialchars($_GET['metode']);

      echo "<div class='card success'>";
      echo "<h3>Top Up Berhasil!</h3>";
      echo "<p>User ID: $user_id</p>";
      echo "<p>Paket: $paket UC</p>";
      echo "<p>Metode: $metode</p>";
      echo "</div>";
    }
    ?>
  </main>

  <script src="script.js"></script>
</body>
</html>
