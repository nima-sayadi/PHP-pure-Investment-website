<?php
if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} else {
    $stmt = mysqli_stmt_init($conn);
    $id = $_GET['id'];
    $sql = "SELECT * FROM notifications WHERE id = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $msg = $row['msg'];
            $from = $row['from_who'];
        }
    }

?>
<div id="page-content">
    <div class="col-12">
        <div class="portlet box border shadow">
            <div class="portlet-heading">
                اعلان از " <?php echo $from; ?> " با آی دی " <?php echo $id; ?> "
            </div>
            <div class="portlet-body">
                <div>
                    <h3><?php echo $msg; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>