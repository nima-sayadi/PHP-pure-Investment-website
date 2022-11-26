<?php

if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $stmt = mysqli_stmt_init($conn);

    $inbox = "inbox1";

    $sql = "SELECT * FROM setting_inbox WHERE inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $inbox_name = $row['name'];
        }
    }

    $sql = "SELECT * FROM requests WHERE user=? AND inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $_SESSION['user_mail'] , $inbox);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num = mysqli_stmt_num_rows($stmt);
    }

    if($num < 1){ ?>
        <div id="page-content">
            <div class="container">
                <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6">
                    <h1>این صفحه برای شما وجود ندارد !</h1>
                </div>
            </div>
        </div>
    <?php } else{

    $s = "تایید شده";
    $remain = 0;
    $all_buy = 0;
    $all_sell = 0;
    $t_buy = "خرید (صدور)";
    $t_sell = "فروش (ابطال)";
    $sql = "SELECT * FROM requests WHERE user=? AND inbox = ? AND status=? AND type=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $_SESSION['user_mail'] , $inbox , $s,$t_buy);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($res)){
            $remain = $remain + $row['remaining_amount'];
            $all_buy = $all_buy + $row['buy_price'];
        }
    }

    $sql = "SELECT * FROM requests WHERE user=? AND inbox = ? AND status=? AND type=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ssss" , $_SESSION['user_mail'] , $inbox , $s,$t_sell);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($res)){
            $all_sell = $all_sell + $row['sell_price'];
        }
    }

    $sql = "SELECT * FROM requests WHERE user=? AND inbox = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $_SESSION['user_mail'] , $inbox);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }
    


?>

<!-- BEGIN PAGE CONTENT -->
<style>
    .btnsss{
        width:unset;
    }
    h1{
        white-space: nowrap;
    }
</style>
<div id="page-content">

    <div class="portlet box border text-center shadow m-b-20 mx-auto col-lg-6 col-md-6">
        <h2>نام صندوق : <span style="font-weight:bold;"><?php echo $inbox_name; ?></span></h2>
    </div>

    <div class="row justify-content-evenly">
        <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
            <h2>مانده واحد ها : <span style="font-weight:bold;"><?php echo $remain; ?> واحد سهم</span></h2>
        </div>

        <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
            <h2>جمع مبلغ کل خرید : <span style="font-weight:bold;"><?php echo number_format($all_buy); ?> تتر</span></h2>
        </div>

        <div class="portlet box border text-center shadow m-b-20 col-lg-3 col-md-3">
            <h2>جمع مبلغ کل فروش : <span style="font-weight:bold;"><?php echo number_format($all_sell); ?> تتر</span></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="portlet box border shadow">

                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">آی دی</th>
                                    <th class="text-center">نوع درخواست</th>
                                    <th class="text-center">تعداد درخواستی</th>
                                    <th class="text-center">ارزش NAV</th>
                                    <th class="text-center">مبلغ کل خرید (صدور)</th>
                                    <th class="text-center">مبلغ کل فروش (ابطال)</th>
                                    <th class="text-center">تاریخ درخواست</th>
                                    <th class="text-center">تاریخ تایید</th>
                                    <th class="text-center">هزینه ابطال (تتر)</th>
                                    <th class="text-center">وضعیت</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($res)){ 
                                    if($row['status'] == "تایید شده"){
                                        $class = "label-success";
                                    }
                                    elseif($row['status'] == "تایید نشده"){
                                        $class = "label-danger";
                                    }
                                    else{
                                        $class = "label-warning";
                                    }

                                    if($row['type'] == "خرید (صدور)"){
                                        $class2 = "label-success";
                                    }
                                    elseif($row['type'] == "فروش (ابطال)"){
                                        $class2 = "label-danger";
                                    }

                                    if($row['confirm_date'] == ""){
                                        $confirm_date = "-";
                                    }
                                    else{
                                        $confirm_date = $row['confirm_date'];
                                    }

                                    $request_amount = $row['request_amount'];
                                    $request_amount = "$request_amount سهم";

                                    if($row['buy_price'] == ""){
                                        $buy_price = "-";
                                    }
                                    else{
                                        $buy_price = number_format($row['buy_price']);
                                    }

                                    if($row['sell_price'] == ""){
                                        $sell_price = "-";
                                    }
                                    else{
                                        $sell_price = number_format($row['sell_price']);
                                    }

                                    if($row['tax'] == ""){
                                        $tax = "-";
                                    }
                                    else{
                                        $tax = $row['tax'];
                                    }
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                    <td class="text-center"><h1><span class="label <?php echo $class2; ?>"><?php echo $row['type']; ?></span></h1></td>
                                    <td class="text-center"><?php echo $request_amount; ?></td>
                                    <td class="text-center"><?php echo number_format($row['nav']); ?></td>
                                    <td class="text-center"><?php echo $buy_price; ?></td>
                                    <td class="text-center"><?php echo $sell_price; ?></td>
                                    <td class="text-center"><?php echo $row['request_date']; ?></td>
                                    <td class="text-center"><?php echo $confirm_date; ?></td>
                                    <td class="text-center"><?php echo $tax; ?></td>
                                    <td class="text-center"><h1><span class="label <?php echo $class; ?>"><?php echo $row['status']; ?></span></h1></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div><!-- /.col-lg-12 -->                    
    </div><!-- /.row -->
</div><!-- /#page-content -->
<!-- END PAGE CONTENT -->
<script src="../assets/plugins/data-table/js/jquery.dataTables.min.js"></script>
<script>
    var tableMain = $('#data-table').DataTable({
        "columns": 
        [
            { "data": "id" },
            { "data": "type" },
            { "data": "num" },
            { "data": "nav" },
            { "data": "buy" },
            { "data": "sell" },
            { "data": "requestDate" },
            { "data": "confirmDate" },
            { "data": "tax" },
            { "data": "status" },
        ],
        "order": [[ 0, "desc" ]],
    "pageLength": 10
    });

    $(window).on( 'resize', function () {
        $('#data-table').css("width", "100%");
    } );
</script>
<?php } } ?>