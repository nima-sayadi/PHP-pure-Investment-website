<?php
if(!isset($_SESSION['manager_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} elseif(isset($_GET['mail'])) {
    $sql = "SELECT * FROM tickets WHERE user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_GET['mail']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_user = mysqli_stmt_num_rows($stmt);
    }
    if($num_user > 0){

    
    $new = "seen";
    $sql = "UPDATE tickets SET status = ? WHERE user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "ss" , $new,$_GET['mail']);
        mysqli_stmt_execute($stmt);
    }
    $sql = "SELECT * FROM users WHERE mail = ?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_GET['mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($res)){
            $name = $row['name'];
        }
    }
    $sql = "SELECT * FROM tickets WHERE user=?";
    if(!mysqli_stmt_prepare($stmt , $sql)){
        echo "SQLNotPreapred";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt , "s" , $_GET['mail']);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
    }

    ?>
    <div id="page-content">
        <?php if(isset($_GET['error']) && $_GET['error'] == "emptyField") { ?>
            <script>
                setTimeout(() => {
                    document.querySelector(".alert.alert-danger").style.display = "none";
                }, 10000);
            </script>
            <div class="alert alert-danger fill center text-center mb-4 font-weight-bold" role="alert">
                پر کردن فیلد پیغام ضروریست !
            </div>
        <?php } ?>
        <div class="row">                                   
            <div class="col-lg-12">
                <div class="portlet box border shadow">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">                                        
                                <i class="icon-support"></i>
                                تیکت کاربر " <?php echo $name; ?> "
                            </h3>
                        </div><!-- /.portlet-title -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2 chat-box">
                                <ul class="chat" style="overflow-y:scroll;max-height:350px">

                                    <li class="user">
                                        <div class="message">
                                            <div class="content">
                                                درود بر شما ، <br> شما میتوانید در این بخش با ما ارتباط برقرار کنید.
                                            </div><!-- /content -->
                                            <hr>
                                            <span class="sender-name">
                                            پشتیبانی    
                                            </span>
                                        </div><!-- /message -->
                                    </li>

                                    <?php
                                        while($row = mysqli_fetch_assoc($res)){
                                    ?>

                                    <li class="<?php if($row['from_status'] == "user"){echo "other";}else{echo "self";} ?>">
                                        <div class="message">
                                            <div class="content">
                                                <?php echo $row['msg']; ?>
                                            </div><!-- /content -->
                                            <hr>
                                            <?php if(!empty($row['file'])){ ?>
                                            <a href="../attachments/<?php echo $row['file']; ?>" download><button class="btn btn-round btn-success btn-md" style="width:100%">دانلود فایل ضمیمه</button></a>
                                            <?php } ?>
                                            <span class="sender-name">
                                                <?php if($row['from_status'] == "user"){echo $name;}else{echo "پشتیبانی";} ?>
                                            </span>
                                            <time>، <?php echo $row['date']; ?></time>
                                        </div><!-- /message -->
                                    </li>

                                    <?php } ?>
                                </ul>
                                <hr class="text-primary">
                                <form class="center-block" action="controllers/ticket-handle.php" enctype="multipart/form-data" method="POST">
                                <div class="form-group">
                                    <!-- <div class="input-group m-b-10">
                                        <span class="input-group-addon">
                                            <i class="icon-bubble"></i>
                                        </span>
                                        <input class="form-control" type="text" name="title" placeholder="عنوان پیغام">
                                    </div> -->
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="icon-speech"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" name="msg" placeholder="پیغام خود را اینجا بنویسید ..."></textarea>
                                    </div>
                                    <div class="input-group mt-3">
                                        <input type="file" name="attachment" class="form-control"> 
                                        <div class="input-group round"> 
                                            <input type="text" class="form-control file-input" placeholder="برای آپلود کلیک کنید"> 
                                            <span class="input-group-btn"> 
                                                <button type="button" class="btn btn-info"> 
                                                    <i class="icon-pin"></i>
                                                    ضمیمه کردن فایل
                                                </button>
                                            </span> 
                                        </div>
                                    </div>
                                    <p class="m-t-20">
                                        <input type="hidden" name="user-mail" value="<?php echo $_GET['mail']; ?>">
                                        <button class="btn btn-info btn-block" type="submit" name="sb">
                                            ارسال پیغام
                                        </button>
                                    </p>
                                </div>
                                </form>
                            </div><!-- /.col-sm-8 -->
                        </div><!-- /.row -->
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div><!-- /.col-lg-12 -->                    
        </div><!-- /.row -->
    </div>
<script>
    var element = document.querySelector(".chat");
    element.scrollTop = element.scrollHeight;
</script>
<?php } } ?>
