<?php

if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
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
    <?php if(isset($_GET['status']) && $_GET['status'] == "success") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-success").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-success fill center text-center mb-4 font-weight-bold" role="alert">
            اطلاعات با موفقیت ذخیره شد !
        </div>
    <?php } ?>
    <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
        <div class="portlet box border shadow">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h1 style="font-weight:bold;" class="title text-center">
                        <i class="icon-frane"></i>
                        تنظیمات هزینه ابطال
                    </h1>
                </div>
            </div>
            <div class="portlet-body">
                <form action="controllers/update-tax.php" method="POST">
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="1">هزینه ابطال <?php echo $inbox1_name; ?></label>
                        <div>
                            <input type="text" id="1" name="tax1" value="<?php echo $inbox1_tax; ?>" class="form-control text-center" placeholder="تتر">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="2">هزینه ابطال <?php echo $inbox2_name; ?></label>
                        <div>
                            <input type="text" id="2" name="tax2" value="<?php echo $inbox2_tax; ?>" class="form-control text-center" placeholder="تتر">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="3">هزینه ابطال <?php echo $inbox3_name; ?></label>
                        <div>
                            <input type="text" id="3" name="tax3" value="<?php echo $inbox3_tax; ?>" class="form-control text-center" placeholder="تتر">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="sb" class="btn btn-lg btn-success btn-round">
                            <i class="icon-check"></i>
                            ذخیره تنظیمات
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.portlet -->
    </div>                
</div><!-- /#page-content -->
<?php } ?>