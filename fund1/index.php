<?php
require "../DB/db.php";
$stmt = mysqli_stmt_init($conn);
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
$inbox = "inbox1";
$sql = "SELECT * FROM setting_nav WHERE inbox = ?";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "s" , $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)){
        $nav = $row['amount'];
    }
}
$green = "text-success";
$red = "text-danger";
// Calculate percentages //
$today = strtotime("today", time()) + 7200;
$yesterday = $today - 86400;
$lastweek = $today - 604800;
$lastmonth = $today - 2591998;
$threemonth = $today - 7775994;
$sixmonth = $today - 15551988;
$lastyear = $today - 31535975;

$yesterdayless = $yesterday-30;
$yesterdaymore = $yesterday+30;
$sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "sss" , $yesterdayless,$yesterdaymore, $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)){
        $yesterday_nav = (100 * $nav) / $row['amount'];
        $yesterday_nav = $yesterday_nav - 100;
    }
    else{
        $yesterday_nav = "-";
    }
    if($yesterday_nav != "-"){
        $yesterday_nav = number_format((float)$yesterday_nav,2,".","");
    }
}

$lastweekless = $lastweek-30;
$lastweekmore = $lastweek+30;
$sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "sss" , $lastweekless,$lastweekmore, $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)){
        $lastweek_nav = (100 * $nav) / $row['amount'];
        $lastweek_nav = $lastweek_nav - 100;
    }
    else{
        $lastweek_nav = "-";
    }
    if($lastweek_nav != "-"){
        $lastweek_nav = number_format((float)$lastweek_nav,2,".","");
    }
}

$lastmonthless = $lastmonth-30;
$lastmonthmore = $lastmonth+30;
$sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "sss" , $lastmonthless,$lastmonthmore, $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)){
        $lastmonth_nav = (100 * $nav) / $row['amount'];
        $lastmonth_nav = $lastmonth_nav - 100;
    }
    else{
        $lastmonth_nav = "-";
    }
    if($lastmonth_nav != "-"){
        $lastmonth_nav = number_format((float)$lastmonth_nav,2,".","");
    }
}

$threemonthless = $threemonth-30;
$threemonthmore = $threemonth+30;
$sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "sss" , $threemonthless,$threemonthmore, $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)){
        $threemonth_nav = (100 * $nav) / $row['amount'];
        $threemonth_nav = $threemonth_nav - 100;
    }
    else{
        $threemonth_nav = "-";
    }
    if($threemonth_nav != "-"){
        $threemonth_nav = number_format((float)$threemonth_nav,2,".","");
    }
}

$sixmonthless = $sixmonth-30;
$sixmonthmore = $sixmonth+30;
$sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "sss" , $sixmonthless,$sixmonthmore, $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)){
        $sixmonth_nav = (100 * $nav) / $row['amount'];
        $sixmonth_nav = $sixmonth_nav - 100;
    }
    else{
        $sixmonth_nav = "-";
    }
    if($sixmonth_nav != "-"){
        $sixmonth_nav = number_format((float)$sixmonth_nav,2,".","");
    }
}

$lastyearless = $lastyear-30;
$lastyearmore = $lastyear+30;
$sql = "SELECT * FROM nav_records WHERE date > ? AND date < ? AND inbox = ? ORDER BY id DESC";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "sss" , $lastyearless,$lastyearmore, $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($res)){
        $lastyear_nav = (100 * $nav) / $row['amount'];
        $lastyear_nav = $lastyear_nav - 100;
    }
    else{
        $lastyear_nav = "-";
    }
    if($lastyear_nav != "-"){
        $lastyear_nav = number_format((float)$lastyear_nav,2,".","");
    }
}
// End of Calculate percentages //


