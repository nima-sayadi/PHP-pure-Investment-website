<?php session_start();
if(!isset($_SESSION['manager_mail'])){
    header("Location: ../../?page=login&error=sessionEnded");
    exit();
}
elseif(!isset($_POST['unix'])){
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
}
else{
    require "../../DB/db.php";
    $stmt = mysqli_stmt_init($conn);
    $unix = trim($_POST['unix']);
    $unix = $unix / 1000;
    $inbox = trim($_POST['inbox']);
    $price = trim($_POST['price']);
    if(empty($unix) || empty($inbox) || empty($price) || !is_numeric($price)){
        echo "error";
        exit();
    }

    $now = time() + 16200;
    if($now < ($unix + 86399) && $now > $unix){
        $sql = "UPDATE setting_nav SET amount=? WHERE inbox=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPrepare";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $price,$inbox);
            mysqli_stmt_execute($stmt);    
        }
    }

    $sql = "SELECT * FROM nav_records WHERE date=? AND inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPrepare";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $unix,$inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $sql = "UPDATE nav_records SET amount=? WHERE inbox=? AND date=?";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                echo "SQLNotPrepare";
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "sss" , $price,$inbox,$unix);
                mysqli_stmt_execute($stmt);
                echo "success";
                exit();     
            }
        }
        else{
            $sql = "INSERT INTO nav_records(amount,inbox,date) VALUES(?,?,?)";
            if(!mysqli_stmt_prepare($stmt , $sql)){
                echo "SQLNotPrepare";
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt , "sss" , $price,$inbox,$unix);
                mysqli_stmt_execute($stmt);
                echo "success";
                exit(); 
            }
        }
    }   
}

?>