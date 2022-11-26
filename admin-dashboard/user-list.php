<?php

if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
}
else{
    $sql = "SELECT * FROM users WHERE priv='user'";
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
                            لیست کاربران
                        </h1>
                    </div>
                </div><!-- /.portlet-heading -->
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">آی دی</th>
                                    <th class="text-center">نام</th>
                                    <th class="text-center">ایمیل</th>
                                    <th class="text-center">شماره تماس</th>
                                    <th class="text-center">درصد تکمیل پروفایل</th>
                                    <th class="text-center">تاریخ عضویت</th>
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
                                    <td class="text-center"><?php echo $row['tel']; ?></td>
                                    <td class="text-center"><?php echo $row['percentage']."%"; ?></td>
                                    <td class="text-center"><?php echo $formatter->format($row['reg_date']); ?></td>
                                    <td class="text-center"><a href="?user=show&mail=<?php echo $row['mail']; ?>"><button class="btn btn-md btn-warning round">مشاهده جزئیات کامل</button></a></td>
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
            { "data": "tel" },
            { "data": "p" },
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