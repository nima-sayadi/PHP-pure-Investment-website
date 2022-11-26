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

    $sql = "SELECT * FROM setting_wallet";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)){
        if($row['inbox'] == "inbox1"){
            $wallet1 = $row['address'];
            $network1 = $row['network'];
        }
        elseif($row['inbox'] == "inbox2"){
            $wallet2 = $row['address'];
            $network2 = $row['network'];
        }
        elseif($row['inbox'] == "inbox3"){
            $wallet3 = $row['address'];
            $network3 = $row['network'];
        }
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
            تعداد سهم های درخواستی به درستی وارد نشده است !
        </div>
    <?php } ?>
    <?php if(isset($_GET['error']) && $_GET['error'] == "extInvalid") { ?>
        <script>
            setTimeout(() => {
                document.querySelector(".alert.alert-danger").style.display = "none";
            }, 10000);
        </script>
        <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
            تنها فرمت عکس مجاز است !
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
                        فرم درخواست خرید (صدور)
                    </h1>
                </div>
            </div>
            <div class="portlet-body">
                <form action="controllers/buy-request.php" enctype="multipart/form-data" method="POST">
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
                            <label style="font-weight:bold;">* تعداد واحد جهت خرید :</label>
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
                    <hr>
                    <div class="input-group justify-content-evenly">
                        <label style="font-weight:bold" class="cursor-pointer">                            
                            <input name="other" value="خرید فقط در این قیمت یا پایینتر از این" type="radio" >
                            خرید فقط در این قیمت یا پایینتر از این
                        </label>

                        <label style="font-weight:bold" class="cursor-pointer">                            
                            <input name="other" value="خرید در هر قیمتی" type="radio" checked>
                            خرید در هر قیمتی
                        </label>
                    </div>
                    <hr>
                    <hr>
                    <h2 class="text-center mb-2"><strong style="color:black;">آدرس کیف پول صندوق</strong></h2>
                    <div class="alert alert-success fill text-center">
                        <strong class="wallet" style="color:black;word-wrap: break-word;"></strong>
                        <br>
                        <strong style="color:black;">شبکه : <span class="network"></span></strong>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                        <div class="alert alert-success text-center" style="border-right-width:1px;color:black;">
                            دقیقا مبلغ <strong style="color:red;"><span class="finalPrice">-</span> تتر</strong> را به آدرس بالا ارسال کنید
                        </div>
                    </div>
                    <hr>
                    <div class="form-group text-center">
                        <label for="1" style="font-weight:bold;">آدرس تایید ارسال</label>
                        <div>
                            <input type="text" id="1" name="url" class="form-control text-center" placeholder="URL تتر اسکن یا مشابه آن">
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
    let wallet = document.querySelector(".wallet");
    let network = document.querySelector(".network");
    let lastP = document.querySelector(".lastP");
    let refLink = document.querySelector(".refLink");
    let inbox1 = "<?php echo $inbox1; ?>";
    let inbox2 = "<?php echo $inbox2; ?>";
    let inbox3 = "<?php echo $inbox3; ?>";
    let number = document.querySelector("#num");
    let final;
    if(r1.checked){
        lastP.innerText = numberWithCommas(inbox1);
    }
    refLink.href = "?inbox=inbox1";
    wallet.innerText = "<?php echo $wallet1; ?>";
    network.innerText = "<?php echo $network1; ?>";
    $('.r1').on('ifChecked', function(event){
        lastP.innerText = numberWithCommas(inbox1);
        refLink.href = "?inbox=inbox1";
        final = Number(number.value) * Number(numberWithoutCommas(lastP.innerText));
        document.querySelector(".finalPrice").innerText = numberWithCommas(final);
        wallet.innerText = "<?php echo $wallet1; ?>";
        network.innerText = "<?php echo $network1; ?>";
    });
    $('.r2').on('ifChecked', function(event){
        lastP.innerText = numberWithCommas(inbox2);
        refLink.href = "?inbox=inbox2";
        final = Number(number.value) * Number(numberWithoutCommas(lastP.innerText));
        document.querySelector(".finalPrice").innerText = numberWithCommas(final);
        wallet.innerText = "<?php echo $wallet2; ?>";
        network.innerText = "<?php echo $network2; ?>";
    });
    $('.r3').on('ifChecked', function(event){
        lastP.innerText = numberWithCommas(inbox3);
        refLink.href = "?inbox=inbox3";
        final = Number(number.value) * Number(numberWithoutCommas(lastP.innerText));
        document.querySelector(".finalPrice").innerText = numberWithCommas(final);
        wallet.innerText = "<?php echo $wallet3; ?>";
        network.innerText = "<?php echo $network3; ?>";
    });
    setInputFilter(document.getElementById("num"), function(value) {
    return /^\d*\d*$/.test(value);
    }, "تنها اعداد صحیح قابل قبول میباشد");
    number.addEventListener("keyup" , function(){
        final = Number(number.value) * Number(numberWithoutCommas(lastP.innerText));
        document.querySelector(".finalPrice").innerText = numberWithCommas(final);
    });
    number.addEventListener("change" , function(){
        final = Number(number.value) * Number(numberWithoutCommas(lastP.innerText));
        document.querySelector(".finalPrice").innerText = numberWithCommas(final);
    });
</script>