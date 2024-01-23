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
    $page = "transactions";
    require 'header.php';
    ?>
    
    <main>
        <table>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Payment Mode</th>
                <th>Payment ID</th>
            </tr>
        <?php
             $result = $mysqli->query("SELECT * FROM transactions ORDER BY id DESC LIMIT 30");
             while($row = mysqli_fetch_array($result))
             {
                $dateTime = DateTime::createFromFormat('ymdHis', $row['id']);
                if (!$dateTime) {
                    echo "Error parsing input string";
                } else {
                    // Format the date and time
                    $formattedDate = $dateTime->format('d/m/y');
                    $formattedTime = $dateTime->format('H:i:s');
                }
                 echo '
                 <tr>
                    <td>'.$formattedDate.'</td>
                    <td>'.$formattedTime.'</td>
                    <td class="capitalize">'.$row['size'].'</td>
                    <td>'.$row['qty'].'</td>
                    <td class="capitalize">'.explode('_',$row['payment'])[0].'</td>
                    <td>'.explode('_',$row['payment'])[1].'</td>
                </tr>
                 ';
             }
        ?>
        </table>
    </main>
    

</body>
<script src="./js/percentage.js"></script>