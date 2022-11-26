<?php

if(!isset($_SESSION['manager_mail']) || $_SESSION['priv'] != "super-admin"){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{

?>

<!-- BEGIN PAGE CONTENT -->
<div id="page-content">
    <?php if(isset($_GET['error']) && $_GET['error'] == "SQLNotPrepare") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            مشکل در دیتابیس ! با برنامه نویس تماس بگیرید
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "emptyField") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            پر کردن همه فیلد ها ضروریست !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "mailExist") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            یک کاربر با این ایمیل وجود دارد !
        </div>
    <?php } ?>
    <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
        <div class="portlet box border shadow">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h1 style="font-weight:bold;" class="title text-center">
                        <i class="icon-frane"></i>
                        افزودن مدیر جدید
                    </h1>
                </div>
            </div>
            <div class="portlet-body">
                <form action="controllers/add-admin.php" method="POST">
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="1">نام و نام خانوادگی *</label>
                        <div>
                            <input type="text" id="1" name="name" class="form-control text-center">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="2">ایمیل *</label>
                        <div>
                            <input type="text" id="2" name="mail" class="form-control text-center">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="sb" class="btn btn-lg btn-success btn-round">
                            <i class="icon-check"></i>
                            ثبت و افزودن مدیر
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.portlet -->
    </div>                
</div><!-- /#page-content -->
<?php } ?>