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
    $name1 = trim($_POST['name1']);
    $name2 = trim($_POST['name2']);
    $name3 = trim($_POST['name3']);
    $inbox1 = "inbox1";
    $inbox2 = "inbox2";
    $inbox3 = "inbox3";
    if(empty($name1) || empty($name2) || empty($name3)){
        header("Location: ../?setting=inbox&error=emptyField");
        exit();
    }
    $sql = "UPDATE setting_inbox SET name=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=inbox&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $name1,$inbox1);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE setting_inbox SET name=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=inbox&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $name2,$inbox2);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE setting_inbox SET name=? WHERE inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?setting=inbox&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $name3,$inbox3);
        mysqli_stmt_execute($stmt);
        header("Location: ../?setting=inbox&status=success");
exit();
    }
}
?>