<?php
if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} elseif(isset($_GET['mail'])) {
    $sql = "SELECT * FROM users WHERE mail=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_GET['mail']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_user = mysqli_stmt_num_rows($stmt);
    }
    if($num_user > 0){
        $sql = "SELECT * FROM users WHERE mail=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPreapred";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "s" , $_GET['mail']);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($res)){
                $username = $row['name'];
                $mail = $row['mail'];
                $tel = $row['tel'];
                $other = unserialize($row['other']);
            }
        }
        $sql = "SELECT * FROM setting_inbox";
        $res = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($res)){
            if($row['inbox'] == "inbox1"){
                $inbox1_name = $row['name'];
            }
            elseif($row['inbox'] == "inbox2"){
                $inbox2_name = $row['name'];
            }
            elseif($row['inbox'] == "inbox3"){
                $inbox3_name = $row['name'];
            }
        }

        $inbox = "inbox1";

        $sql = "SELECT * FROM requests WHERE user=? AND inbox = ?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPreapred";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $_GET['mail'] , $inbox);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num1 = mysqli_stmt_num_rows($stmt);
        }

        $inbox = "inbox2";

        $sql = "SELECT * FROM requests WHERE user=? AND inbox = ?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPreapred";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $_GET['mail'] , $inbox);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num2 = mysqli_stmt_num_rows($stmt);
        }

        $inbox = "inbox3";

        $sql = "SELECT * FROM requests WHERE user=? AND inbox = ?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPreapred";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $_GET['mail'] , $inbox);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $num3 = mysqli_stmt_num_rows($stmt);
        }

        $ss = "تایید شده";
        $i = 1;
        $sql = "SELECT * FROM wallets WHERE user=? AND status=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPreapred";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $_GET['mail'] , $ss);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $numw = mysqli_stmt_num_rows($stmt);
        }
        $sql = "SELECT * FROM wallets WHERE user=? AND status=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPreapred";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "ss" , $_GET['mail'] , $ss);
            mysqli_stmt_execute($stmt);
            $resw = mysqli_stmt_get_result($stmt);
        }

    ?>
    <style>
        h2{
            line-height: 2;
        }
    </style>
    <div id="page-content">
        <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6 ">
            <h1 style="font-weight:bold;">جزئیات کامل کاربر " <?php echo $username ?> "</h1>
        </div>

        <div class="row justify-content-around" style="margin-top: 60px;">
            <div class="portlet box border text-justify shadow m-b-20 col-md-4">
                <h2>کشور محل زندگی : <span style="font-weight: bold;"><?php echo $other[0]; ?></span></h2>
                <h2>شهر محل زندگی : <span style="font-weight: bold;"><?php echo $other[1]; ?></span></h2>
                <h2>شغل : <span style="font-weight: bold;"><?php echo $other[2]; ?></span></h2>
                <h2>درآمد ماهیانه : <span style="font-weight: bold;"><?php if(is_numeric($other[3])){echo number_format($other[3])." تومان";}else{echo "";} ?></span></h2>
                <h2>افراد تحت تکفل : <span style="font-weight: bold;"><?php echo $other[4]; ?></span></h2>
                <h2>ارزش کل دارایی : <span style="font-weight: bold;"><?php if(is_numeric($other[5])){echo number_format($other[5])." تومان";}else{echo "";} ?></span></span></h2>
                <h2>ارزش محل سکونت : <span style="font-weight: bold;"><?php if(is_numeric($other[6])){echo number_format($other[6])." تومان";}else{echo "";} ?></span></span></h2>
            </div>
            <div class="portlet box border text-justify shadow m-b-20 col-md-4">
                <h2>ارزش اتومبیل : <span style="font-weight: bold;"><?php if(is_numeric($other[7])){echo number_format($other[7])." تومان";}else{echo "";} ?></span></span></h2>
                <h2>درآمد ماهیانه مورد علاقه : <span style="font-weight: bold;"><?php if(is_numeric($other[8])){echo number_format($other[8])." تومان";}else{echo "";} ?></span></span></h2>
                <h2>برند ساعت ترجیحی : <span style="font-weight: bold;"><?php echo $other[9]; ?></span></h2>
                <h2>تفریح دست جمعی : <span style="font-weight: bold;"><?php echo $other[10]; ?></span></h2>
                <h2>درباره بیمه عمر : <span style="font-weight: bold;"><?php echo $other[11]; ?></span></h2>
                <h2>مقصد سفر بعدی : <span style="font-weight: bold;"><?php echo $other[12]; ?></span></h2>
                <h2>آب آشامیدنی ترجیحی : <span style="font-weight: bold;"><?php echo $other[13]; ?></span></h2>
            </div>
        </div>

        <hr>
        <div class="row justify-content-around" style="margin-top: 20px;">
            <div class="portlet box border text-center shadow m-b-20 col-md-4">
                <h2>کاردکس <?php echo $inbox1_name ?> : <?php if($num1 > 0){echo "<a href='?user=show&mail=$mail&cardex=inbox1'><button class='btn btn-md round btn-success'>مشاهده</button></a>";}else{echo "<span style='font-weight:bold;'>ندارد</span>";} ?></h2>
            </div>
            <div class="portlet box border text-center shadow m-b-20 col-md-4">
                <h2>کاردکس <?php echo $inbox2_name ?> : <?php if($num2 > 0){echo "<a href='?user=show&mail=$mail&cardex=inbox2'><button class='btn btn-md round btn-success'>مشاهده</button></a>";}else{echo "<span style='font-weight:bold;'>ندارد</span>";} ?></h2>
            </div>

            <div class="portlet box border text-center shadow m-b-20 col-md-4">
                <h2>کاردکس <?php echo $inbox3_name ?> : <?php if($num3 > 0){echo "<a href='?user=show&mail=$mail&cardex=inbox3'><button class='btn btn-md round btn-success'>مشاهده</button></a>";}else{echo "<span style='font-weight:bold;'>ندارد</span>";} ?></h2>
            </div>
        </div>

        <?php if($numw > 0){ ?>
            <div class="row justify-content-around" style="margin-top: 20px;">
                <div class="portlet box border text-center shadow m-b-20 col-md-8">
                    <?php while($roww = mysqli_fetch_assoc($resw)){ ?>
                        <h2 style="font-weight:bold;">آدرس والت <?php echo $i; ?> : <span class="label label-primary"><?php echo $roww['address']; ?></span></h2>
                    <?php $i++; } ?>
                </div>
            </div>
        <?php } ?>


    </div>
<?php } } ?>
