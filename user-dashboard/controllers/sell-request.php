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

    $inbox = trim($_POST['inbox']);
    $request_amount = trim($_POST['num']);
    $other = trim($_POST['other']);
    $wallet = trim($_POST['wallet']);
    $user = $_SESSION['user_mail'];
    $status = "درانتظار";
    $type = "فروش (ابطال)";
    $formatter = new IntlDateFormatter(
    "en_US@calendar=persian", 
    IntlDateFormatter::FULL, 
    IntlDateFormatter::FULL, 
    'Asia/Tehran', 
    IntlDateFormatter::TRADITIONAL, 
    "yyyy/MM/dd");
    $request_date = time();
    $request_date = $formatter->format($request_date);
    
    if(empty($inbox) || empty($request_amount) || empty($other) || $wallet == "none"){
        header("Location: ../?request=sell&error=emptyField");
        exit();
    }

    if($inbox != "inbox1" && $inbox != "inbox2" && $inbox != "inbox3"){
        header("Location: ../?request=sell&error=radioInvalid");
        exit();
    }
    if($other != "فروش فقط در این قیمت یا پایینتر از این" && $other != "فروش در هر قیمتی"){
        header("Location: ../?request=sell&error=radioInvalid");
        exit();
    }

    if(!is_numeric($request_amount)){
        header("Location: ../?request=sell&error=numInvalid");
        exit();
    }

    $fk = "تایید شده";
    $t = "خرید (صدور)";
    $sql = "SELECT * FROM wallets WHERE user = ? AND address=? AND status=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=sell&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sss" , $user , $wallet , $fk);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $row_num = mysqli_stmt_num_rows($stmt);
        if($row_num < 1){
            header("Location: ../?request=sell&error=walletInvalid");
            exit();
        }
    }

    $remaining_amount = 0;
    $sql = "SELECT * FROM requests WHERE type = ? AND inbox=? AND status=?  AND user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=sell&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $t,$inbox,$fk,$_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($res)){
            $remaining_amount = $remaining_amount + $row['remaining_amount'];
        }
    }
    if($remaining_amount < $request_amount){
        header("Location: ../?request=sell&error=numLow");
        exit();
    }

    $sql = "SELECT * FROM users WHERE mail=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?support&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $user);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $username = $row['name'];
        }
    }


    $sql = "SELECT * FROM setting_nav WHERE inbox = ? ORDER BY id DESC";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=sell&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $nav = $row['amount'];
        }
    }
	$u = "-";
    $sql = "INSERT INTO requests(type,request_amount,nav,status,request_date,wallet,inbox,other,url,pic,user) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=sell&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sssssssssss" , $type,$request_amount,$nav,$status,$request_date,$wallet,$inbox,$other,$u,$u,$user);
        mysqli_stmt_execute($stmt);
        $short_msg = "شما یک <strong>درخواست فروش</strong> از <strong>$username</strong> دریافت کردید.";
        $msg = "شما یک <strong>درخواست فروش</strong> از <strong>$username</strong> دریافت کردید.";
        $nf = "سیستم";
        $nt = "admins";
        $ns = "unseen";
        $sql = "INSERT INTO notifications(from_who,to_who,short_msg,msg,status) VALUES(?,?,?,?,?)";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?support&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "sssss" , $nf , $nt , $short_msg , $msg , $ns);
            mysqli_stmt_execute($stmt);
        }
        header("Location: ../?request=list");
        exit();
    }
}

?>