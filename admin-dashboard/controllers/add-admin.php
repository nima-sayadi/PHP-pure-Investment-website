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
    $name = trim($_POST['name']);
    $mail = trim($_POST['mail']);
    $priv = "admin";
    $date = time();

    if(empty($name) || empty($mail)){
        header("Location: ../?admin=add&error=emptyField");
        exit();
    }

    $sql = "SELECT * FROM users WHERE mail = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPrepare";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $mail);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $user_num = mysqli_stmt_num_rows($stmt);
    }
    if($user_num > 0){
        header("Location: ../?admin=add&error=mailExist");
        exit();
    }
    $sql = "INSERT INTO users(mail,name,reg_date,priv) VALUES(?,?,?,?)";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?admin=add&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $mail , $name , $date , $priv);
        mysqli_stmt_execute($stmt);
        header("Location: ../?admin=list");
        exit();
    }
}
?>