<?php
session_start();
if(isset($_GET['email']) && isset($_GET['password'])){
	$_SESSION['email'] = $_GET['email'];
	$_SESSION['password'] = $_GET['password'];
	//setcookie("email", $_GET["email"], time() + (60 * 2));
	//setcookie("password", $_GET["password"], time() + (60 * 2));
	echo "Login Berhasil!</br>";
}
if((isset($_SESSION['email']) && isset($_SESSION['password']))){
	echo "Anda Sudah Login!</br>";
	?>
	<form method="post">
        <input type="submit" value="Logout" name="btnLogout"/>
	</form>
	<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		//something posted
		if (isset($_POST['btnLogout'])) {
			session_destroy();
			session_unset();
			header("Location: index.php");
			die();
		}
	}
	echo "SESSION Email: ".$_SESSION['email'];
	echo "</br>";
	echo "SESSION Password: ".$_SESSION['password'];
} else {
?>
<html>
    <head>
        <title>Login Form</title>
        <style>
            input[type=text]
            {
                border: 1px solid #ccc;
                border-radius: 3px;
                box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
                width:200px;
                min-height: 28px;
                padding: 4px 20px 4px 8px;
                font-size: 12px;
                -moz-transition: all .2s linear;
                -webkit-transition: all .2s linear;
                transition: all .2s linear;
            }
            input[type=text]:focus
            {
                width: 400px;
                border-color: #51a7e8;
                box-shadow: inset 0 1px 2px rgba(0,0,0,0.1),0 0 5px rgba(81,167,232,0.5);
                outline: none;
            }
        </style>
    </head>
    <body  style="width: 100%; height: 100%;">
        <div id="tabs-1">
            <form action="http://localhost/sso_iframe/servercookies/index.php" method="post">
                <p><input id="email" name="email" type="text" placeholder="Email"></p>
                <p><input id="password" name="password" type="text" placeholder="Password"></p>
                <p><input type="submit" value="Login" /></p>
            </form>
        </div>
    </body>
</html>

<?php
}
?>

<?php
$tokenSender = "&#*#&sender&#*#&1234567890&#*#&sender&#*#&";
urlencode(encrypt($tokenSender, $tokenSender));

function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

/**
 * Returns decrypted original string
 */
function decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}
?>	