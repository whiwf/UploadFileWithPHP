<?php

define('ENV', 'development');

require('core/Function.php');
require('model/Session.php');

if(ENV == 'development'){
    //report all error
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    set_error_handler('showError');
}

//create session
$session = new session();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP File Upload</title>
</head>
<body>
    <?php
        if($session->has('message')){
            printf('<b>%s</b>', $_SESSION['message']);
            $session->remove('message');
        }
    ?>
    <form method="POST" action="core/Upload.php" enctype="multipart/form-data">
        <div>
            <span>Upload a File:</span>
            <input type="file" name="uploadedFile">
        </div>
        <input type="submit" name="uploadBtn" value="Upload">
    </form>
</body>
</html>