<?php

if(!isset($_SESSION['manager_mail']) || $_SESSION['priv'] != "super-admin"){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $sql = "SELECT * FROM users WHERE priv='admin'";
    $res = mysqli_query($conn,$sql);
    $formatter = new IntlDateFormatter(
    "en_US@calendar=persian", 
    IntlDateFormatter::FULL, 
    IntlDateFormatter::FULL, 
    'Asia/Tehran', 
    IntlDateFormatter::TRADITIONAL, 
    "yyyy/MM/dd");

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
                            لیست مدیران
                        </h1>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <a href="?admin=add"><button class="btn btn-lg btn-round btn-primary">افزودن مدیر</button></a>
                    </div><!-- /.portlet-title -->
                </div><!-- /.portlet-heading -->
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">آی دی</th>
                                    <th class="text-center">نام</th>
                                    <th class="text-center">ایمیل</th>
                                    <th class="text-center">تاریخ افزودن</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($res)){ 
                                    ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['id']; ?></td>
                                    <td class="text-center"><?php echo $row['name']; ?></td>
                                    <td class="text-center"><?php echo $row['mail']; ?></td>
                                    <td class="text-center"><?php echo $formatter->format($row['reg_date']); ?></td>
                                    <td class="text-center">
                                        <form action="controllers/remove-admin.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button class="btn btn-lg round btn-danger" name="sb" type="submit">حذف</button>
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
            { "data": "date" },
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