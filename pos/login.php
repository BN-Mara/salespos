<?php
/**
 * Created by PhpStorm.
 * User: shelton
 * Date: 29/06/2020
 * Time: 10:15
 */

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="twitter:site" content="@metroui">
    <meta name="twitter:creator" content="@pimenov_sergey">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Metro 4 Components Library">
    <meta name="twitter:description" content="Metro 4 is an open source toolkit for developing with HTML, CSS, and JS. Quickly prototype your ideas or build your entire app with responsive grid system, extensive prebuilt components, and powerful plugins built on jQuery.">
    <meta name="twitter:image" content="https://metroui.org.ua/images/m4-logo-social.png">

    <meta property="og:url" content="https://metroui.org.ua/v4/index.html">
    <meta property="og:title" content="Metro 4 Components Library">
    <meta property="og:description" content="Metro 4 is an open source toolkit for developing with HTML, CSS, and JS. Quickly prototype your ideas or build your entire app with responsive grid system, extensive prebuilt components, and powerful plugins built on jQuery.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://metroui.org.ua/images/m4-logo-social.png">
    <meta property="og:image:secure_url" content="https://metroui.org.ua/images/m4-logo-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="968">
    <meta property="og:image:height" content="504">

    <meta name="author" content="BN-Mara">
    <meta name="description" content="The most popular HTML, CSS, and JS library in Metro style.">
    <meta name="keywords" content="HTML, CSS, JS, Metro, CSS3, Javascript, HTML5, UI, Library, Web, Development, Framework">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <link href="css/metro-all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/w3.css">

    <title>login</title>

    <style>
        .login-form {
            width: 350px;
            height: auto;
            top: 50%;
            margin-top: -160px;
        }
		.bgColor{
			background-color: #A01775;
		}
    </style>
</head>
<body class="h-vh-100 bgColor">

<form class="login-form bg-white p-6 mx-auto border bd-default win-shadow"
      data-role="validator"
      data-clear-invalid="2000"
      data-on-error-form="invalidForm"
      data-on-validate-form="validateForm" method="post" action="auth.php">
    <?php
    if(isset($_SESSION['info'])){
        ?>
        <div class="w3-panel w3-pale-red w3-leftbar w3-border-red">
            <span class="w3-button w3-right" onclick="this.parentElement.style.display='none'">&times;</span>
            <?php
            echo "<p>".$_SESSION['info']."</p>";

            ?>
        </div>

        <?php
        unset($_SESSION['info']);
    }

    ?>
	<center><img src="images/Logoafricell.png" height="80"></center>
    <span class="mif-vpn-lock mif-4x place-right" style="margin-top: -10px;"></span>
    <h3 class="text-light">...Authentification...</h3>
    <hr class="thin mt-4 mb-4 bg-white">
    <div class="form-group">
        <input type="text" data-role="input" data-prepend="<span class='mif-envelop'>" name="usrname" placeholder="username" required>
    </div>
    <div class="form-group">
        <input type="password" data-role="input" data-prepend="<span class='mif-key'>" name="psw" placeholder="password" data-validate="required minlength=6">
    </div>
    <div class="form-group mt-10">
        <input type="checkbox" data-role="checkbox" data-caption="Remember me" class="place-right">
        <button class="button primary rounded" type="submit" name="login">Connexion</button>
    </div>
</form>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/metro.js"></script>
<script>
    function invalidForm(){
        var form  = $(this);
        form.addClass("ani-ring");
        setTimeout(function(){
            form.removeClass("ani-ring");
        }, 1000);
    }

    function validateForm(){
        $(".login-form").animate({
            opacity: 0
        });
    }
</script>

</body>
</html>