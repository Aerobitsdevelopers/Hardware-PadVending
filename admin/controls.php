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
        <div class="control-box">
            <h2>Regular</h2>
            <p>Dispenced : 40 / 100</p>
            <div class="circle">
                <div class="progress-bar" data-width = "<?php echo '40';?>">
                    <progress min="0" max="100" style="visibility:hidden;height:0;width:0;"></progress>
                </div>
            </div>
            <button>Reset</button>
        </div>
        <div class="control-box">
            <h2>Large</h2>
            <p>Dispenced : 20 / 100</p>
            <div class="circle">
                <div class="progress-bar" data-width = "<?php echo '20';?>">
                    <progress min="0" max="100" style="visibility:hidden;height:0;width:0;"></progress>
                </div>
            </div>
            <button>Reset</button>
        </div>
        <div class="control-box">
            <h2>Night</h2>
            <p>Dispenced : 60 / 100</p>
            <div class="circle">
                <div class="progress-bar" data-width = "<?php echo '60';?>">
                    <progress min="0" max="100" style="visibility:hidden;height:0;width:0;"></progress>
                </div>
            </div>
            <button>Reset</button>
        </div>
    </main>
    

</body>
<script src="./js/percentage.js"></script>