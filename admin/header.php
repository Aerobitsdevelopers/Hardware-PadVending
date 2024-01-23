<header>
    <img class="logo" src="./images/logo.png">
    <h1>
        Company Name<br>
        <b>Admin Panel for vending machine</b>
    </h1>
    <a class="btn-logout" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
</header>

<div class="side-nav">
    <a class="container <?php if($page == 'index'){echo 'active';}?>" href="index.php">
        <div class="icon"><i class="fas fa-chart-bar"></i></div>
        <p>Statistics</p>
    </a>
    <a class="container <?php if($page == 'controls'){echo 'active';}?>" href="controls.php">
        <div class="icon"><i class="fas fa-gamepad"></i></div>
        <p>Controls</p>
    </a>
    <a class="container <?php if($page == 'transactions'){echo 'active';}?>" href="transactions.php">
        <div class="icon"><i class="fas fa-server"></i></div>
        <p>Transactions</p>
    </a>
</div>