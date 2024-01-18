<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <?php
        require 'config.php';
        if(isset($_GET['size']) && isset($_GET['qty']) && isset($_GET['payment'])){
            $id = date("ymdHis");
            $size = mysqli_real_escape_string($mysqli, $_GET['size']);
            $qty = mysqli_real_escape_string($mysqli, $_GET['qty']);
            $payment = mysqli_real_escape_string($mysqli, $_GET['payment']);
           
            $mysqli->query("INSERT INTO transactions (
                id,
                size,	
                qty,	
                payment) 
                VALUES (
                '$id',
                '$size',	
                $qty,	
                '$payment')") or die(mysqli_error($mysqli));
        }
        ?>
        <script src="" async defer></script>
    </body>
</html>