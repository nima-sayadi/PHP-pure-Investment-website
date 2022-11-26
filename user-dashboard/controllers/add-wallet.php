<?php session_start();
if(!isset($_SESSION['user_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['sb'])){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    require "../../DB/db.php";
    $stmt = mysqli_stmt_init($conn);
    $address = trim($_POST['wallet']);
    $network = trim($_POST['network']);
    $user = $_SESSION['user_mail'];
    $status = "درانتظار";
    $formatter = new IntlDateFormatter(
    "en_US@calendar=persian", 
    IntlDateFormatter::FULL, 
    IntlDateFormatter::FULL, 
    'Asia/Tehran', 
    IntlDateFormatter::TRADITIONAL, 
    "yyyy/MM/dd");
    $date = time();
    $date = $formatter->format($date);
    
    if(empty($address) || empty($user) || empty($status) || empty($network)){
        header("Location: ../?wallet=add&error=emptyField");
        exit();
    }
    // $sql = "SELECT * FROM wallets WHERE address = ?";
    // if(!mysqli_stmt_prepare($stmt , $sql)){
    //     header("Location: ../?wallet=add&error=SQLNotPrepare");
    //     exit();
    // }
    // else{
    //     mysqli_stmt_bind_param($stmt , "s" , $address);
    //     mysqli_stmt_execute($stmt);
    //     mysqli_stmt_store_result($stmt);
    //     $num = mysqli_stmt_num_rows($stmt);
    //     if($num > 0){
    //         header("Location: ../?wallet=add&error=walletExist");
    //         exit();
    //     }
    // }

    $sql = "SELECT * FROM users WHERE mail=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?wallet=add&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $user);
        mysqli_stmt_execute($stmt);
        $res2 = mysqli_stmt_get_result($stmt);
        if($row2 = mysqli_fetch_assoc($res2)){
            $username = $row2['name'];
        }
    }
    

    $sql = "INSERT INTO wallets(user,address,status,date,network) VALUES(?,?,?,?,?)";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?wallet=add&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sssss" , $user , $address , $status,$date,$network);
        mysqli_stmt_execute($stmt);
        $short_msg = "شما یک درخواست <strong style='color:red;'>ثبت کیف پول</strong> از کاربر <strong>$username</strong> دریافت کردید.";
        $msg = "شما یک درخواست <strong style='color:red;'>ثبت کیف پول</strong> از کاربر <strong>$username</strong> دریافت کردید.";
        $nf = "سیستم";
        $ns = "unseen";
        $ms = "admins";
        $sql = "INSERT INTO notifications(from_who,to_who,short_msg,msg,status) VALUES(?,?,?,?,?)";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?support&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "sssss" , $nf , $ms , $short_msg , $msg , $ns);
            mysqli_stmt_execute($stmt);
        }
        header("Location: ../?wallet=list");
        exit();
    }
}

?>