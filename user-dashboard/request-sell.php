<?php

if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT * FROM setting_nav ORDER BY id DESC";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)){
        if($row['inbox'] == "inbox1"){
            $inbox1 = $row['amount'];
        }
        elseif($row['inbox'] == "inbox2"){
            $inbox2 = $row['amount'];
        }
        elseif($row['inbox'] == "inbox3"){
            $inbox3 = $row['amount'];
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

    $fk = "تایید شده";
    $type = "خرید (صدور)";
    $inbox = "inbox1";
    $remaining_amount1 = 0;
    $sql = "SELECT * FROM requests WHERE type = ? AND inbox=? AND status=? AND user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $type,$inbox,$fk,$_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($res)){
            $remaining_amount1 = $remaining_amount1 + $row['remaining_amount'];
        }
    }

    $inbox = "inbox2";
    $remaining_amount2 = 0;
    $sql = "SELECT * FROM requests WHERE type = ? AND inbox=? AND status=?  AND user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $type,$inbox,$fk,$_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($res)){
            $remaining_amount2 = $remaining_amount2 + $row['remaining_amount'];
        }
    }

    $inbox = "inbox3";
    $remaining_amount3 = 0;
    $sql = "SELECT * FROM requests WHERE type = ? AND inbox=? AND status=?  AND user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $type,$inbox,$fk,$_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($res)){
            $remaining_amount3 = $remaining_amount3 + $row['remaining_amount'];
        }
    }

    $s = "تایید شده";
    $sql = "SELECT * FROM wallets WHERE user=? AND status=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $_SESSION['user_mail'],$s);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }
    


?>

<!-- BEGIN PAGE CONTENT -->
<style>
    @media (max-width : 1023px){
        .rep{
            text-align:center;
            margin-top: .5rem;
        }
        .inb{
            flex-direction: column;
            margin-top: 0.5rem;
            justify-content:unset;
        }
    }
    .input-error{
        outline: 1px solid red !important;
        }
</style>
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
            پر کردن تمام فیلد ها ضروریست !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "walletInvalid") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            این کیف پول وجود ندارد !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "numInvalid") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            تعداد سهم های درخواستی به درستی وارد نشده است !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "numLow") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            تعداد سهم های درخواستی از موجودی شما بیشتر است !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "radioInvalid") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            مقادیر به درستی ارسال نشده اند !
        </div>
    <?php } ?>
    <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
        <div class="portlet box border shadow">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h1 style="font-weight:bold;" class="title text-center">
                        <i class="icon-frane"></i>
                        فرم درخواست فروش (ابطال)
                    </h1>
                </div>
            </div>
            <div class="portlet-body">
                <form action="controllers/sell-request.php" method="POST">
                    <div class="row my-3">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label style="font-weight:bold;">* انتخاب صندوق سرمایه گذاری :</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="input-group text-center justify-content-around inb">
                                
                                <label style="color:green;" class="cursor-pointer">                            
                                    <input name="inbox" class="r1" value="inbox1" type="radio" checked>
                                    <?php echo $inbox1_name; ?>
                                </label>
                            
                            
                                <label style="color:orange;" class="cursor-pointer">                            
                                    <input name="inbox" class="r2"  value="inbox2" type="radio" >
                                    <?php echo $inbox2_name; ?>
                                </label>
                            
                            
                                <label style="color:red;" class="cursor-pointer">                            
                                    <input name="inbox" class="r3"  value="inbox3" type="radio" >
                                    <?php echo $inbox3_name; ?>
                                </label>
                                
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <label style="font-weight:bold;">* تعداد واحد جهت فروش :</label>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                                <div class="form-group text-center">
                                    <div>
                                        <input type="text" name="num" id="num" class="form-control text-center" placeholder="تعداد">
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                            <label style="font-weight:bold;">قیمت آخر هر واحد سهم : <span style="color:green;"><span class="lastP"></span>$</span></label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 rep">
                            <a class="refLink btn btn-round btn-warning btn-sm" href="">مشاهده گزارشات صندوق</a>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-3 col-sm-7" style="font-weight:bold;">
                            * موجودی شما در این صندوق :
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-5">
                            <h1><span class="label label-secondary"><strong class="remaining" style="color:#45d0e9;">0</strong> سهم</span></h1>
                        </div>
                    </div>
                    <hr>
                    <div class="input-group justify-content-evenly">
                        <label style="font-weight:bold" class="cursor-pointer">                            
                            <input name="other" value="فروش فقط در این قیمت یا بالاتر از این" type="radio" >
                            فروش فقط در این قیمت یا بالاتر از این
                        </label>

                        <label style="font-weight:bold" class="cursor-pointer">                            
                            <input name="other" value="فروش در هر قیمتی" type="radio" checked>
                            فروش در هر قیمتی
                        </label>
                    </div>
                    <hr>
                    <h3 class="mb-3 text-center">لطفا کیف پول خود را انتخاب کنید. برای افزودن کیف پول جدید میتوانید به بخش " کیف پول ها " مراجعه کنید.</h3>
                    <div class="form-group text-center mb-4">
                    <select class="form-control select2" name="wallet">
                        <option value="none">* انتخاب کنید</option>
                        <?php while($row = mysqli_fetch_assoc($res)){ ?>
                            <option value="<?php echo $row['address']; ?>"><?php echo $row['address']; ?></option>
                        <?php } ?>
                    </select>
                    </div>

                    <div class="form-group text-center">
                        <div class="text-center">
                            <button type="submit" name="sb" class="btn btn-lg btn-success btn-round">
                                <i class="icon-check"></i>
                                ثبت درخواست
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.portlet -->
    </div>                