$sql = "SELECT * FROM nav_records WHERE inbox = ? ORDER BY date ASC";
if(!mysqli_stmt_prepare($stmt , $sql)){
    echo "SQLNotPreapred";
    exit();
}
else{
    mysqli_stmt_bind_param($stmt , "s" , $inbox);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl" class="rtl">
    <head>
        <title>گزارشات <?php echo $inbox1_name; ?> | EMX</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="fontiran.com:license" content="NE29X">
        <link rel="shortcut icon" href="../assets/images/favicon.png">
        <!-- BEGIN CSS -->
        <link href="../assets/plugins/bootstrap/bootstrap5/css/bootstrap.rtl.min.css" rel="stylesheet">
        <link href="../assets/plugins/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../assets/plugins/simple-line-icons/css/simple-line-icons.min.css" rel="stylesheet">
        <link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../assets/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
        <link href="../assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet">
        <link href="../assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
        <link href="../assets/plugins/paper-ripple/dist/paper-ripple.min.css" rel="stylesheet">
        <link href="../assets/plugins/iCheck/skins/square/_all.css" rel="stylesheet">
        <link href="../assets/css/style.css" rel="stylesheet">
        <link href="../assets/css/colors.css" rel="stylesheet">
        <link href="../assets/css/wenk.css" rel="stylesheet">
        <link href="../assets/plugins/data-table/DataTables-1.10.16/css/jquery.dataTables.css" rel="stylesheet">
        <link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet">
        <!-- END CSS -->
        <script src="../assets/plugins/jquery/dist/jquery-3.1.0.js"></script>
    </head>
    <body>
        <!-- BEGIN LOEADING -->
        <div id="loader">
            <div class="spinner"></div>
        </div><!-- /loader -->
        <!-- END LOEADING -->
        <div id="page-content" style="margin-right:0;">
        <div class="container">

            <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6">
                <h1 style="font-weight:bold;">گزارشات <?php echo $inbox1_name; ?></h1>
            </div>

            <div class="row justify-content-evenly">
                <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
                    <h3>بازده از دیروز : <span dir="ltr" class="<?php if($yesterday_nav>0){echo $green;}elseif($yesterday_nav<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($yesterday_nav>0){echo "+";} ?><?php echo $yesterday_nav; ?>%</span></h3>
                </div>
                <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
                    <h3>بازده هفته گذشته : <span dir="ltr" class="<?php if($lastweek_nav>0){echo $green;}elseif($lastweek_nav<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($lastweek_nav>0){echo "+";} ?><?php echo $lastweek_nav; ?>%</span></h3>
                </div>
                <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
                    <h3>بازده ماه گذشته : <span dir="ltr" class="<?php if($lastmonth_nav>0){echo $green;}elseif($lastmonth_nav<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($lastmonth_nav>0){echo "+";} ?><?php echo $lastmonth_nav; ?>%</span></h3>
                </div>
            </div>
            <div class="row justify-content-evenly">
                <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
                    <h3>بازده سه ماه گذشته : <span dir="ltr" class="<?php if($threemonth_nav>0){echo $green;}elseif($threemonth_nav<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($threemonth_nav>0){echo "+";} ?><?php echo $threemonth_nav; ?>%</span></h3>
                </div>
                <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
                    <h3>بازده شش ماه گذشته : <span dir="ltr" class="<?php if($sixmonth_nav>0){echo $green;}elseif($sixmonth_nav<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($sixmonth_nav>0){echo "+";} ?><?php echo $sixmonth_nav; ?>%</span></h3>
                </div>
                <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
                    <h3>بازده سال گذشته : <span dir="ltr" class="<?php if($lastyear_nav>0){echo $green;}elseif($lastyear_nav<0){echo $red;} ?>" style="font-weight:bold;"> <?php if($lastyear_nav>0){echo "+";} ?><?php echo $lastyear_nav; ?>%</span></h3>
                </div>
            </div>
            
            <div class="portlet box border text-center shadow m-auto col-12">
                <div id="inbox"></div>
            </div>
            

            </div>
        </div>
    </body>
    <!-- BEGIN JS -->
    <script src="../assets/plugins/bootstrap/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/plugins/metisMenu/dist/metisMenu.min.js"></script>
    <script src="../assets/plugins/paper-ripple/dist/PaperRipple.min.js"></script>
    <script src="../assets/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="../assets/plugins/screenfull/dist/screenfull.min.js"></script>
    <script src="../assets/plugins/iCheck/icheck.min.js"></script>
    <script src="../assets/plugins/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/plugins/select2/dist/js/i18n/fa.js"></script>
    <script src="../assets/js/pages/select2.js"></script>
    <script src="../assets/js/core.js"></script>
    <script src="../highchart/highstock.js"></script>
    <script src="../highchart/modules/data.js"></script>
    <script src="../highchart/modules/exporting.js"></script>
    <script src="../highchart/modules/export-data.js"></script>
    <script src="../highchart/modules/accessibility.js"></script>
    <script src="../persiandate/dist/persian-date.js" type="text/javascript"></script>
<script>
// Create the stock example
// Create the chart

Highcharts.setOptions({
  lang: {
    thousandsSep: ',',
    rangeSelectorZoom: "بزرگ نمایی"
  }
});

Highcharts.RangeSelector.prototype.defaultButtons = [

    {
    type: 'month',
    count: 1,
    text: 'ماهیانه'
}, {
    type: 'month',
    count: 3,
    text: 'فصلی'
}, {
    type: 'month',
    count: 6,
    text: 'شش ماهه'
}, {
    type: 'ytd',
    text: 'امسال'
}, {
    type: 'year',
    count: 1,
    text: 'سالیانه',
}, {
    type: 'all',
    text: 'همه'
}];

let data2 = [
    <?php while($row = mysqli_fetch_assoc($res)){ ?>
        [<?php echo $row['date']*1000; ?>, <?php echo $row['amount']; ?>],
    <?php } ?>
    ];

$(function() {
    Highcharts.dateFormats = {
        'a': function(ts){return new persianDate(ts).format('dddd')},
        'A': function(ts){return new persianDate(ts).format('dddd')},
        'd': function(ts){return new persianDate(ts).format('DD')},
        'e': function(ts){return new persianDate(ts).format('D')},
        'b': function(ts){return new persianDate(ts).format('MMMM')},
        'B': function(ts){return new persianDate(ts).format('MMMM')},
        'm': function(ts){return new persianDate(ts).format('MM')},
        'y': function(ts){return new persianDate(ts).format('YY')},
        'Y': function(ts){return new persianDate(ts).format('YYYY')},
        'W': function(ts){return new persianDate(ts).format('ww')}
    };
    let chart = new Highcharts.StockChart({
        
    chart: {
        renderTo: 'inbox',
        style: {
            fontWeight: 'bold',
            fontFamily: 'IranSans',
        }
    },

    rangeSelector: {
        selected: 3,
        inputEnabled : false,
        buttonTheme: {
            fill: '#066EA5',
            stroke: '#066EA5',
            width : 60,
            height : 25,
            style: {
                color: '#FFFFFF',
                fontSize: '12px',
                fontWeight: 'bold'
            },
            states: {
                hover: {
                        fill: '#333333',
                        stroke: '#333333',
                },
                select: {
                        fill: '#CCCCCC',
                        stroke: '#CCCCCC',
                }
            }
        },
    },

    yAxis: {
        title:{
            text: "قیمت (تتر)"
        },
        labels: {
            format: '{value:,.0f} $'
        },
    },

    credits: {
        enabled: false
    },
   
    title: {
        text: 'نمودار',
    },

    exporting: {
        enabled: false
    },
    tooltip: {
        dateTimeLabelFormats: {
        second: "%A, %e %b",
        }
    },

    series: [{
        name: 'قیمت',
        type: 'area',
        data: data2,
        tooltip: {
            yDecimals: 4
    }}]

    
});


});
</script>
</html>