<?php
require 'koneksi.php';

// Cek ketersediaan cookie username
if(isset($_COOKIE['account_username'])){
  // Cek level
  if ($_COOKIE['account_level'] == "Admin") {
    setcookie("tempinput", "Harap Logout untuk membuat akun baru.", time() + 2 * 24 * 60 * 60); 
    header('location: ../index.php');
  }
  if ($_COOKIE['account_level'] != "Admin") {
    setcookie("tempinput", "Harap Logout untuk membuat akun baru.", time() + 2 * 24 * 60 * 60);
    header('location: ../dashboard/index.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="assets\css\login.css">
  </head>
  <body>
    <div class="center">
      <h1>Register</h1>
      <form class="" action="register_proses.php" method="post">
        <table>
          <tr>
            <td>
              <div class="field">
                <input type="text" name="username" id="username" value="" required><span></span>
                <label for="username">Username</label>
              </div>

              <div class="field">
                <input type="password" name="password" id="password" value="" required><span></span>
                <label for="password">Password</label>
              </div>

              <div class="field">
                <input type="password" name="password2" id="password2" value="" required><span></span>
                <label for="password2">Konfirmasi Password</label>
              </div>

              <div class="field">
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="" required><span></span>
                <label for="password2">Nama Lengkap</label>
              </div>

              
            </td>

            <td>
              <div class="field">
                <input type="email" name="email" id="email" value="" required><span></span>
                <label for="password2">Email</label>
              </div>

              <div class="field">
                <input type="number" name="no_hp" id="no_hp" value="" required><span></span>
                <label for="password2">Nomor HP</label>
              </div>

              <div class="field">
                <input type="text" name="alamat" id="alamat" value="" required><span></span>
                <label for="password2">Alamat</label>
              </div>

              <div class="field">
                <select name="idStatusUser" id="idStatusUser" required>
                  <option value="" disabled selected>Status User</option>
                  <option value="STU-2">Pembeli</option>
                  <option value="STU-1">Penjual</option>
                </select>
              </div>

            </td>
          </tr>
        </table>



        

        <button type="submit" name="register">DAFTAR</button>

        <div class="reg">Sudah Punya Akun?
          <a href="login.php">Login</a>
        </div>
      </form>
    </div>
  </body>
</html>

<!-- Script Notif -->
<?php
  if (!empty($_COOKIE['tempinput'])) {
        if (isset($_COOKIE['tempinput'])) {
          echo '<script language="javascript">';
          echo 'alert("'.$_COOKIE['tempinput'].'")';
          echo '</script>';
          setcookie('tempinput', '', 0);
      }
    }
?>