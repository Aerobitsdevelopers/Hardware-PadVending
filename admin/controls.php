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
    $page = "controls";
    require 'header.php';
    ?>
    
    <main>
        <?php
            if(isset($_POST['reset'])){
                $id = $_POST['id'];
                $mysqli->query("UPDATE control SET dispenced=0 WHERE id=$id");
                header("Location: ".$_SERVER['PHP_SELF']);
            }

             $result = $mysqli->query("SELECT * FROM control");
             while($row = mysqli_fetch_array($result))
             {
                $percentage =  (int)(($row['dispenced'] / $row['max']) * 100);
                 echo '
                 <div class="control-box">
                    <h2>'.$row['size'].'</h2>
                    <p>Dispenced : '.$row['dispenced'].' / '.$row['max'].'</p>
                    <div class="circle">
                        <div class="progress-bar" data-width = "'.$percentage.'">
                            <progress min="0" max="100" style="visibility:hidden;height:0;width:0;"></progress>
                        </div>
                    </div>
                    <form method="POST">
                        <input type="number" value="'.$row['id'].'" name="id" hidden/>
                        <button type="submit" name="reset">Reset</button>
                    </form>
                </div>
                 ';
             }
        ?>
    </main>
    

</body>
<script src="./js/percentage.js"></script>