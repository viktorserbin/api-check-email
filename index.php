<?php

require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';
require_once 'cfg' . DIRECTORY_SEPARATOR . 'app_config.php';

$email='';
$msg='';
$error_success_message='';
$title = 'api-ceck-email';

if (!empty($_POST)) {
    $email_address = $_POST['email'];
    $result= mailboxlayer($email_address);
    if (
    $result['format_valid'] and
    $result['mx_found'] and
    $result['smtp_check']
    ){
        $file_name=DATA_DIR.DIRECTORY_SEPARATOR.uniqid()."_".time().".txt";
        file_put_contents($file_name, $_POST['email'].PHP_EOL.$_POST['msg']);
        $error_success_message = '<p class="success">Сообщение успешно отправлено.</p>';

    } else {
        $email = $_POST['email'];
        $msg = $_POST['msg'];
        $error_success_message= sprintf('<p class="error">Ваш адрес не прошел проверку. Сообщение не отправлено. Возможно Вы имелли ввиду <strong>%s</strong></p>',
            $result['did_you_mean']);
    }
}

echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>$title</title>
    <link rel="stylesheet" href="css/style.css"/>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <link href="https://www.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://www.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="js/form-validation.js"></script>
</head>
<body>

<div class="container">
$error_success_message
<form action="" method="post" name="registration"> 
<div><label for="email">Email <i>*</i>: </label> <input type="text" id="umail" value = "$email" name="email" required></div>
<br /> 
<div><label for="msg">Message <i>*</i>: </label><br><textarea name="msg"  style="width:100%;" required>$msg</textarea></div>
<br /> 
<div><input type="submit" value="Add comment"></div>
<div><i>*</i> - required fields</div> 
</form></div>

</body>
</html>

EOT;
