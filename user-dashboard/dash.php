<?php
if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} else { 
    $stmt = mysqli_stmt_init($conn);
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

    $sql = "SELECT * FROM users WHERE mail = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        header("Location: ../?request=buy&error=SQLNotPrepare");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $other = $row['other'];
        }
    }
    function myFilter($var){
        return ($var !== NULL && $var !== FALSE && $var !== '');
    }
    $other = unserialize($other);
    if(!empty($other)){
        $other = array_filter($other , 'myFilter');
        $other = count($other);
        $profile_done = ($other * 100) / 14;
        $profile_done = floor($profile_done);
        $profile_undone = 100 - $profile_done;
        $profile_undone = ceil($profile_undone);
    }
    else{
        $profile_done = 0;
        $profile_undone = 100;
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

        .pricingTable .btn-block h1:before{
            content: "\f022";
            font-family: 'FontAwesome';
            font-size: 20px;
            padding-left: 10px;
        }

        .pricingTable .bsecond{
            background: #368279;
        }

        .pricingTable .btn-block:hover{
            background: #419e00;
            color:#fff;
        }

        .profile-percent{
            font-size:80px;
        }
        .profile-percent-span{
            font-size:18px;
        }

        @media screen and (max-width:990px){
            .pricingTable{
                margin-bottom: 20px;
            }
        }

        @media screen and (max-width:1023px){
            .profile-percent{
                font-size:60px;
            }
        }

    </style>
    <div id="page-content">
        <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6 ">
            <h1 style="font-weight:bold;"><?php echo $user_name; ?> عزیز ، به سامانه صندوق سرمایه گذاری خوش آمدید.</h1>
        </div>
        
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="pricingTable">
                    <div class="pricingTable-header">
                        <span class="heading">
                            <h1>لیست صندوق های ما</h1>
                        </span>
                    </div>

                    <div class="pricingContent">
                        <ul>
                            <li><h2><b><?php echo $inbox1_name; ?></b></h2></li>
                            <li><h2><b><?php echo $inbox2_name; ?></b></h2></li>
                            <li><h2><b><?php echo $inbox3_name; ?></b></h2></li>
                        </ul>
                    </div>
                    <div class="row justify-content-between">
                        <div class="pricingTable-sign-up">
                            <a href="?inbox=list" class="btn btn-block btn-default" style="width:90%"><h1>مشاهده جزئیات کامل صندوق ها</h1></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div id="container">

                </div>
                <?php if($profile_done < 100){ ?>
                <a href="?profile" class="btn btn-block btn-default" style="width:100%;background: #13a2a6;color: #fff;"><h1>برای تکمیل پروفایل خود کلیک کنید</h1></a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<script src="../highchart/highstock.js"></script>
<script src="../highchart/modules/data.js"></script>
<script src="../highchart/modules/exporting.js"></script>
<script src="../highchart/modules/export-data.js"></script>
<script src="../highchart/modules/accessibility.js"></script>
<script>
Highcharts.chart('container', {
    title: {
        text: ''
    },

    chart: {
        style: {
            fontWeight: 'bold',
            fontFamily: 'IranSans',
        }
    },

    subtitle: {
        text: `<div class ="profile-percent"><?php echo $profile_done; ?>%</div> <span class="profile-percent-span">! پروفایل شما تکمیل شده</span>`,
        align: "center",
        verticalAlign: "middle",
        style: {
            "textAlign": "center"
        },
        x: 0,
        y: -2,
        useHTML: true
    },

    exporting: {
        enabled: false
    },

    credits: {
        enabled: false
    },

    series: [{
        type: 'pie',
        enableMouseTracking: false,
        innerSize: '80%',
        dataLabels: {
            enabled: false
        },
        data: [
            {
                y: <?php echo $profile_done; ?>,
                color: '#13a2a6'
            }, 
            {
                y: <?php echo $profile_undone; ?>,
                color: '#e3e3e3'
            }
        ]
    }]
});

</script>
