<?php session_start();
if(isset($_SESSION['user_mail'])  || isset($_SESSION['manager_mail'])){
    echo "logged in";
}
elseif(!isset($_POST['step'])){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
elseif($_POST['step'] != "one" && $_POST['step'] != "two"){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    require "../DB/db.php";
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
        $codeAlphabet = "0123456789";
        $max = strlen($codeAlphabet); // edited
    
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
        }
    
        return $token;
    }
    $mail = trim($_POST['mail']);
    if($_POST['step'] == "one"){
        $token = getToken(6);
        if(empty($mail)){
            echo "emptyField";
            exit();
        }
        elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            echo "wrongFormat";
            exit();
        }
        else{
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
            $sql = "SELECT * FROM activation WHERE mail = ?";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                echo "SQLNotPrepare";
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "s" , $mail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rows_num = mysqli_stmt_num_rows($stmt);
                // if($rows_num > 0 && $user_num > 0){
                //     echo "mailAlreadySent";
                //     exit();
                // }
                // else if($rows_num > 0 && $user_num < 1){
                //     $sql = "DELETE FROM activation WHERE mail = ?";
                //     if(!mysqli_stmt_prepare($stmt , $sql)){
                //         echo "SQLNotPrepare";
                //         exit();
                //     }
                //     else{
                //         mysqli_stmt_bind_param($stmt , "s" , $mail);
                //         mysqli_stmt_execute($stmt);   
                //     }
                // }
                if($rows_num > 0){
                    $sql = "DELETE FROM activation WHERE mail = ?";
                    if(!mysqli_stmt_prepare($stmt , $sql)){
                        echo "SQLNotPrepare";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt , "s" , $mail);
                        mysqli_stmt_execute($stmt);   
                    }
                }
                
                $sql = "INSERT INTO activation(mail,code) VALUES(?,?)";
                if(!mysqli_stmt_prepare($stmt , $sql)){
                    echo "SQLNotPrepare";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt , "ss" , $mail,$token);
                    mysqli_stmt_execute($stmt);
                    // Send mail here ...
                    if($user_num > 0){
                        echo "success-login";
                        exit();
                    }
                    else{
                        echo "success-register";
                        exit();
                    }
                }
            }
        }

    }
    else{
        $token = trim($_POST['token']);
        $date = time();
        if(empty($mail)){
            echo "emptyField";
            exit();
        }
        elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            echo "wrongFormat";
            exit();
        }
        else{
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

            if($user_num < 1){
                $name = trim($_POST['name']);
                $tel = trim($_POST['tel']);
                if(empty($tel)){
                    $tel = "-";
                }
                if(empty($name)){
                    echo "emptyField";
                    exit();
                }
            }
            else{
                $sql = "SELECT * FROM users WHERE mail = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt , $sql)){
                    echo "SQLNotPrepare";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt , "s" , $mail);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($res)){
                        $priv = $row['priv'];
                    }
                }
            }

            $sql = "SELECT * FROM activation WHERE code = ? AND mail = ?";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                echo "SQLNotPrepare";
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "ss" , $token , $mail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $token_num = mysqli_stmt_num_rows($stmt);
            }
            if($token_num < 1){
                echo "wrongToken";
                exit();
            }
            else{
                $sql = "DELETE FROM activation WHERE code = ?";
                if(!mysqli_stmt_prepare($stmt , $sql)){
                    echo "SQLNotPrepare";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt , "s" , $token);
                    mysqli_stmt_execute($stmt);   
                }
                $percenatge = "0";
                $ini_priv = "user";
                if($user_num < 1){
                    $sql = "INSERT INTO users(mail,name,tel,percentage,reg_date,priv) VALUES(?,?,?,?,?,?)";
                    if(!mysqli_stmt_prepare($stmt , $sql)){
                        echo "SQLNotPrepare";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt , "ssssss" , $mail , $name , $tel , $percenatge , $date , $ini_priv);
                        mysqli_stmt_execute($stmt);
                        $_SESSION['start_time'] = time();
                        $_SESSION['user_mail'] = $mail;
                        $short_msg = "کاربر جدید با ایمیل <strong>$mail</strong> و نام <strong>$name</strong> ثبت نام کرد.";
                        $msg = "کاربر جدید با ایمیل <strong>$mail</strong> و نام <strong>$name</strong> ثبت نام کرد.";
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
                        echo "success-user";
                        exit();
                    }
                }
                else{
                    $_SESSION['start_time'] = time();
                    if($priv == "admin" || $priv == "super-admin"){
                        $_SESSION['manager_mail'] = $mail;
                        $_SESSION['priv'] = $priv;
                        echo "success-admin";
                        exit();
                    }
                    else{
                        $_SESSION['user_mail'] = $mail;
                        echo "success-user";
                        exit();
                    }
                }
            }
        }
    }
}


?>