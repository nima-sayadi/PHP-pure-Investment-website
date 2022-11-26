<?php session_start();
if(!isset($_SESSION['user_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['condition'])){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    if($_POST['condition'] == "true"){
        require "../../DB/db.php";
        $stmt = mysqli_stmt_init($conn);
        $seen = "seen";
        $sql = "UPDATE notifications SET status=? WHERE to_who=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPrepare";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $seen , $_SESSION['user_mail']);
            mysqli_stmt_execute($stmt);
            echo "success";
            exit();
        }
    }
}

?>