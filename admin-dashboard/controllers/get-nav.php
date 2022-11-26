<?php session_start();
if(!isset($_SESSION['manager_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['unix'])){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    require "../../DB/db.php";
    $stmt = mysqli_stmt_init($conn);
    $unix = trim($_POST['unix']);
    $unix = $unix / 1000;
    $inbox1 = "inbox1";
    $inbox2 = "inbox2";
    $inbox3 = "inbox3";
    $prices = [];
    $sql = "SELECT * FROM nav_records WHERE date=? AND inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPrepare";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $unix,$inbox1);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            array_push($prices,$row['amount']);
        }
        else{
            array_push($prices,"");
        }
    }
    $sql = "SELECT * FROM nav_records WHERE date=? AND inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPrepare";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $unix,$inbox2);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            array_push($prices,$row['amount']);
        }
        else{
            array_push($prices,"");
        }
    }
    $sql = "SELECT * FROM nav_records WHERE date=? AND inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPrepare";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $unix,$inbox3);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            array_push($prices,$row['amount']);
        }
        else{
            array_push($prices,"");
        }
    }
    echo json_encode($prices);
    exit();
    
}

?>