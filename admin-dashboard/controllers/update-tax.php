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

    $tax1 = trim($_POST['tax1']);
    $tax2 = trim($_POST['tax2']);
    $tax3 = trim($_POST['tax3']);
    $inbox1 = "inbox1";
    $inbox2 = "inbox2";
    $inbox3 = "inbox3";
    if((empty($tax1) && !is_numeric($tax1)) || (empty($tax2) && !is_numeric($tax2)) || (empty($tax3) && !is_numeric($tax3))){
        header("Location: ../?setting=tax&error=emptyField");
        exit();
    }
    $sql = "UPDATE setting_tax SET tax=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=tax&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $tax1,$inbox1);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE setting_tax SET tax=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=tax&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $tax2,$inbox2);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE setting_tax SET tax=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=tax&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $tax3,$inbox3);
        mysqli_stmt_execute($stmt);
        header("Location: ../?setting=tax&status=success");
        exit();
    }
}
?>