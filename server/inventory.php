<?php
require 'config.php';
if(isset($_GET['size']) && isset($_GET['qty']) && isset($_GET['payment'])){
    $id = date("ymdHis");
    $size = mysqli_real_escape_string($mysqli, $_GET['size']);
    $qty = mysqli_real_escape_string($mysqli, $_GET['qty']);
    $payment = mysqli_real_escape_string($mysqli, $_GET['payment']);
    
    switch($size){
        case 'regular':
            $control_id = 1;
            break;
        case 'large':
            $control_id = 2;
            break;
        case 'night':
            $control_id = 3;
            break;
        default:
            $control_id = 1;
    }

    $result = $mysqli->query("SELECT * FROM control WHERE id = $control_id");
    if ($result) {
        $row = $result->fetch_assoc();
        // Return the response as JSON
        // Add values to the response array
        $response['remaining'] = $row['max'] - $row['dispenced'];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if($response['remaining']-$qty >= 0){
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
        $mysqli->query("UPDATE control SET dispenced=dispenced+$qty WHERE id=$control_id");
        if(explode($payment, "_")[0] === 'rfid'){
            $card_id = explode($payment, "_")[1];
            $mysqli->query("UPDATE cards SET balance=balance-$qty WHERE card_no='$card_id' IF EXISTS");
        }
    }
}
?>