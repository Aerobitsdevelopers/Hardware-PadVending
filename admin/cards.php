<?php require "session.php"; ?>

<head>
    <title>Vending Admin</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <?php 
    $page = "cards";
    require 'header.php';
    ?>
    
    <main>
        <table>
            <tr>
                <th>Card No:</th>
                <th>Name</th>
                <th>Balance</th>
            </tr>
        <?php
             $result = $mysqli->query("SELECT * FROM cards");
             while($row = mysqli_fetch_array($result))
             {
                 echo '
                 <tr>
                    <td>'.$row['card_no'].'</td>
                    <td class="capitalize">'.$row['name'].'</td>
                    <td>'.$row['balance'].'</td>
                </tr>
                 ';
             }
        ?>
        </table>
    </main>
    

</body>
<script src="./js/percentage.js"></script>