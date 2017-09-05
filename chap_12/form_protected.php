<?php
session_start();
// generate token
$token = urlencode(base64_encode((random_bytes(32))));
$_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<head>
	<title>PHP 7 Cookbook</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="php7cookbook.css">
</head>
<body onload="load()">

<div class="container">

	<h1>CSRF Protected Form</h1>

    <form action="form_protected_with_token.php" method="post" id="csrf_test" name="csrf_test">
		<table>
        <tr><th>Name</th><td><input name="name" type="text" /></td></tr>
        <tr><th>Email</th><td><input name="email" type="text" /></td></tr>
        <tr><th>Comments</th><td><input name="comments" type="textarea" rows=4 cols=80 /></td></tr>
        <tr><th>&nbsp;</th><td><input name="process" type="submit" value="Process" /></td></tr>
        </table>
        <input type="hidden" name="token" value="<?= $token ?>" />
    </form>

	<a href="form_view_results.php">CLICK HERE</a> to view results

</div>
</body>
</html>

