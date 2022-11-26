<?php
if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} else { 
    $stmt = mysqli_stmt_init($conn);
    $in1 = "inbox1";
    $in2 = "inbox2";
    $in3 = "inbox3";
    $sql = "SELECT * FROM requests WHERE user=? AND inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $_SESSION['user_mail'] , $in1);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num1 = mysqli_stmt_num_rows($stmt);
    }

    $sql = "SELECT * FROM requests WHERE user=? AND inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $_SESSION['user_mail'] , $in2);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num2 = mysqli_stmt_num_rows($stmt);
    }

    $sql = "SELECT * FROM requests WHERE user=? AND inbox=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $_SESSION['user_mail'] , $in3);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num3 = mysqli_stmt_num_rows($stmt);
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
    <style>
        .heading-title
        {
            margin-bottom: 100px;
        }
        .pricingTable{
            border: 1px solid #dbdbdb;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.14);
            border-radius: 10px;
            text-align: center;
        }

        .pricingTable .pricingTable-header{
            background-color: #f5f5f5;
            color:#fff;
        }

        .pricingTable-header .heading{
            background-color: #13a2a6;
            display: block;
            padding: 15px 10px;
            transition:0.4s ease-in-out;
        }

        .pricingTable:hover .heading{
            background-color: #419e00;
        }

        .pricingTable .heading h3{
            font-weight:bold;
            margin: 0;
            text-transform: uppercase;
        }

        .pricingTable-header .price-value {
            display: block;
            font-size: 25px;
            font-weight: 800;
            color: #474747;
            line-height: 35px;
            margin-top: 10px;
            padding: 20px 10px 0;
        }

        .pricingTable .price-value span{
            font-size: 60px;
            font-weight: 100;
        }

        .pricingTable .subtitle{
            font-size: 13px;
            color: #262626;
            margin-top: 15px;
            display: block;
        }

        .pricingTable .pricingContent ul{
            list-style: none;
            padding: 0;
            margin-bottom: 0;
        }

        .pricingTable .pricingContent ul li{
            border-top: 1px solid #dbdbdb;
            padding: 10px 0;
            background-color: #f5ffff;
        }

        .pricingTable .pricingContent ul li:nth-child(odd) {
            background-color: #fff;
        }

        .pricingContent ul li:last-child{
            border-bottom: 1px solid #dbdbdb;
        }

        .pricingTable .pricingTable-sign-up{
            padding: 25px 0;
        }

        .pricingTable .btn-block{
            background: #13a2a6;
            border:0px none;
            border-radius: 5px;
            color:#fff;
            width: 50%;
            padding: 10px 5px;
            margin: 0 auto;
            transition:0.3s ease;
        }

        .pricingTable .btn-block:before{
            content: "\f0ce";
            font-family: 'FontAwesome';
            font-size: 15px;
            padding-left: 10px;
        }

        .pricingTable .bsecond{
            background: #368279;
        }

        .pricingTable .bsecond:before{
            content: "\f1fe";
            font-family: 'FontAwesome';
            font-size: 15px;
            padding-left: 10px;
        }

        .pricingTable .btn-block:hover{
            background: #419e00;
            color:#fff;
        }

        @media screen and (max-width:990px){
            .pricingTable{
                margin-bottom: 20px;
            }
        }

    </style>
    <div id="page-content">
    <div class="container">
            
            <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6">
                <h1>صندوق های من</h1>
            </div>
            
            
            <div class="row user-select-none justify-content-center">
                <?php if($num1 > 0){ ?>
                <div class="col-md-3 col-sm-6">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <span class="heading">
                                <h3><?php echo $inbox1_name; ?></h3>
                            </span>
                        </div>


                        <div class="row justify-content-between">
                            <div class="pricingTable-sign-up">
                                <a href="?cardex=inbox1" style="background:#1a5d2b;font-weight:bold;" class="btn btn-block btn-success">مشاهده کاردکس</a>
                            </div>
                            <div class="pricingTable-sign-up p-t-0">
                                <a href="?inbox=inbox1" class="btn btn-block bsecond btn-default">جزئیات / نمودار</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if($num2 > 0){ ?>
                <div class="col-md-3 col-sm-6">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <span class="heading">
                                <h3><?php echo $inbox2_name; ?></h3>
                            </span>
                        </div>

                        <div class="row justify-content-between">
                            <div class="pricingTable-sign-up">
                                <a href="?cardex=inbox2" style="background:#1a5d2b;font-weight:bold;" class="btn btn-block btn-success">مشاهده کاردکس</a>
                            </div>
                            <div class="pricingTable-sign-up p-t-0">
                                <a href="?inbox=inbox2" class="btn btn-block bsecond btn-default">جزئیات / نمودار</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if($num3 > 0){ ?>
                <div class="col-md-3 col-sm-6">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <span class="heading">
                                <h3><?php echo $inbox3_name; ?></h3>
                            </span>
                        </div>

                        <div class="row justify-content-between">
                            <div class="pricingTable-sign-up">
                                <a href="?cardex=inbox3" style="background:#1a5d2b;font-weight:bold;" class="btn btn-block btn-success">مشاهده کاردکس</a>
                            </div>
                            <div class="pricingTable-sign-up p-t-0">
                                <a href="?inbox=inbox3" class="btn btn-block bsecond btn-default">جزئیات / نمودار</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
