<?php session_start();
if(!isset($_SESSION['manager_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['sb-confirm']) && !isset($_POST['sb-deny'])){
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
    $formatter = new IntlDateFormatter(
    "en_US@calendar=persian", 
    IntlDateFormatter::FULL, 
    IntlDateFormatter::FULL, 
    'Asia/Tehran', 
    IntlDateFormatter::TRADITIONAL, 
    "yyyy/MM/dd");
    $date = time();
    $date = $formatter->format($date);

    $id = trim($_POST['id']);
    $price = trim($_POST['price']);

    if(empty($id) || empty($price)){
        header("Location: ../?request=show&id=$id&error=emptyField");
        exit();
    }

    $sql = "SELECT * FROM requests WHERE id=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $type = $row['type'];
            $request_num = $row['request_amount'];
            $mail = $row['user'];
            $inbox = $row['inbox'];
            $s = $row['status'];
        }
        else{
            header("Location: ../?request=show&id=$id&error=idNotValid");
            exit();
        }
    }

    if($s == "تایید شده"){
        header("Location: ../?request=list");
        exit();
    }

    if($type == "خرید (صدور)"){
        $text = "خرید";
    }
    else{
        $text = "فروش";
    }
    
    if(isset($_POST['sb-deny'])){
        $status = "تایید نشده";
        $date = "-";
        $sql = "UPDATE requests SET status=?,confirm_date=? WHERE id=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "sss" , $status,$date , $id);
            mysqli_stmt_execute($stmt);
            $short_msg = "درخواست $text شما <strong style='color:red;'>تایید نشد</strong>.";
            $msg = "درخواست $text شما <strong style='color:red;'>تایید نشد</strong>.";
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
            }
            header("Location: ../?request=list");
            exit();
        }
    }
    else{
        $status = "تایید شده";
        if(!is_numeric($price)){
            header("Location: ../?request=show&id=$id&error=numInvalid");
            exit();
        }

        $sql = "SELECT * FROM setting_nav WHERE inbox=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "s" , $inbox);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($res)){
                $nav = $row['amount'];
            }
            else{
                header("Location: ../?request=show&id=$id&error=inboxNotValid");
                exit();
            }
        }

        if($type == "خرید (صدور)"){
            $sql = "UPDATE requests SET status=?,confirm_date=?,buy_price=? WHERE id=?";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "ssss" , $status,$date,$price,$id);
                mysqli_stmt_execute($stmt);
                $short_msg = "درخواست $text شما <strong style='color:green;'>تایید شد</strong>.";
                $msg = "درخواست $text شما <strong style='color:green;'>تایید شد</strong>.";
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
                }
                header("Location: ../?request=list");
                exit();
            }
        }
        else{
            $url = trim($_POST['url']);
            if(empty($url) && empty($_FILES['pic']['name'])){
                header("Location: ../?request=show&id=$id&error=oneField");
                exit();
            }
            /////////// Calculations Core ///////////
            $type = "خرید (صدور)";
            $tax = 0;
            $zero = 0;
            $sql = "SELECT * FROM requests WHERE user=? AND type=? AND status=? AND inbox=? ORDER BY id ASC";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "ssss" , $mail,$type,$status,$inbox);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);
                while($row = mysqli_fetch_assoc($res)){
                    if($request_num > 0){
                        if($row['remaining_amount'] > 0){
                            if($row['remaining_amount'] < $request_num){
                                $request_num = $request_num - $row['remaining_amount'];
                                $sql = "UPDATE requests SET remaining_amount=? WHERE id=?";
                                if(!mysqli_stmt_prepare($stmt , $sql)){
                                    header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt , "ss" , $zero,$row['id']);
                                    mysqli_stmt_execute($stmt);
                                }
                            }
                            else{
                                $new_remaining = $row['remaining_amount'] - $request_num;
                                $new_id = $row['id'];
                                $request_num = 0;
                            }
                            if($request_num > 0){
                                $tax = $tax + ($row['remaining_amount'] * $row['tax']);
                            }
                            else{
                                $tax = $tax + (($row['remaining_amount'] - $new_remaining) * $row['tax']);
                            }
                        }
                    }
                }
            }
        
            $sql = "UPDATE requests SET remaining_amount=? WHERE id=?";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "ss" , $new_remaining,$new_id);
                mysqli_stmt_execute($stmt);
            }

            $final = $price - $tax;
            /////////// End Of Calculations Core ///////////

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
            $sql = "UPDATE requests SET status=?,confirm_date=?,sell_price=?,url=?,pic=? WHERE id=?";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                header("Location: ../?request=show&id=$id&error=SQLNotPrepare");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "ssssss" , $status,$date,$final,$url,$pic_name,$id);
                mysqli_stmt_execute($stmt);
                if(!empty($_FILES['pic']['name'])){
                    move_uploaded_file($_FILES['pic']['tmp_name'],$target);
                }
                $short_msg = "درخواست $text شما <strong style='color:green;'>تایید شد</strong>.";
                $msg = "درخواست $text شما <strong style='color:green;'>تایید شد</strong>.";
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
                }
                header("Location: ../?request=list");
                exit();
            }
        }
    }
}
?>