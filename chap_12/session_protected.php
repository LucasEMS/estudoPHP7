<?php
define('THUMB_PRINT_DIR', __DIR__ . '/../data/');
session_start();
session_regenerate_id();

$username = 'test';
$password = 'password';
$info = 'You Can Now See Super Secret Information!!!';
$loggedIn = $_SESSION['isLoggedIn'] ?? FALSE;
$loggedUser = $_SESSION['loggedUser'] ?? 'guest';


$remotePrint = md5($_SERVER['REMOTE_ADDR']
        . $_SERVER['HTTP_USER_AGENT']
        . $_SERVER['HTTP_ACCEPT_LANGUAGE']);
$printsMatch = file_exists(THUMB_PRINT_DIR . $remotePrint);

if (isset($_POST['login'])) {
    if ($_POST['username'] == $username
            && $_POST['password'] == $password) {
        $loggedIn = TRUE;
        $_SESSION['user'] = strip_tags($username);
        $_SESSION['isLoggedIn'] = TRUE;
        file_put_contents(
                THUMB_PRINT_DIR . $remotePrint, $remotePrint);
    } 
} elseif (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    setcookie('PHPSESSID', 0, time() - 3600);
    if (file_exists(THUMB_PRINT_DIR . $remotePrint))
            unlink(THUMB_PRINT_DIR . $remotePrint);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
} elseif ($loggedIn && !$printsMatch) {
    $info = 'SESSION INVALID!!!';
    error_log('Session Invalid: ' . date('Y-m-d H:i:s'), 0);
    // take appropriate action
}
?>

<!DOCTYPE html>
<head>
	<title>PHP 7 Cookbook</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="php7cookbook.css">
</head>
<body>

<div class="container">

	<!-- Simple Login -->
	<div style="width: 600px;">
	<form name="login" method="post">
	<h1>Session Protection</h1>
	Welcome: <?= $loggedUser; ?>
	<table>
	<tr><th>Username</th><td><input type="text" name="username" /></td></tr>
	<tr><th>Password</th><td><input type="password" name="password" /></td></tr>
	<tr><th>&nbsp;</th>
		<td>
			<input type="submit" name="login" value="Login" />
			<input type="submit" name="logout" value="Logout" />
			<input type="submit" name="refresh" value="Refresh" />
		</td>
	</tr>
	<tr><th>$_COOKIE</th><td><pre><?php var_dump($_COOKIE); ?></pre></td></tr>
	<tr><th>$_SESSION</th><td><pre><?php var_dump($_SESSION); ?></pre></td></tr>
	<tr><th>Secret Info</th><td><?php if ($loggedIn) echo $info; ?></td></tr>
	</table>
	</form>
	</div>
	<?php //phpinfo(INFO_VARIABLES); ?>
</div>

</body>
</html>

