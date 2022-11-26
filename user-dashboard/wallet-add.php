<?php

if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT * FROM wallets WHERE user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }


?>

<!-- BEGIN PAGE CONTENT -->
<div id="page-content">
    <?php if(isset($_GET['error']) && $_GET['error'] == "emptyField") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            پر کردن فیلد های ستاره دار ضروریست !
        </div>
    <?php } ?>
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
    <?php if(isset($_GET['error']) && $_GET['error'] == "walletExist") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            این کیف پول قبلا ثبت شده است !
        </div>
    <?php } ?>
    <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
        <div class="portlet box border shadow">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h1 class="title">
                        <i class="icon-frane"></i>
                        افزودن کیف پول جدید
                    </h1>
                </div>
            </div>
            <div class="portlet-body">
                <form action="controllers/add-wallet.php" method="POST">
                    <div class="form-group row">
                        <div>
                            <input type="text" name="wallet" class="form-control text-center" placeholder="* آدرس کیف پول">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div>
                            <input type="text" name="network" class="form-control text-center" placeholder="* شبکه : مثلا BEP20">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="sb" class="btn btn-lg btn-success btn-round">
                            <i class="icon-check"></i>
                            ثبت و ارسال اطلاعات
                        </button>
                        <!-- <a href="?wallet=list"><button type="button" class="btn btn-lg btn-warning btn-round">
                            بازگشت
                            <i class="icon-close"></i>
                        </button></a> -->
                    </div>
                </form>
            </div>
        </div><!-- /.portlet -->
    </div>                
</div><!-- /#page-content -->
<?php } ?>