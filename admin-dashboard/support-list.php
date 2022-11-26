<?php

if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $sql = "SELECT * FROM tickets t WHERE id=(SELECT Max(id) FROM tickets WHERE t.user = user)";
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
                            لیست تیکت ها
                        </h1>
                    </div>
                </div><!-- /.portlet-heading -->
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">تاریخ آخرین درخواست</th>
                                    <th class="text-center">نام کاربر</th>
                                    <th class="text-center">ایمیل کاربر</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($res)){ 
                                    if($row['status'] == "seen"){
                                        $class = "label-success";
                                        $status = "دیده شده";
                                    }
                                    elseif($row['status'] == "unseen"){
                                        $class = "label-danger";
                                        $status = "دیده نشده";
                                    }
                                    else{
                                        $class = "label-warning";
                                    }
                                    $username= "";
                                    $sql = "SELECT * FROM users WHERE mail=?";
                                    if(!mysqli_stmt_prepare($stmt , $sql)){
                                        echo "SQLNotPrepare";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($stmt , "s" , $row['user']);
                                        mysqli_stmt_execute($stmt);
                                        $res2 = mysqli_stmt_get_result($stmt);
                                        if($row2 = mysqli_fetch_assoc($res2)){
                                            $username = $row2['name'];
                                        }
                                    }
                                    $date = substr($row['date'],0,10);
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $date; ?></td>
                                    <td class="text-center"><?php echo $username; ?></td>
                                    <td class="text-center"><?php echo $row['user']; ?></td>
                                    <td class="text-center"><h2><span class="label <?php echo $class; ?>"><?php echo $status; ?></span></h2></td>
                                    <td class="text-center"><a href="?support=show&mail=<?php echo $row['user']; ?>"><button class="btn btn-md btn-warning round">مشاهده</button></a></td>
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
            { "data": "date" },
            { "data": "name" },
            { "data": "mail" },
            { "data": "status" },
            { "data": "operation" },
        ],
        "order": [[ 0, "desc" ]],
    "pageLength": 10
    });

    $(window).on( 'resize', function () {
        $('#data-table').css("width", "100%");
    } );
</script>
<?php } ?>