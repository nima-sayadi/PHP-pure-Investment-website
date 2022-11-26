<?php

if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT * FROM setting_inbox";
    $res = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($res)){
        if($row['inbox'] == "inbox1"){
            $inbox1 = $row['name'];
        }
        elseif($row['inbox'] == "inbox2"){
            $inbox2 = $row['name'];
        }
        elseif($row['inbox'] == "inbox3"){
            $inbox3 = $row['name'];
        }
    }

    $sql = "SELECT * FROM requests";
    $res = mysqli_query($conn,$sql);
    


?>

<!-- BEGIN PAGE CONTENT -->
<style>
    .btnsss{
        width:unset;
    }
    h2{
        white-space: nowrap;
    }
    a{
        color: #147274 ;
    }
</style>
<div id="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="portlet box border shadow">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h1 class="title">
                            <i class="icon-frane"></i>
                            لیست درخواست های خرید / فروش
                        </h1>
                    </div>
                </div><!-- /.portlet-heading -->
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">آی دی</th>
                                    <th class="text-center">نوع درخواست</th>
                                    <th class="text-center">ایمیل کاربر</th>
                                    <th class="text-center">تاریخ درخواست</th>
                                    <th class="text-center">تاریخ تایید</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">جزئیات کامل</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($res)){ 
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
                                            $mail = $row2['mail'];
                                            $username = $row2['name'];
                                        }
                                    }
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

                                    if($row['type'] == "فروش (ابطال)"){
                                        $wallet = $row['wallet'];
                                    }
                                    else{
                                        $wallet = "-";
                                    }

                                    if($row['confirm_date'] == ""){
                                        $confirm_date = "-";
                                    }
                                    else{
                                        $confirm_date = $row['confirm_date'];
                                    }

                                    if($row['inbox'] == "inbox1"){
                                        $inbox_name = $inbox1;
                                    }
                                    elseif($row['inbox'] == "inbox2"){
                                        $inbox_name = $inbox2;
                                    }
                                    elseif($row['inbox'] == "inbox3"){
                                        $inbox_name = $inbox3;
                                    }

                                    $request_amount = $row['request_amount'];
                                    $request_amount = "$request_amount سهم";
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                    <td class="text-center"><h2><span class="label <?php echo $class2; ?>"><?php echo $row['type']; ?></span></h2></td>
                                    <td class="text-center"><a style="font-weight:bold;" href="?user=show&mail=<?php echo $mail; ?>" target="_blank"><?php echo $mail; ?></a></td>
                                    <td class="text-center"><?php echo $row['request_date']; ?></td>
                                    <td class="text-center"><?php echo $confirm_date; ?></td>
                                    <td class="text-center"><h2><span class="label <?php echo $class; ?>"><?php echo $row['status']; ?></span></h2></td>
                                    <td class="text-center">
                                        <button class="btn btn-md btn-secondary round" data-bs-toggle="modal" data-bs-target="#detail<?php echo $row['id']; ?>">مشاهده</button>
                                        <div id="detail<?php echo $row['id']; ?>" class="modal fade text-right" role="dialog" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                                        <h1 class="modal-title">جزئیات درخواست کاربر " <?php echo $username; ?> "</h1>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h2 style="font-weight: bold;">اطلاعات شخصی کاربر : </h2>
                                                        <p style="font-weight: bold;"><?php echo $username; ?></p>
                                                        <p style="font-weight: bold;"><?php echo $mail; ?></p>
                                                        <hr>
                                                        <h2 style="font-weight: bold;">صندوق درخواستی : </h2>
                                                        <p style="font-weight: bold;"><?php echo $inbox_name; ?></p>
                                                        <hr>
                                                        <h2 style="font-weight: bold;">تعداد سهم های درخواستی : </h2>
                                                        <p style="font-weight: bold;"><?php echo $request_amount; ?></p>
                                                        <hr>
                                                        <h2 style="font-weight: bold;">قیمت NAV در زمان درخواست : </h2>
                                                        <p style="font-weight: bold;"><?php echo number_format($row['nav'])." تتر"; ?></p>
                                                        <hr>
                                                        <?php if($row['type'] == "خرید (صدور)"){ ?>
                                                            <h2 style="font-weight: bold;">هزینه ابطال کل : </h2>
                                                            <p style="font-weight: bold;"><?php echo number_format($row['tax'])." تتر"; ?></p>
                                                            <hr>
                                                            <h2 style="font-weight: bold;">ترجیح خرید کاربر : </h2>
                                                            <p style="font-weight: bold;"><?php echo $row['other']; ?></p>
                                                            <hr>
                                                            <h2 style="font-weight: bold;">آدرس تراکنش : </h2>
                                                            <p style="font-weight: bold;"><?php echo $row['url']; ?></p>
                                                            <hr>
                                                            <h2 style="font-weight: bold;">عکس تراکنش : </h2>
                                                            <a href="../request-pics/<?php echo $row['pic']; ?>" target="_blank" ><img class="img-responsive" src="../request-pics/<?php echo $row['pic']; ?>" ></a>
                                                        <?php }else{ ?>
                                                            <h2 style="font-weight: bold;">ترجیح فروش کاربر : </h2>
                                                            <p style="font-weight: bold;"><?php echo $row['other']; ?></p>
                                                            <hr>
                                                            <h2 style="font-weight: bold;">آدرس والت انتخابی کاربر : </h2>
                                                            <p style="font-weight: bold;"><?php echo $wallet; ?></p>
                                                            <hr>
                                                            <h2 style="font-weight: bold;">آدرس رسید تراکنش : </h2>
                                                            <p style="font-weight: bold;"><?php echo $row['url']; ?></p>
                                                            <hr>
                                                            <h2 style="font-weight: bold;">عکس رسید تراکنش : </h2>
                                                            <a href="../request-pics/<?php echo $row['pic']; ?>" target="_blank" ><img class="img-responsive" src="../request-pics/<?php echo $row['pic']; ?>" ></a>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <p class="text-right">                                
                                                            <button type="button" class="btn btn-danger btn-lg btn-round" data-bs-dismiss="modal">بستن</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <?php if($row['status'] == "تایید شده"){ ?>
                                        <td class="text-center"><button class="btn btn-md btn-warning round" disabled>رسیدگی</button></td>
                                    <?php }else{ ?>
                                        <td class="text-center"><a href="?request=show&id=<?php echo $row['id']; ?>"><button class="btn btn-md btn-warning round">رسیدگی</button></a></td>
                                    <?php } ?>
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
            { "data": "address" },
            { "data": "inbox" },
            { "data": "num" },
            { "data": "requestDate" },
            { "data": "confirmDate" },
            { "data": "status" },
        ],
        "order": [[ 0, "desc" ]],
    "pageLength": 10
    });

    $(window).on( 'resize', function () {
        $('#data-table').css("width", "100%");
    } );
</script>
<?php } ?>