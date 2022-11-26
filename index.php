<?php session_start();
if(isset($_SESSION['start_time']) && (time() - $_SESSION['start_time'] > 21600)){
    session_destroy();
    session_start();
}
else {
    $_SESSION['start_time'] = time();
    session_regenerate_id(true);
}
if(isset($_SESSION['start_time'])){
    if(time() - $_SESSION['start_time'] > 180) {
        session_regenerate_id(true);
    }
}
if(isset($_SESSION['user_mail'])){
    header("Location: /user-dashboard");
    exit();
}
if(isset($_SESSION['manager_mail'])){
    header("Location: /admin-dashboard");
    exit();
}
    ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <title>ورود / ثبت نام | EMX</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/images/favicon.png">

        <!-- BEGIN CSS -->
        <link href="assets/plugins/bootstrap/bootstrap5/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link href="assets/plugins/simple-line-icons/css/simple-line-icons.min.css" rel="stylesheet">
        <link href="assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="assets/plugins/paper-ripple/dist/paper-ripple.min.css" rel="stylesheet">
        <link href="assets/plugins/iCheck/skins/square/_all.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/colors.css" rel="stylesheet">
        <!-- END CSS -->
        <!-- BEGIN PAGE CSS -->
        <link href="assets/plugins/ladda/dist/ladda-themeless.min.css" rel="stylesheet">
        <!-- END PAGE CSS -->
        <style>
            ::placeholder{
                opacity: .5 !important;
            }
        </style>
        
    </head>
    <body class="fix-header active-ripple theme-blue">
        <!-- BEGIN LOEADING -->
        <div id="loader">
            <div class="spinner"></div>
        </div><!-- /loader -->
        <!-- END LOEADING -->
        
        <!-- BEGIN WRAPPER -->
        <div class="fixed-modal-bg"></div>
        <a href="#" class="btn btn-info btn-icon btn-round btn-lg" id="toggle-dark-mode">
            <i class="icon-bulb"></i>
        </a>
        <div class="modal-page shadow">
            <div class="container-fluid">                
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="logo-con m-t-10 m-b-10">
                            <img src="assets/images/logo-dark.png" class="dark-logo center-block img-responsive" alt="logo">
                            <img src="assets/images/logo.png" class="light-logo center-block img-responsive" alt="logo">
                        </div>
                        <hr>
                        <h2 class="text-center m-b-20 n-def">برای ورود یا ثبت نام ایمیل خود را وارد نمایید</h2>
                        <h2 class="text-center m-b-20 n-login" style="display:none;">کد تایید ارسال شده به ایمیل خود را وارد نمایید</h2>
                        <h4 class="text-center m-b-20 n-spam" style="display:none;">(پوشه اسپم ایمیل خود را بررسی کنید)</h4>
                        <div class="alert alert-danger fill text-center err1" style="display:none;" >
                            پر کردن فیلد های ستاره دار ضروریست.
                        </div>
                        <div class="alert alert-danger fill text-center err2" style="display:none;" >
                            کد تایید قبلا به ایمیل شما ارسال شده ، لطفا ایمیل خود را چک کنید.
                        </div>
                        <div class="alert alert-danger fill text-center err3" style="display:none;" >
                            فرمت ایمیل وارد شده نادرست میباشد.
                        </div>
                        <div class="alert alert-danger fill text-center err4" style="display:none;" >
                            مشکل در اتصال به دیتابیس ، با برنامه نویس تماس بگیرید.
                        </div>
                        <div class="alert alert-danger fill text-center err5" style="display:none;" >
                            کد وارد شده اشتباه است.
                        </div>
                        <div class="alert alert-danger fill text-center err-u" style="display:none;" >
                            اروری نامشخص بوجود آمده ، با برنامه نویس تماس بگیرید.
                        </div>
                        
                        <div class="form-group mail-sec">
                            <hr class="m-b-10">
                            <div class="input-group round">
                                <span class="input-group-addon">
                                    <i class="icon-envelope"></i>
                                </span>
                                <input class="form-control ltr text-left mail" name="mail" placeholder="example@example.com" autocomplete="on">
                            </div>
                        </div>

                        <div class="form-group name-sec" style="display:none;">
                            <hr>
                            <div class="input-group round">
                                <span class="input-group-addon">
                                    <i class="icon-user"></i>
                                </span>
                                <input class="form-control text-left name" placeholder="* نام و نام خانوادگی">
                            </div>
                        </div>
                        <div class="form-group tel-sec" style="display:none;">
                            <div class="input-group round">
                                <span class="input-group-addon">
                                    <i class="icon-phone"></i>
                                </span>
                                <input class="form-control text-left tel" placeholder="شماره موبایل - اختیاری">
                            </div>
                        </div>
                        <div class="token-sec" style="display:none;">
                            <hr>
                            <input class="form-control text-center token" placeholder="** کد ارسال شده **">
                        </div>
                        
                        <button class="btn btn-info btn-round btn-block ladda-button ld1 m-t-20" data-style="slide-right" >
                            <span class="ladda-label">ورود | ثبت نام</span>
                            <span class="ladda-spinner"></span>
                        </button>
                        <button class="btn btn-success btn-round btn-block ladda-button ld2 m-t-20" style="display:none;" data-style="slide-right" >
                            <span class="ladda-label">تایید</span>
                            <span class="ladda-spinner"></span>
                        </button>
                        

                    </div><!-- /.col-md-12 -->                    
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div><!-- /.modal-page -->
        <!-- END WRAPPER -->
        
        <!-- BEGIN JS -->
        <script src="assets/plugins/jquery/dist/jquery-3.1.0.js"></script>
        <script src="assets/plugins/jquery-migrate/jquery-migrate-1.2.1.min.js"></script>
        <script src="assets/plugins/bootstrap/bootstrap5/js/bootstrap.bundle.min.js"></script>
        <script src="assets/plugins/paper-ripple/dist/PaperRipple.min.js"></script>
        <script src="assets/plugins/sweetalert2//dist/sweetalert2.min.js"></script>
        <script src="assets/plugins/iCheck/icheck.min.js"></script>
        <script src="assets/plugins/iCheck/icheck.min.js"></script>
        <script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="assets/plugins/jquery-validation/src/localization/messages_fa.js"></script>
        <script src="assets/js/core.js"></script>
        

        <!-- BEGIN PAGE JAVASCRIPT -->
        <script src="assets/plugins/ladda/dist/spin.min.js"></script>
        <script src="assets/plugins/ladda/dist/ladda.min.js"></script>
        <script>
            Ladda.bind('.ld1');
            Ladda.bind('.ld2');
            document.querySelector(".ld1").addEventListener("click",function(){
                let mail = document.querySelector(".mail").value;
                $.ajax({
                    url: "login-controllers/login.php",
                    data: {
                        step: "one",
                        mail: mail
                    },
                    type: "post",
                    success: function(res1){
                        if(res1 == "success-login"){
                            document.querySelector(".mail-sec").style.display = "none";
                            document.querySelector(".ld1").style.display = "none";
                            document.querySelector(".n-def").style.display = "none";
                            document.querySelector(".token-sec").style.display = "block";
                            document.querySelector(".ld2").style.display = "block";
                            document.querySelector(".n-login").style.display = "block";
                            document.querySelector(".n-spam").style.display = "block";
                            document.querySelector(".ld2").addEventListener("click",function(){
                                $.ajax({
                                    url: "login-controllers/login.php",
                                    data: {
                                        step: "two",
                                        mail: mail ,
                                        token: document.querySelector(".token").value
                                    },
                                    type: "post",
                                    success: function(res2){
                                        if(res2 == "success-admin"){
                                            window.location.href = "/admin-dashboard";
                                            Ladda.stopAll();
                                        }
                                        else if(res2 == "success-user"){
                                            window.location.href = "/user-dashboard";
                                            Ladda.stopAll();
                                        }
                                        else if(res2 == "emptyField"){
                                            document.querySelector(".err1").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err1").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else if (res2 == "wrongFormat"){
                                            document.querySelector(".err3").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err3").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else if (res2 == "SQLNotPrepare"){
                                            document.querySelector(".err4").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err4").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else if (res2 == "wrongToken"){
                                            document.querySelector(".err5").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err5").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else{
                                            document.querySelector(".err-u").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err-u").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                    }
                                });
                            });
                        }
                        else if(res1 == "success-register"){
                            document.querySelector(".mail-sec").style.display = "none";
                            document.querySelector(".ld1").style.display = "none";
                            document.querySelector(".n-def").style.display = "none";
                            document.querySelector(".name-sec").style.display = "block";
                            document.querySelector(".tel-sec").style.display = "block";
                            document.querySelector(".token-sec").style.display = "block";
                            document.querySelector(".ld2").style.display = "block";
                            document.querySelector(".n-login").style.display = "block";
                            document.querySelector(".n-spam").style.display = "block";
                            document.querySelector(".ld2").addEventListener("click",function(){
                                $.ajax({
                                    url: "login-controllers/login.php",
                                    data: {
                                        step: "two",
                                        mail: mail ,
                                        name: document.querySelector(".name").value,
                                        tel: document.querySelector(".tel").value,
                                        token: document.querySelector(".token").value
                                    },
                                    type: "post",
                                    success: function(res2){
                                        if(res2 == "success-user"){
                                            window.location.href = "/user-dashboard";
                                            Ladda.stopAll();
                                        }
                                        else if(res2 == "emptyField"){
                                            document.querySelector(".err1").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err1").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else if (res2 == "wrongFormat"){
                                            document.querySelector(".err3").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err3").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else if (res2 == "SQLNotPrepare"){
                                            document.querySelector(".err4").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err4").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else if (res2 == "wrongToken"){
                                            document.querySelector(".err5").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err5").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                        else{
                                            document.querySelector(".err-u").style.display = "block";
                                            setTimeout(() => {
                                                document.querySelector(".err-u").style.display = "none";
                                            }, 4000);
                                            Ladda.stopAll();
                                        }
                                    }
                                });
                            });
                        }
                        else if(res1 == "emptyField"){
                            document.querySelector(".err1").style.display = "block";
                            setTimeout(() => {
                                document.querySelector(".err1").style.display = "none";
                            }, 4000);
                            Ladda.stopAll();
                        }
                        else if(res1 == "mailAlreadySent"){
                            document.querySelector(".err2").style.display = "block";
                            setTimeout(() => {
                                document.querySelector(".err2").style.display = "none";
                            }, 4000);
                            Ladda.stopAll();
                        }
                        else if (res1 == "wrongFormat"){
                            document.querySelector(".err3").style.display = "block";
                            setTimeout(() => {
                                document.querySelector(".err3").style.display = "none";
                            }, 4000);
                            Ladda.stopAll();
                        }
                        else if (res1 == "SQLNotPrepare"){
                            document.querySelector(".err4").style.display = "block";
                            setTimeout(() => {
                                document.querySelector(".err4").style.display = "none";
                            }, 4000);
                            Ladda.stopAll();
                        }
                        else{
                            document.querySelector(".err-u").style.display = "block";
                            setTimeout(() => {
                                document.querySelector(".err-u").style.display = "none";
                            }, 4000);
                            Ladda.stopAll();
                        }
                    }
                });
            });

        </script>

        <!-- END PAGE JAVASCRIPT --> 
    </body>
</html>