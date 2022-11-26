<?php
if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} else { 
    $from = "user";
    $status = "unseen";
    $status2 = "درانتظار";
    $sql = "SELECT * FROM tickets t WHERE status=? AND from_status=? AND id=(SELECT Max(id) FROM tickets WHERE t.user = user)";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $status,$from);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_ticket = mysqli_stmt_num_rows($stmt);
        if($num_ticket > 0){
            $class_ticket = "badge-danger";
        }
        else{
            $class_ticket = "badge-success";
        }
    }
    $sql = "SELECT * FROM requests WHERE status=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $status2);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_request = mysqli_stmt_num_rows($stmt);
        if($num_request > 0){
            $class_request = "badge-danger";
        }
        else{
            $class_request = "badge-success";
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
    $sql = "SELECT * FROM setting_nav";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)){
        if($row['inbox'] == "inbox1"){
            $inbox1_nav = $row['amount'];
            $inbox1_nav = number_format($inbox1_nav);
        }
        elseif($row['inbox'] == "inbox2"){
            $inbox2_nav = $row['amount'];
            $inbox2_nav = number_format($inbox2_nav);
        }
        elseif($row['inbox'] == "inbox3"){
            $inbox3_nav = $row['amount'];
            $inbox3_nav = number_format($inbox3_nav);
        }
    }
    $sql = "SELECT * FROM setting_tax";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)){
        if($row['inbox'] == "inbox1"){
            $inbox1_tax = $row['tax'];
        }
        elseif($row['inbox'] == "inbox2"){
            $inbox2_tax = $row['tax'];
        }
        elseif($row['inbox'] == "inbox3"){
            $inbox3_tax = $row['tax'];
        }
    }
    $sql = "SELECT * FROM setting_wallet";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)){
        if($row['inbox'] == "inbox1"){
            $inbox1_add = $row['address'];
        }
        elseif($row['inbox'] == "inbox2"){
            $inbox2_add = $row['address'];
        }
        elseif($row['inbox'] == "inbox3"){
            $inbox3_add = $row['address'];
        }
    }
    ?>
    <style>
        h2{
            line-height: 2.2;
        }
    </style>
    <div id="page-content">
        <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6 ">
            <h1 style="font-weight:bold;">مدیریت عزیز ، به پنل مدیریتی خود خوش آمدید.</h1>
        </div>
        
        <div class="row justify-content-around" style="margin-top: 55px;">
            <div class="portlet box border text-center shadow m-b-20 col-md-4">
                <h2 style="font-weight:bold;">درخواست های در انتظار &nbsp; <span class="badge <?php echo $class_request; ?>"><?php echo $num_request; ?></span></h2>
            </div>
            <div class="portlet box border text-center shadow m-b-20 col-md-4">
                <h2 style="font-weight:bold;">تیکت های دیده نشده &nbsp; <span class="badge <?php echo $class_ticket; ?>"><?php echo $num_ticket; ?></span> </h2>
            </div>
        </div>

        <div class="row justify-content-around" style="margin-top: 20px;">
            <div class="portlet box border text-center shadow m-b-20 col-md-4">
                <h2 style="font-weight:bold;">nav <?php echo $inbox1_name ?> : <span class="badge badge-default">&nbsp;<?php echo $inbox1_nav ?> تتر&nbsp;</span></h2>
                <h2 style="font-weight:bold;">nav <?php echo $inbox2_name ?> : <span class="badge badge-default">&nbsp;<?php echo $inbox2_nav ?> تتر&nbsp;</span></h2>
                <h2 style="font-weight:bold;">nav <?php echo $inbox3_name ?> : <span class="badge badge-default">&nbsp;<?php echo $inbox3_nav ?> تتر&nbsp;</span></h2>
            </div>
            <div class="portlet box border text-center shadow m-b-20 col-md-4">
                <h2 style="font-weight:bold;">هزینه ابطال <?php echo $inbox1_name ?> : <span class="badge badge-default">&nbsp;<?php echo $inbox1_tax ?> تتر&nbsp;</span></h2>
                <h2 style="font-weight:bold;">هزینه ابطال <?php echo $inbox2_name ?> : <span class="badge badge-default">&nbsp;<?php echo $inbox2_tax ?> تتر&nbsp;</span></h2>
                <h2 style="font-weight:bold;">هزینه ابطال <?php echo $inbox3_name ?> : <span class="badge badge-default">&nbsp;<?php echo $inbox3_tax ?> تتر&nbsp;</span></h2>
            </div>
        </div>

        <div class="row justify-content-around" style="margin-top: 20px;">
            <div class="portlet box border text-center shadow m-b-20 col-md-8">
                <h2 style="font-weight:bold;">آدرس تتر <?php echo $inbox1_name ?> : <span class="label label-primary"><?php echo $inbox1_add ?></span></h2>
                <h2 style="font-weight:bold;">آدرس تتر <?php echo $inbox2_name ?> : <span class="label label-primary"><?php echo $inbox2_add ?></span></h2>
                <h2 style="font-weight:bold;">آدرس تتر <?php echo $inbox3_name ?> : <span class="label label-primary"><?php echo $inbox3_add ?></span></h2>
            </div>
        </div>
    </div>
<?php } ?>