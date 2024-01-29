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
    $page = "add";
    require 'header.php';

    if(isset($_POST['add_card'])){
        $card_no = $_POST['card_no'];
        $name = $_POST['name'];
        $balance = $_POST['balance'];
        $mysqli->query("INSERT INTO cards (
            id,
            name,	
            balance,	
            card_no) 
            VALUES (
            0,
            '$name',	
            $balance,	
            '$card_no')");
        header("Location: cards.php");
    }
    ?>
    
    <main>
        <form method="POST" class="input-form">
            <div class="input-field">
                <label>Card Number</label>
                <input type="text" placeholder="000000000000" name="card_no"/>
            </div>
            <div class="input-field">
                <label>Name</label>
                <input type="text" placeholder="John Doe" name="name"/>
            </div>
            <div class="input-field">
                <label>Initial Balance</label>
                <input type="number" min="1" max="100" placeholder="100" name="balance"/>
            </div>
            <button type="submit" name="add_card">Add Card User</button>
        </form>
    </main>
    

</body>
<script src="./js/percentage.js"></script>