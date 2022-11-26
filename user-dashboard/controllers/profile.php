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
    function myFilter($var){
        return ($var !== NULL && $var !== FALSE && $var !== '');
    }
    $other = $_POST['input'];
    $phone = trim($_POST['phone']);
    $watch = trim($_POST['watch']);
    $q10 = trim($_POST['q10']);
    $q11 = trim($_POST['q11']);
    $q12 = trim($_POST['q12']);
    $q13 = trim($_POST['q13']);
    $percentage = 0;
    $other[9] = $watch;
    $other[10] = $q10;
    $other[11] = $q11;
    $other[12] = $q12;
    $other[13] = $q13;
    if((!is_numeric($other[3]) && !empty($other[3])) || (!is_numeric($other[5]) && !empty($other[5])) || (!is_numeric($other[6]) && !empty($other[6])) ||
     (!is_numeric($other[7]) && !empty($other[7])) || (!is_numeric($other[8]) && !empty($other[8]))){
        header("Location: ../?profile&error=numInvalid");
        exit();
    }
    $percentage = array_filter($other , 'myFilter');
    $percentage = count($percentage);
    $percentage = ($percentage * 100) / 14;
    $percentage = floor($percentage);
    $other = serialize($other);
    $user = $_SESSION['user_mail'];
    if(empty($phone) || $phone == "-"){
        $phone = "-";
    }
    else{
        $sql = "SELECT * FROM users WHERE tel = ? AND NOT mail = ?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            header("Location: ../?profile&error=SQLNotPrepare");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $phone,$user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num = mysqli_stmt_num_rows($stmt);
            if($num > 0){
                header("Location: ../?profile&error=phoneExist");
                exit();
            }
        }
    }
    $sql = "UPDATE users SET tel=?,other=?,percentage=? WHERE mail=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?profile&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $phone , $other,$percentage , $user);
        mysqli_stmt_execute($stmt);
        header("Location: ../?profile&status=success");
        exit();
    }
}

?>