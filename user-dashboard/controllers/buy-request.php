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
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }
    
    function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited
    
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
        }
    
        return $token;
    }

    $inbox = trim($_POST['inbox']);
    $request_amount = trim($_POST['num']);
    $other = trim($_POST['other']);
    $url = trim($_POST['url']);
    $user = $_SESSION['user_mail'];
    $status = "درانتظار";
    $type = "خرید (صدور)";
    $formatter = new IntlDateFormatter(
    "en_US@calendar=persian", 
    IntlDateFormatter::FULL, 
    IntlDateFormatter::FULL, 
    'Asia/Tehran', 
    IntlDateFormatter::TRADITIONAL, 
    "yyyy/MM/dd");
    $request_date = time();
    $request_date = $formatter->format($request_date);
    
    if(empty($inbox) || empty($request_amount) || empty($other)){
        header("Location: ../?request=buy&error=emptyField");
        exit();
    }

    if(empty($url) && empty($_FILES['pic']['name'])){
        header("Location: ../?request=buy&error=oneField");
        exit();
    }

    if($inbox != "inbox1" && $inbox != "inbox2" && $inbox != "inbox3"){
        header("Location: ../?request=buy&error=radioInvalid");
        exit();
    }
    if($other != "خرید فقط در این قیمت یا پایینتر از این" && $other != "خرید در هر قیمتی"){
        header("Location: ../?request=buy&error=radioInvalid");
        exit();
    }

    if(!is_numeric($request_amount)){
        header("Location: ../?request=buy&error=numInvalid");
        exit();
    }

    if(!empty($_FILES['pic']['name'])){
        $ext = pathinfo(basename($_FILES['pic']['name']), PATHINFO_EXTENSION);
        $ext = strtolower($ext);
        if($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "tif" && $ext != "tiff" && $ext != "pdf"){
            header("Location: ../?request=buy&error=extInvalid");
            exit();
        }
        $pic_name = getToken(10);
        $pic_name = $pic_name."".".$ext";
        $target = "../../request-pics/$pic_name";
    }
    else{
        $pic_name = "-";
    }
    if(empty($url)){
        $url = "-";
    }

    $sql = "SELECT * FROM setting_wallet WHERE inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $wallet = $row['address'];
        }
    }

    $sql = "SELECT * FROM setting_tax WHERE inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $tax = $row['tax'];
        }
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

    $fk = "تایید شده";
    $remaining_amount = $request_amount;


    $sql = "SELECT * FROM setting_nav WHERE inbox = ? ORDER BY id DESC";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
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


    $tax = $tax * $request_amount;


    $sql = "INSERT INTO requests(type,request_amount,nav,tax,status,request_date,wallet,remaining_amount,inbox,other,url,pic,user) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sssssssssssss" , $type,$request_amount,$nav,$tax,$status,$request_date,$wallet,$remaining_amount,$inbox,$other,$url,$pic_name,$user);
        mysqli_stmt_execute($stmt);
        if(!empty($_FILES['pic']['name'])){
            move_uploaded_file($_FILES['pic']['tmp_name'],$target);
        }
        $short_msg = "شما یک <strong>درخواست خرید</strong> از <strong>$username</strong> دریافت کردید.";
        $msg = "شما یک <strong>درخواست خرید</strong> از <strong>$username</strong> دریافت کردید.";
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