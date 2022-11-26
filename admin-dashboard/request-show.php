<?php

if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $id = $_GET['id'];
    $sql = "SELECT * FROM requests WHERE id=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }
    if($row = mysqli_fetch_assoc($res)){
        $sql = "SELECT * FROM users WHERE mail=?";
        if(!mysqli_stmt_prepare($stmt , $sql)){
            echo "SQLNotPreapred";
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt , "s" , $row['user']);
            mysqli_stmt_execute($stmt);
            $res2 = mysqli_stmt_get_result($stmt);
            if($row2 = mysqli_fetch_assoc($res2)){
                $username = $row2['name'];
                $mail = $row2['mail'];
            }
        }
        if($row['type'] == "خرید (صدور)"){
            $text = "* مبلغ خرید (NAV روز درخواست) *";
            $text2 = "فیلد زیر را تنها درصورت نیاز تغییر دهید.";
        }
        else{
            $text = "* مبلغ فروش (NAV روز درخواست) *";
            $text2 = "فیلد زیر را <span style='color:red;'>تنها درصورت نیاز</span> تغییر دهید زیرا هزینه ابطال بصورت اتوماتیک از این مبلغ کسر میگردد.";
        }

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
            پر کردن فیلد های ستاره دار ضروریست !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "oneField") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            حداقل یک مورد عکس ارسال یا آدرس تایید ارسال پر گردد
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "numInvalid") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            تنها عدد قابل قبول است !
        </div>
    <?php } ?>
    <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
        <div class="portlet box border shadow">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h1 style="font-weight:bold;" class="title text-center">
                        <i class="icon-frane"></i>
                        رسیدگی به درخواست " <?php echo $row['type']; ?> " کاربر " <?php echo $username; ?> "
                    </h1>
                </div>
            </div>
            <div class="portlet-body">
                <form action="controllers/request.php" method="POST" enctype="multipart/form-data">
                    <h4 style="font-weight: bold;text-align:center;"><?php echo $text2; ?></h4>
                    <hr>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="1"><?php echo $text; ?></label>
                        <div>
                            <input type="text" id="1" value="<?php echo $row['nav']*$row['request_amount']; ?>" name="price" class="form-control text-center">
                        </div>
                    </div>
                    <?php if($row['type'] == "فروش (ابطال)"){ ?>
                    <div class="form-group text-center">
                        <label for="5" style="font-weight:bold;">آدرس تایید ارسال</label>
                        <div>
                            <input type="text" id="5" name="url" class="form-control text-center" placeholder="URL تتر اسکن یا مشابه آن">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;">آپلود تصویر ارسال</label>
                        <div class="input-group mb-4">
                            <input type="file" name="pic" class="form-control"> 
                            <div class="input-group"> 
                                <input type="text" class="form-control file-input text-center" style="border-radius:0;" placeholder="برای آپلود تصویر ارسال ، کلیک کنید"> 
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <hr>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="text-center">
                        <button type="submit" name="sb-confirm" class="btn btn-lg btn-success btn-round">
                            <i class="icon-check"></i>
                            تایید کردن درخواست
                        </button>
                        <button type="submit" name="sb-deny" class="btn btn-lg btn-danger btn-round">
                            <i class="icon-close"></i>
                            رد کردن درخواست
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.portlet -->
    </div>                
</div><!-- /#page-content -->
<?php } } ?>