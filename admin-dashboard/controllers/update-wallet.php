<?php session_start();
if(!isset($_SESSION['manager_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['sb'])){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    require "../../DB/db.php";
    $stmt = mysqli_stmt_init($conn);
    $address1 = trim($_POST['address1']);
    $address2 = trim($_POST['address2']);
    $address3 = trim($_POST['address3']);
    $network1 = trim($_POST['network1']);
    $network2 = trim($_POST['network2']);
    $network3 = trim($_POST['network3']);
    $inbox1 = "inbox1";
    $inbox2 = "inbox2";
    $inbox3 = "inbox3";
    if(empty($address1) || empty($address2) || empty($address3) || empty($network1) || empty($network2) || empty($network3)){
        header("Location: ../?setting=wallet&error=emptyField");
        exit();
    }
    $sql = "UPDATE setting_wallet SET address=?,network=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=wallet&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sss" , $address1,$network1,$inbox1);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE setting_wallet SET address=?,network=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=wallet&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sss" , $address2,$network2,$inbox2);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE setting_wallet SET address=?,network=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=wallet&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sss" , $address3,$network3,$inbox3);
        mysqli_stmt_execute($stmt);
        header("Location: ../?setting=wallet&status=success");
exit();
    }
}
?>