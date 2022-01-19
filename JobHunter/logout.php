<?php

// Unset Cookies
setcookie('account_username', '', 0);
setcookie('account_level', '', 0);
setcookie('akses_jual', '', 0);

// Redirect
setcookie("tempinput", "Logout Berhasil", time() + 2 * 24 * 60 * 60);
header('location: login.php');