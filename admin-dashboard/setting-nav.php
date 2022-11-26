<?php
if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} else {
    $default_date = date("Y-m-d");
    $green = "text-success";
    $red = "text-danger";
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
    // Calculate percentages //
    $inbox = "inbox1";
    $sql = "SELECT * FROM setting_nav WHERE inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $nav1 = $row['amount'];
        }
    }
    $inbox = "inbox2";
    $sql = "SELECT * FROM setting_nav WHERE inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $nav2 = $row['amount'];
        }
    }
    $inbox = "inbox3";
    $sql = "SELECT * FROM setting_nav WHERE inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $nav3 = $row['amount'];
        }
    }
    $today = strtotime("today", time()) + 7200;
    $yesterday = $today - 86400;
    $lastweek = $today - 604800;
    $lastmonth = $today - 2591998;
    $threemonth = $today - 7775994;
    $sixmonth = $today - 15551988;
    $lastyear = $today - 31535975;
    $yesterday_amount1 = "-";
    $yesterday_amount2 = "-";
    $yesterday_amount3 = "-";
    $yesterdayless = $yesterday-30;
    $yesterdaymore = $yesterday+30;
    $inbox = "inbox1";
    $sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sss" ,$yesterdayless,$yesterdaymore, $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $yesterday_nav1 = (100 * $nav1) / $row['amount'];
            $yesterday_nav1 = $yesterday_nav1 - 100;
            $yesterday_amount1 = number_format($row['amount']);
        }
        else{
            $yesterday_nav1 = "-";
        }
        if($yesterday_nav1 != "-"){
            $yesterday_nav1 = number_format((float)$yesterday_nav1,2,".","");
        }
    }
    $inbox = "inbox2";
    $sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sss" , $yesterdayless,$yesterdaymore, $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $yesterday_nav2 = (100 * $nav2) / $row['amount'];
            $yesterday_nav2 = $yesterday_nav2 - 100;
            $yesterday_amount2 = number_format($row['amount']);
        }
        else{
            $yesterday_nav2 = "-";
        }
        if($yesterday_nav2 != "-"){
            $yesterday_nav2 = number_format((float)$yesterday_nav2,2,".","");
        }
    }
    $inbox = "inbox3";
    $sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "sss" , $yesterdayless,$yesterdaymore, $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $yesterday_nav3 = (100 * $nav3) / $row['amount'];
            $yesterday_nav3 = $yesterday_nav3 - 100;
            $yesterday_amount3 = number_format($row['amount']);
        }
        else{
            $yesterday_nav3 = "-";
        }
        if($yesterday_nav3 != "-"){
            $yesterday_nav3 = number_format((float)$yesterday_nav3,2,".","");
        }
    }
    // End of Calculate percentages //    
    ?>
    <style>
        h2{
            line-height: 2;
        }
    </style>
    <div id="page-content">
        <div style="display: none;" class="alert alert-danger fill center text-center mb-4 font-weight-bold err1" role="alert">
            مشکل در دیتابیس با برنامه نویس تماس بگیرید !
        </div>
        <div style="display: none;" class="alert alert-danger fill center text-center mb-4 font-weight-bold err2" role="alert">
            ارور نامشخص با برنامه نویس تماس بگیرید !
        </div>
        <div style="display: none;" class="alert alert-success fill center text-center mb-4 font-weight-bold success1" role="alert">
            قیمت با موفقیت بروز رسانی شد !
        </div>
        <div style="display: none;" class="alert alert-success fill center text-center mb-4 font-weight-bold success2" role="alert">
            قیمت با موفقیت بروز رسانی شد !
        </div>
        <div style="display: none;" class="alert alert-success fill center text-center mb-4 font-weight-bold success3" role="alert">
            قیمت با موفقیت بروز رسانی شد !
        </div>
        <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6 ">
            <div class="form-group">
                <h2 style="color:black;">تاریخ مورد نظر را انتخاب کنید</h2>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="icon-calendar"></i>
                    </span>
                    <input style="font-weight: bold;text-align:center" type="text" class="has-persian-datepicker-unix form-control" value="<?php echo $default_date; ?>">
                </div>
            </div>
        </div>
        <input id="alt-field" type="hidden" name="unix">

        <div class="row justify-content-around" style="margin-top: 60px;">
            <div class="portlet box border text-center shadow m-b-20 col-md-3">
                <h2 style="color:black;">قیمت NAV <?php echo $inbox1_name; ?></h2>
                <hr>
                <div class="input-group curve">
                    <input type="text" class="form-control inbox1"> 
                    <span class="input-group-btn sb1">
                        <button class="btn btn-success" type="button">ثبت قیمت</button>
                    </span>
                </div>
                <hr>
                <h3>بازده از دیروز : 
                    <span dir="ltr" class="<?php if($yesterday_nav1>0){echo $green;}elseif($yesterday_nav1<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($yesterday_nav1>0){echo "+";} ?><?php echo $yesterday_nav1; ?>%</span>
                    <hr>
                    <span>قیمت دیروز : <b><?php echo $yesterday_amount1; ?> تتر</b></span>
                </h3>
            </div>
            <div class="portlet box border text-center shadow m-b-20 col-md-3">
                <h2 style="color:black;">قیمت NAV <?php echo $inbox2_name; ?></h2>
                <hr>
                <div class="input-group curve">
                    <input type="text" class="form-control inbox2"> 
                    <span class="input-group-btn sb2">
                        <button class="btn btn-success" type="button">ثبت قیمت</button>
                    </span>
                </div>
                <hr>
                <h3>بازده از دیروز : 
                    <span dir="ltr" class="<?php if($yesterday_nav2>0){echo $green;}elseif($yesterday_nav2<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($yesterday_nav2>0){echo "+";} ?><?php echo $yesterday_nav2; ?>%</span>
                    <hr>
                    <span>قیمت دیروز : <b><?php echo $yesterday_amount2; ?> تتر</b></span>
                </h3>
            </div>
            <div class="portlet box border text-center shadow m-b-20 col-md-3">
                <h2 style="color:black;">قیمت NAV <?php echo $inbox3_name; ?></h2>
                <hr>
                <div class="input-group curve">
                    <input type="text" class="form-control inbox3"> 
                    <span class="input-group-btn sb3">
                        <button class="btn btn-success" type="button">ثبت قیمت</button>
                    </span>
                </div>
                <hr>
                <h3>بازده از دیروز : 
                    <span dir="ltr" class="<?php if($yesterday_nav3>0){echo $green;}elseif($yesterday_nav3<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($yesterday_nav3>0){echo "+";} ?><?php echo $yesterday_nav3; ?>%</span>
                    <hr>
                    <span>قیمت دیروز : <b><?php echo $yesterday_amount3; ?> تتر</b></span>
                </h3>
            </div>
        </div>

    </div>
    <script src="../assets/plugins/persian-date/persian-date.min.js"></script>
    <script src="../assets/plugins/persian-datepicker/js/persian-datepicker.min.js"></script>
    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function numberWithoutCommas(x) {
            return x.toString().replace(/,/g, "");
        }
        
        let unix;
        let inbox1 = document.querySelector(".inbox1");
        let inbox2 = document.querySelector(".inbox2");
        let inbox3 = document.querySelector(".inbox3");
        let sb1 = document.querySelector(".sb1");
        let sb2 = document.querySelector(".sb2");
        let sb3 = document.querySelector(".sb3");
        let err1 = document.querySelector(".err1");
        let err2 = document.querySelector(".err2");
        let success1 = document.querySelector(".success1");
        let success2 = document.querySelector(".success2");
        let success3 = document.querySelector(".success3");

        // For thousend Sep //
        inbox1.value = numberWithCommas(inbox1.value);
        inbox2.value = numberWithCommas(inbox2.value);
        inbox3.value = numberWithCommas(inbox3.value);
        inbox1.addEventListener("keyup",function(){
            inbox1.value = numberWithoutCommas(inbox1.value);
            inbox1.value = numberWithCommas(inbox1.value);
        });
        inbox2.addEventListener("keyup",function(){
            inbox2.value = numberWithoutCommas(inbox2.value);
            inbox2.value = numberWithCommas(inbox2.value);
        });
        inbox3.addEventListener("keyup",function(){
            inbox3.value = numberWithoutCommas(inbox3.value);
            inbox3.value = numberWithCommas(inbox3.value);
        });
        // End of thousend Sep //

        $(".has-persian-datepicker-unix").pDatepicker({
            format: "DD MMMM YYYY",
            autoClose: true,
            maxDate: "<?php echo $default_date; ?>",
            altField: '#alt-field',
            onSelect:function(){
                unix = document.querySelector("#alt-field").value;
                $.ajax({
                    url: "controllers/get-nav.php",
                    type: "POST",
                    data:{
                        unix:unix
                    },
                    success:function(res){
                        results = JSON.parse(res);
                        if(results.length === 0){

                        }
                        else{
                            inbox1.value = numberWithCommas(results[0]);
                            inbox2.value = numberWithCommas(results[1]);
                            inbox3.value = numberWithCommas(results[2]);
                        }
                    }
                });
            }
        });
        unix = document.querySelector("#alt-field").value;
        $.ajax({
            url: "controllers/get-nav.php",
            type: "POST",
            data:{
                unix:unix
            },
            success:function(res){
                results = JSON.parse(res);
                if(results.length === 0){

                }
                else{
                    inbox1.value = numberWithCommas(results[0]);
                    inbox2.value = numberWithCommas(results[1]);
                    inbox3.value = numberWithCommas(results[2]);
                }
            }
        });
        // Update Prices //
        sb1.addEventListener("click",function(){
            $.ajax({
                url: "controllers/update-nav.php",
                type: "POST",
                data:{
                    unix :unix,
                    inbox: "inbox1",
                    price: numberWithoutCommas(inbox1.value)
                },
                success:function(res){
                    if(res == "success"){
                        success1.style.display = "block";
                        setTimeout(() => {
                            success1.style.display = "none";
                        }, 3000);
                    }
                    else if(res == "SQLNotPrepare"){
                        err1.style.display = "block";
                        setTimeout(() => {
                            err1.style.display = "none";
                        }, 3000);
                    }
                    else{
                        err2.style.display = "block";
                        setTimeout(() => {
                            err2.style.display = "none";
                        }, 3000);
                    }
                }
            });
        });
        sb2.addEventListener("click",function(){
            $.ajax({
                url: "controllers/update-nav.php",
                type: "POST",
                data:{
                    unix :unix,
                    inbox: "inbox2",
                    price: numberWithoutCommas(inbox2.value)
                },
                success:function(res){
                    if(res == "success"){
                        success2.style.display = "block";
                        setTimeout(() => {
                            success2.style.display = "none";
                        }, 3000);
                    }
                    else if(res == "SQLNotPrepare"){
                        err1.style.display = "block";
                        setTimeout(() => {
                            err1.style.display = "none";
                        }, 3000);
                    }
                    else{
                        err2.style.display = "block";
                        setTimeout(() => {
                            err2.style.display = "none";
                        }, 3000);
                    }
                }
            });
        });
        sb3.addEventListener("click",function(){
            $.ajax({
                url: "controllers/update-nav.php",
                type: "POST",
                data:{
                    unix :unix,
                    inbox: "inbox3",
                    price: numberWithoutCommas(inbox3.value)
                },
                success:function(res){
                    if(res == "success"){
                        success3.style.display = "block";
                        setTimeout(() => {
                            success3.style.display = "none";
                        }, 3000);
                    }
                    else if(res == "SQLNotPrepare"){
                        err1.style.display = "block";
                        setTimeout(() => {
                            err1.style.display = "none";
                        }, 3000);
                    }
                    else{
                        err2.style.display = "block";
                        setTimeout(() => {
                            err2.style.display = "none";
                        }, 3000);
                    }
                }
            });
        });
        // End Of Update Prices //

    </script>
<?php } ?>
