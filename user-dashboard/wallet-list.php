<?php

if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT * FROM wallets WHERE user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_SESSION['user_mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }


?>

<!-- BEGIN PAGE CONTENT -->
<div id="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="portlet box border shadow">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h1 class="title">
                            <i class="icon-frane"></i>
                            لیست کیف پول ها
                        </h1>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <a href="?wallet=add"><button class="btn btn-lg btn-round btn-primary">افزودن کیف پول جدید</button></a>
                    </div><!-- /.portlet-title -->
                </div><!-- /.portlet-heading -->
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">آی دی</th>
                                    <th class="text-center">آدرس کیف پول (Wallet Address)</th>
                                    <th class="text-center">شبکه</th>
                                    <th class="text-center">تاریخ ثبت</th>
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
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                    <td class="text-center"><?php echo $row['address']; ?></td>
                                    <td class="text-center"><?php echo $row['network']; ?></td>
                                    <td class="text-center"><?php echo $row['date']; ?></td>
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
            { "data": "address" },
            { "data": "net" },
            { "data": "date" },
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