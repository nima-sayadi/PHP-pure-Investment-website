<?php

if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $stmt = mysqli_stmt_init($conn);
    $sql = "SELECT * FROM wallets ";
    $res = mysqli_query($conn,$sql);


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
                </div><!-- /.portlet-heading -->
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">آی دی</th>
                                    <th class="text-center">نام کاربر</th>
                                    <th class="text-center">ایمیل کاربر</th>
                                    <th class="text-center">آدرس کیف پول</th>
                                    <th class="text-center">تاریخ ثبت</th>
                                    <th class="text-center">وضعیت</th>
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
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                    <td class="text-center"><?php echo $username; ?></td>
                                    <td class="text-center"><?php echo $mail; ?></td>
                                    <td class="text-center">
                                    <button class="btn btn-md btn-secondary round" data-bs-toggle="modal" data-bs-target="#detail<?php echo $row['id']; ?>">مشاهده</button>
                                        <div id="detail<?php echo $row['id']; ?>" class="modal fade text-right" role="dialog" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                                        <h1 class="modal-title">آدرس کیف پول کاربر " <?php echo $username; ?> "</h1>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p style="font-weight: bold;word-break:break-all;text-align:center"><?php echo $row['address']; ?></p>
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
                                    <td class="text-center"><?php echo $row['date']; ?></td>
                                    <td class="text-center"><h1><span class="label <?php echo $class; ?>"><?php echo $row['status']; ?></span></h1></td>
                                    <td class="text-center">
                                        <form action="controllers/wallet-handle.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="mail" value="<?php echo $mail; ?>">
                                            <button class="btn btn-md btn-success round" name="confirm" type="submit">تایید کردن</button>
                                            <button class="btn btn-md btn-danger round" name="deny" type="submit">رد کردن</button>
                                        </form>
                                    </td>
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
            { "data": "name" },
            { "data": "mail" },
            { "data": "address" },
            { "data": "date" },
            { "data": "status" },
            { "data": "op" },
        ],
        "order": [[ 0, "desc" ]],
    "pageLength": 10
    });

    $(window).on( 'resize', function () {
        $('#data-table').css("width", "100%");
    } );
</script>
<?php } ?>