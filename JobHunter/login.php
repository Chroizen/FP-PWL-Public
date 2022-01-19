<?php
require 'koneksi.php';

// Cek ketersediaan cookie username
if (isset($_COOKIE['account_username'])) {
  // Cek level
  if ($_COOKIE['account_level'] == "Admin") {
    setcookie("tempinput", "Anda telah login sebelumnya", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php');
  }
  if ($_COOKIE['account_level'] != "Admin") {
    setcookie("tempinput", "Anda telah login sebelumnya", time() + 2 * 24 * 60 * 60);
    header('location: ../dashboard/index.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets\css\login.css">
</head>

<body>
  <div class="center">
    <h1>Login</h1>


    <?php
    if (isset($_COOKIE['error'])) {
      echo "<p style='  margin: 30px 0; text-align: center; font-size: 14px; color: red;'>Username atau password salah</p>";
      setcookie('error', '', 0);
    }

    ?>





    <form class="" action="login_proses.php" method="post">
      <div class="field">
        <input type="text" name="username" id="username" value="" required><span></span>
        <label for="username">Username</label>
      </div>

      <div class="field">
        <input type="password" name="password" id="password" value="" required><span></span>
        <label for="password">Password</label>
      </div>

      <!--         <div class="check">
          <input type="checkbox" name="remember" id="remember" value="">
          <label for="remember">Remember me</label>
        </div> -->

      <button type="submit" name="login">Login</button>

      <div class="reg">Belum Punya Akun?
        <a href="register.php">Daftar</a>
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
    echo 'alert("' . $_COOKIE['tempinput'] . '")';
    echo '</script>';
    setcookie('tempinput', '', 0);
  }
}
?>