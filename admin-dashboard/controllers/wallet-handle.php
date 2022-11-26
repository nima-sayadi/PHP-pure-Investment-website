<?php session_start();
if(!isset($_SESSION['manager_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['confirm']) && !isset($_POST['deny'])){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    require "../../DB/db.php";
    $stmt = mysqli_stmt_init($conn);
    $id = trim($_POST['id']);
    $mail = trim($_POST['mail']);
    $confirm = "تایید شده";
    $deny = "تایید نشده";
    if(empty($id)){
        header("Location: ../?wallet=list&error=emptyField");
        exit();
    }
    if(isset($_POST['confirm'])){
        $sql = "UPDATE wallets SET status=? WHERE id=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?wallet=list&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $confirm,$id);
            mysqli_stmt_execute($stmt);
        }
        $short_msg = "درخواست ثبت کیف پول شما <strong style='color:green;'>تایید شد</strong>.";
        $msg = "درخواست ثبت کیف پول شما <strong style='color:green;'>تایید شد</strong>.";
        $nf = "سیستم";
        $ns = "unseen";
        $sql = "INSERT INTO notifications(from_who,to_who,short_msg,msg,status) VALUES(?,?,?,?,?)";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?support&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "sssss" , $nf , $mail , $short_msg , $msg , $ns);
            mysqli_stmt_execute($stmt);
            header("Location: ../?wallet=list");
            exit();
        }
    }
    else{
        $sql = "UPDATE wallets SET status=? WHERE id=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?wallet=list&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $deny,$id);
            mysqli_stmt_execute($stmt);
        }
        $short_msg = "درخواست ثبت کیف پول شما <strong style='color:red;'>تایید نشد</strong>.";
        $msg = "درخواست ثبت کیف پول شما <strong style='color:red;'>تایید نشد</strong>.";
        $nf = "سیستم";
        $ns = "unseen";
        $sql = "INSERT INTO notifications(from_who,to_who,short_msg,msg,status) VALUES(?,?,?,?,?)";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?support&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "sssss" , $nf , $mail , $short_msg , $msg , $ns);
            mysqli_stmt_execute($stmt);
            header("Location: ../?wallet=list");
            exit();
        }
    }
}
?>