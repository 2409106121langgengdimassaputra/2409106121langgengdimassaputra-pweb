<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

include 'koneksi.php'; 

$username = $_SESSION['username'];
$pesan = ''; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
    $user_id = $koneksi->real_escape_string($_POST['user_id']);
    $paket = $koneksi->real_escape_string($_POST['paket']);
    $metode = $koneksi->real_escape_string($_POST['metode']);

    $sql = "INSERT INTO topup_data (user_id, paket_uc, metode_bayar, username_admin) VALUES ('$user_id', '$paket', '$metode', '$username')";
    
    if ($koneksi->query($sql) === TRUE) {
        $pesan = "<div class='card success'>Data Top Up Berhasil Ditambahkan!</div>";
    } else {
        $pesan = "<div class='card error'>Error: " . $koneksi->error . "</div>";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $koneksi->real_escape_string($_GET['delete_id']);
    $sql = "DELETE FROM topup_data WHERE id='$delete_id'";
    if ($koneksi->query($sql) === TRUE) {
        $pesan = "<div class='card success'>Data Top Up Berhasil Dihapus!</div>";
    } else {
        $pesan = "<div class='card error'>Error: " . $koneksi->error . "</div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $id = $koneksi->real_escape_string($_POST['id_edit']);
    $user_id = $koneksi->real_escape_string($_POST['user_id_edit']);
    $paket = $koneksi->real_escape_string($_POST['paket_edit']);
    $metode = $koneksi->real_escape_string($_POST['metode_edit']);

    $sql = "UPDATE topup_data SET user_id='$user_id', paket_uc='$paket', metode_bayar='$metode' WHERE id='$id'";
    
    if ($koneksi->query($sql) === TRUE) {
        $pesan = "<div class='card success'>Data Top Up Berhasil Diperbarui!</div>";
    } else {
        $pesan = "<div class='card error'>Error: " . $koneksi->error . "</div>";
    }
}

$sql_read = "SELECT * FROM topup_data ORDER BY tanggal_topup DESC";
$result = $koneksi->query($sql_read);

$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $koneksi->real_escape_string($_GET['edit_id']);
    $sql_edit = "SELECT * FROM topup_data WHERE id='$edit_id'";
    $result_edit = $koneksi->query($sql_edit);
    if ($result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
    }
}

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
    <?= $pesan ?>

    <h2><?= $edit_data ? 'Edit Data Top Up' : 'Form Top Up UC PUBG (CREATE)' ?></h2>
    
    <form class="card" method="POST" action="dashboard.php">
      <input type="hidden" name="id_edit" value="<?= $edit_data ? $edit_data['id'] : '' ?>">

      <label for="user-id">User ID PUBG:</label>
      <input type="text" id="user-id" name="user_id<?= $edit_data ? '_edit' : '' ?>" required 
             value="<?= $edit_data ? $edit_data['user_id'] : '' ?>">

      <label for="paket">Pilih Paket UC:</label>
      <select id="paket" name="paket<?= $edit_data ? '_edit' : '' ?>" required>
        <?php 
        $selected_paket = $edit_data ? $edit_data['paket_uc'] : ''; 
        ?>
        <option value="">-- Pilih Paket --</option>
        <option value="60" <?= $selected_paket == 60 ? 'selected' : '' ?>>60 UC</option>
        <option value="300" <?= $selected_paket == 300 ? 'selected' : '' ?>>300 UC</option>
        <option value="600" <?= $selected_paket == 600 ? 'selected' : '' ?>>600 UC</option>
      </select>

      <label for="metode">Metode Pembayaran:</label>
      <select id="metode" name="metode<?= $edit_data ? '_edit' : '' ?>" required>
        <?php 
        $selected_metode = $edit_data ? $edit_data['metode_bayar'] : ''; 
        ?>
        <option value="">-- Pilih Metode --</option>
        <option value="Dana" <?= $selected_metode == 'Dana' ? 'selected' : '' ?>>Dana</option>
        <option value="Gopay" <?= $selected_metode == 'Gopay' ? 'selected' : '' ?>>Gopay</option>
        <option value="Transfer Bank" <?= $selected_metode == 'Transfer Bank' ? 'selected' : '' ?>>Transfer Bank</option>
      </select>

      <button type="submit" name="<?= $edit_data ? 'edit' : 'tambah' ?>" class="btn btn-primary">
        <?= $edit_data ? 'Simpan Perubahan (UPDATE)' : 'Tambah Data (CREATE)' ?>
      </button>
      <?php if ($edit_data): ?>
        <a href="dashboard.php" class="btn" style="background: #ccc; margin-top: 10px;">Batal Edit</a>
      <?php endif; ?>
    </form>

    <h2>Riwayat Top Up (READ)</h2>
    <div class="card">
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>UC</th>
                    <th>Metode</th>
                    <th>Tanggal</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['paket_uc'] ?></td>
                    <td><?= $row['metode_bayar'] ?></td>
                    <td><?= $row['tanggal_topup'] ?></td>
                    <td><?= $row['username_admin'] ?></td>
                    <td>
                        <a href="dashboard.php?edit_id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="dashboard.php?delete_id=<?= $row['id'] ?>" class="btn btn-delete" 
                           onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Belum ada data top up yang tercatat.</p>
        <?php endif; ?>
    </div>
  </main>

  <script src="script.js"></script>
</body>
</html>
