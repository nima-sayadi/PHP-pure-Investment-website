<?php session_start();
if(!isset($_SESSION['manager_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['sb']) || $_SESSION['priv'] != "super-admin"){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    require "../../DB/db.php";
    $stmt = mysqli_stmt_init($conn);
    $id = trim($_POST['id']);

    if(empty($id)){
        header("Location: ../?admin=list&error=emptyField");
        exit();
    }

    $sql = "DELETE FROM users WHERE id=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?admin=list&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $id);
        mysqli_stmt_execute($stmt);
        header("Location: ../?admin=list");
        exit();
    }
}
?>