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

    $msg = trim($_POST['msg']);
    $user = trim($_POST['user-mail']);
    $sql = "SELECT * FROM users WHERE mail=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?support=show&mail=$user&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $user);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $username = $row['name'];
        }
        else{
            header("Location: ../?support=show&mail=$user&error=userNotExist");
            exit();
        }
    }
    $ns = "unseen";
    $nsf = "seen";
    if(empty($msg) || empty($user)){
        header("Location: ../?support=show&mail=$user&error=emptyField");
        exit();
    }
    $msg = nl2br($msg);
    $formatter = new IntlDateFormatter(
    "en_US@calendar=persian", 
    IntlDateFormatter::FULL, 
    IntlDateFormatter::FULL, 
    'Asia/Tehran', 
    IntlDateFormatter::TRADITIONAL, 
    "yyyy/MM/dd --> HH:mm");
    $date = time();
    $date = $formatter->format($date);
    $from_status = "other";
    if(empty($_FILES['attachment']['name'])){
        $sql = "INSERT INTO tickets(user,msg,from_status,date,status) VALUES(?,?,?,?,?)";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?support=show&mail=$user&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "sssss" , $user , $msg , $from_status , $date,$nsf);
            mysqli_stmt_execute($stmt);
            $short_msg = "شما یک پیغام از <strong>پشتیبانی</strong> دریافت کردید.";
            $msg = "شما یک پیغام از <strong>پشتیبانی</strong> دریافت کردید.";
            $nf = "سیستم";
            $ns = "unseen";
            $sql = "INSERT INTO notifications(from_who,to_who,short_msg,msg,status) VALUES(?,?,?,?,?)";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                header("Location: ../?support=show&mail=$user&error=SQLNotPrepare");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "sssss" , $nf , $user , $short_msg , $msg , $ns);
                mysqli_stmt_execute($stmt);
                header("Location: ../?support=show&mail=$user");
                exit();
            }
        }
    }
    else{
        $ext = pathinfo(basename($_FILES['attachment']['name']), PATHINFO_EXTENSION);
        $ext = strtolower($ext);
        $file_name = getToken(10);
        $file_name = $file_name."".".$ext";
        $target = "../../attachments/$file_name";
        $sql = "INSERT INTO tickets(user,msg,from_status,date,file,status) VALUES(?,?,?,?,?,?)";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?support=show&mail=$user&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ssssss" , $user , $msg , $from_status , $date , $file_name,$nsf);
            mysqli_stmt_execute($stmt);
            move_uploaded_file($_FILES['attachment']['tmp_name'],$target);
            $short_msg = "شما یک پیغام از <strong>پشتیبانی</strong> دریافت کردید.";
            $msg = "شما یک پیغام از <strong>پشتیبانی</strong> دریافت کردید.";
            $nf = "سیستم";
            $ns = "unseen";
            $sql = "INSERT INTO notifications(from_who,to_who,short_msg,msg,status) VALUES(?,?,?,?,?)";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                header("Location: ../?support=show&mail=$user&error=SQLNotPrepare");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "sssss" , $nf , $user , $short_msg , $msg , $ns);
                mysqli_stmt_execute($stmt);
                header("Location: ../?support=show&mail=$user");
                exit();
            }
        }
    }
}
?>