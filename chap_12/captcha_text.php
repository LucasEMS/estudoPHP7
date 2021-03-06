<?php
require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');
use Application\Captcha\Reverse;

session_start();
session_regenerate_id();


function setCaptcha(&$phrase, &$label, &$image)
{
    $captcha    = new Reverse();
    $phrase     = $captcha->getPhrase();
    $label      = $captcha->getLabel();
    $image      = $captcha->getImage();
    $_SESSION['phrase'] = $phrase;
}

$image  = '';
$label  = '';
$phrase     = $_SESSION['phrase'] ?? '';
$messafe    = '';
$info       = 'You Can Now See Super Secret Information!!!';
$loggedIn   = $_SESSION['isLoggedIn'] ?? FALSE;
$loggedUser = $_SESSION['user'] ?? 'guest';

if (!empty($_POST['login'])) {
    if (empty($_POST['captcha'])) {
        $message = 'Enter Captcha Phrase and Login Information';
    } else {
        if ($_POST['captcha'] == $phrase) {
            $username = 'test';
            $password = 'password';
            if ($_POST['pass'] == $password) {
                $loggedIn = TRUE;
                $_SESSION['user'] = strip_tags($username);
                $_SESSION['isLoggedIn'] = TRUE;
            } else {
                $message = 'Invalid Login';
            }
        } else {
            $message = 'Invalid Captcha';
        }
    }
    
} elseif (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    setcookie('PHPSESSID', 0, time() - 3600);
    header('Location: ' . $_SERVER['REQUEST_URI'] );
    exit;
}

setCaptcha($phrase, $label, $image);


include __DIR__ . '/captcha_view_include.php';