</div><!-- /#page-content -->
<?php } ?>
<script>
    function setInputFilter(textbox, inputFilter, errMsg) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(function(event) {
            textbox.addEventListener(event, function(e) {
            if (inputFilter(this.value)) {
                
                if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
                this.classList.remove("input-error");
                this.setCustomValidity("");
                }
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                
                this.classList.add("input-error");
                this.setCustomValidity(errMsg);
                this.reportValidity();
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
               
                this.value = "";
            }
            });
        });
    }
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function numberWithoutCommas(x) {
        return x.toString().replace(/,/g, "");
    }
    let r1 = document.querySelector(".r1");
    let r2 = document.querySelector(".r2");
    let r3 = document.querySelector(".r3");
    let remaining = document.querySelector(".remaining");
    let lastP = document.querySelector(".lastP");
    let refLink = document.querySelector(".refLink");
    let inbox1 = "<?php echo $inbox1; ?>";
    let inbox2 = "<?php echo $inbox2; ?>";
    let inbox3 = "<?php echo $inbox3; ?>";
    if(r1.checked){
        lastP.innerText = numberWithCommas(inbox1);
    }
    refLink.href = "?inbox=inbox1";
    remaining.innerText = "<?php echo $remaining_amount1; ?>";
    $('.r1').on('ifChecked', function(event){
        lastP.innerText = numberWithCommas(inbox1);
        refLink.href = "?inbox=inbox1";
        remaining.innerText = "<?php echo $remaining_amount1; ?>";
    });
    $('.r2').on('ifChecked', function(event){
        lastP.innerText = numberWithCommas(inbox2);
        refLink.href = "?inbox=inbox2";
        remaining.innerText = "<?php echo $remaining_amount2; ?>";
    });
    $('.r3').on('ifChecked', function(event){
        lastP.innerText = numberWithCommas(inbox3);
        refLink.href = "?inbox=inbox3";
        remaining.innerText = "<?php echo $remaining_amount3; ?>";
    });
    setInputFilter(document.getElementById("num"), function(value) {
    return /^\d*\d*$/.test(value);
    }, "تنها اعداد صحیح قابل قبول میباشد");
</script>