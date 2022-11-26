<?php

if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT * FROM users WHERE mail=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $phone = $row['tel'];
            $other = $row['other'];
        }
        if($other != ""){
            $other = unserialize($other);
        }
        else{
            $other = [];
            $other[0] = "";
            $other[1] = "";
            $other[2] = "";
            $other[3] = "";
            $other[4] = "";
            $other[5] = "";
            $other[6] = "";
            $other[7] = "";
            $other[8] = "";
            $other[9] = "";
            $other[10] = "";
            $other[11] = "";
            $other[12] = "";
            $other[13] = "";
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
            پر کردن فیلد های ستاره دار ضروریست !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "phoneExist") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            این شماره موبایل قبلا ثبت شده است !
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
                        ویرایش پروفایل کاربری
                    </h1>
                </div>
            </div>
            <div class="portlet-body">
                <form action="controllers/profile.php" method="POST">
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="1">کشور محل زندگی شما کجاست؟</label>
                        <div>
                            <input type="text" id="1" value="<?php echo $other[0]; ?>" name="input[]" class="form-control text-center" placeholder="کشور">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="2">شهر محل زندگی شما کجاست؟</label>
                        <div>
                            <input type="text" id="2" name="input[]" value="<?php echo $other[1]; ?>" class="form-control text-center" placeholder="شهر">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="3">مشغول به چکاری هستید؟</label>
                        <div>
                            <input type="text" id="3" name="input[]" value="<?php echo $other[2]; ?>" class="form-control text-center" placeholder="شغل">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="4">درآمد ماهیانه شما چقدر است؟</label>
                        <div>
                            <input type="text" id="4" name="input[]" value="<?php echo $other[3]; ?>" class="form-control text-center" placeholder="( به تومان )">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="5">تعداد افراد تحت تکفل؟</label>
                        <div>
                            <input type="text" id="5" name="input[]" value="<?php echo $other[4]; ?>" class="form-control text-center" placeholder="تعداد">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="6">ارزش کل دارایی شما چقدر است؟</label>
                        <div>
                            <input type="text" id="6" name="input[]" value="<?php echo $other[5]; ?>" class="form-control text-center" placeholder="( به تومان )">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="7">ارزش محل سکونت شما چقدر است؟</label>
                        <div>
                            <input type="text" id="7" name="input[]" value="<?php echo $other[6]; ?>" class="form-control text-center" placeholder="( به تومان )">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="8">ارزش اتومبیل های شما چقدر است؟</label>
                        <div>
                            <input type="text" id="8" name="input[]" value="<?php echo $other[7]; ?>" class="form-control text-center" placeholder="( به تومان )">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label style="font-weight:bold;" for="9">میزان درآمد ماهیانه مورد علاقه شما چقدر است؟</label>
                        <div>
                            <input type="text" id="9" name="input[]" value="<?php echo $other[8]; ?>" class="form-control text-center" placeholder="( به تومان )">
                        </div>
                    </div>
                    <h1 class="text-center mb-3 mt-4" style="font-weight:bold;">کدام برند ساعت را ترجیح میدهید بخرید؟</h1>
                    <div class="input-group text-center justify-content-evenly">
                        <label class="cursor-pointer">                            
                            <input name="watch" value="پتک فیلیپ" type="radio" <?php if($other[9] == "پتک فیلیپ"){echo "checked";} ?>>
                            پتک فیلیپ
                        </label>
                        <label class="cursor-pointer">                            
                            <input name="watch" value="رولکس" type="radio" <?php if($other[9] == "رولکس"){echo "checked";} ?>>
                            رولکس
                        </label>
                        <label class="cursor-pointer">                            
                            <input name="watch" value="تیسوت" type="radio" <?php if($other[9] == "تیسوت"){echo "checked";} ?>>
                            تیسوت
                        </label>
                        <label class="cursor-pointer">                            
                            <input name="watch" value="یه برند ناشناخته ارزان ولی قشنگ" type="radio" <?php if($other[9] == "یه برند ناشناخته ارزان ولی قشنگ"){echo "checked";} ?>>
                            یه برند ناشناخته ارزان ولی قشنگ
                        </label>
                    </div>

                    <h1 class="text-center mb-3 mt-4" style="font-weight:bold;">برای یک تفریح دست جمعی کدام را ترجیح میدهید؟</h1>
                    <div class="input-group text-center flex-column">
                        <label class="cursor-pointer">                            
                            <input name="q10" value="قرار با دوستانتان در یک رستوران گران" type="radio" <?php if($other[10] == "قرار با دوستانتان در یک رستوران گران"){echo "checked";} ?>>
                            قرار با دوستانتان در یک رستوران گران
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q10" value="یک رستوران یا فست فود ارزان" type="radio" <?php if($other[10] == "یک رستوران یا فست فود ارزان"){echo "checked";} ?>>
                            یک رستوران یا فست فود ارزان
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q10" value="پارک یا محل تفریح عمومی" type="radio" <?php if($other[10] == "پارک یا محل تفریح عمومی"){echo "checked";} ?>>
                            پارک یا محل تفریح عمومی
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q10" value="منزل شما یا دوستانتان (پس دادن داره ها!)" type="radio" <?php if($other[10] == "منزل شما یا دوستانتان (پس دادن داره ها!)"){echo "checked";} ?>>
                            منزل شما یا دوستانتان (پس دادن داره ها!)
                        </label>
                    </div>

                    <h1 class="text-center mb-3 mt-4" style="font-weight:bold;">نظر شما درباره بیمه عمر چیه؟</h1>
                    <div class="input-group text-center flex-column">
                        <label class="cursor-pointer">                            
                            <input name="q11" value="بسیار مفید و الزامی" type="radio" <?php if($other[11] == "بسیار مفید و الزامی"){echo "checked";} ?>>
                            بسیار مفید و الزامی
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q11" value="چندان علاقه ای ندارم" type="radio" <?php if($other[11] == "چندان علاقه ای ندارم"){echo "checked";} ?>>
                            چندان علاقه ای ندارم
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q11" value="اطلاعاتی ندارم" type="radio" <?php if($other[11] == "اطلاعاتی ندارم"){echo "checked";} ?>>
                            اطلاعاتی ندارم
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q11" value="اشتباه ترین تصمیم اقتصادی!" type="radio" <?php if($other[11] == "اشتباه ترین تصمیم اقتصادی!"){echo "checked";} ?>>
                            اشتباه ترین تصمیم اقتصادی!
                        </label>
                    </div>

                    <h1 class="text-center mb-3 mt-4" style="font-weight:bold;">کدام مقصد سفر بعدی شما برای استراحت می تواند باشد؟</h1>
                    <div class="input-group text-center flex-column">
                        <label class="cursor-pointer">                            
                            <input name="q12" value="دوبی" type="radio" <?php if($other[12] == "دوبی"){echo "checked";} ?>>
                            دوبی
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q12" value="تایلند" type="radio" <?php if($other[12] == "تایلند"){echo "checked";} ?>>
                            تایلند
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q12" value="مالدیو" type="radio" <?php if($other[12] == "مالدیو"){echo "checked";} ?>>
                            مالدیو
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q12" value="اروپا" type="radio" <?php if($other[12] == "اروپا"){echo "checked";} ?>>
                            اروپا
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q12" value="آمریکای جنوبی" type="radio" <?php if($other[12] == "آمریکای جنوبی"){echo "checked";} ?>>
                            آمریکای جنوبی
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q12" value="آفریقا" type="radio" <?php if($other[12] == "آفریقا"){echo "checked";} ?>>
                            آفریقا
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q12" value="هیچ جا خونه آدم نمیشه" type="radio" <?php if($other[12] == "هیچ جا خونه آدم نمیشه"){echo "checked";} ?>>
                            هیچ جا خونه آدم نمیشه
                        </label>
                    </div>

                    <h1 class="text-center mb-3 mt-4" style="font-weight:bold;">در خانه برای آب آشامیدنی ترجیح می دهید :</h1>
                    <div class="input-group text-center flex-column">
                        <label class="cursor-pointer">                            
                            <input name="q13" value="بطری آب بخرید" type="radio" <?php if($other[13] == "بطری آب بخرید"){echo "checked";} ?>>
                            بطری آب بخرید
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q13" value="دستگاه تصفیه آب بذارید" type="radio" <?php if($other[13] == "دستگاه تصفیه آب بذارید"){echo "checked";} ?>>
                            دستگاه تصفیه آب بذارید
                        </label>
                        <label class="cursor-pointer mt-2">                            
                            <input name="q13" value="مگه آب لوله کشی چشه؟" type="radio" <?php if($other[13] == "مگه آب لوله کشی چشه؟"){echo "checked";} ?>>
                            مگه آب لوله کشی چشه؟
                        </label>
                    </div>
                    
                    <hr>
                    <div class="form-group text-center mb-4">
                        <label for="10" style="font-weight:bold;">* شماره موبایل</label>
                        <div>
                            <input dir="ltr" id="10" type="text" value="<?php echo $phone; ?>" name="phone" class="form-control text-center" placeholder="09xxxxxxx">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="sb" class="btn btn-lg btn-info btn-round">
                            <i class="icon-check"></i>
                            ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div><!-- /.portlet -->
    </div>                
</div><!-- /#page-content -->
<?php } ?>