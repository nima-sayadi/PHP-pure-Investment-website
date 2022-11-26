<?php
if(!isset($_SESSION['user_mail'])){ 
    echo "<div style='margin:auto;width:max-content;color:red;font-family:IRANSans;margin-top:30px'>Oops! Access denied ! | اینجا چیکار میکنی ؟! برو خدا روزیت رو یه جای دیگه بده</div>";
    exit();
} else { 
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
    ?>
    <style>
        .heading-title
        {
            margin-bottom: 100px;
        }
        .pricingTable{
            border: 1px solid #dbdbdb;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.14);
            border-radius: 10px;
            text-align: center;
        }

        p{
            text-align:justify;
            padding: 20px;
        }

        .pricingTable .pricingTable-header{
            background-color: #f5f5f5;
            color:#fff;
        }

        .pricingTable-header .heading{
            background-color: #13a2a6;
            display: block;
            padding: 15px 10px;
            transition:0.4s ease-in-out;
        }

        .pricingTable:hover .heading{
            background-color: #419e00;
        }

        .pricingTable .heading h3{
            font-weight:bold;
            margin: 0;
            text-transform: uppercase;
        }

        .pricingTable-header .price-value {
            display: block;
            font-size: 25px;
            font-weight: 800;
            color: #474747;
            line-height: 35px;
            margin-top: 10px;
            padding: 20px 10px 0;
        }

        .pricingTable .price-value span{
            font-size: 60px;
            font-weight: 100;
        }

        .pricingTable .subtitle{
            font-size: 13px;
            color: #262626;
            margin-top: 15px;
            display: block;
        }

        .pricingTable .pricingContent ul{
            list-style: none;
            padding: 0;
            margin-bottom: 0;
        }

        .pricingTable .pricingContent ul li{
            border-top: 1px solid #dbdbdb;
            padding: 10px 0;
            background-color: #f5ffff;
        }

        .pricingTable .pricingContent ul li:nth-child(odd) {
            background-color: #fff;
        }

        .pricingContent ul li:last-child{
            border-bottom: 1px solid #dbdbdb;
        }

        .pricingTable .pricingTable-sign-up{
            padding: 25px 0;
        }

        .pricingTable .btn-block{
            background: #13a647;
            border:0px none;
            border-radius: 5px;
            color:#fff;
            width: 50%;
            padding: 10px 5px;
            margin: 0 auto;
            transition:0.3s ease;
        }

        .pricingTable .btn-block:before{
            content: "\f155";
            font-family: 'FontAwesome';
            font-size: 15px;
            padding-left: 10px;
        }

        .pricingTable .bsecond{
            background: #368279;
        }

        .pricingTable .bsecond:before{
            content: "\f1fe";
            font-family: 'FontAwesome';
            font-size: 15px;
            padding-left: 10px;
        }

        .pricingTable .btn-block:hover{
            background: #419e00;
            color:#fff;
        }

        @media screen and (max-width:990px){
            .pricingTable{
                margin-bottom: 20px;
            }
        }

        @media screen and (max-width:1023px){
            .lf{
                padding-top: 0 !important;
            }
        }

    </style>
    <div id="page-content">
    <div class="container">
            
            <div class="portlet box border text-center shadow m-auto m-b-20 col-md-6">
                <h1>صندوق های سرمایه گذاری</h1>
            </div>
            

            <div class="row user-select-none justify-content-center">

                <div class="col-md-10 col-sm-12 mb-3">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <span class="heading">
                                <h3><?php echo $inbox1_name; ?></h3>
                            </span>
                        </div>

                        <div class="pricingContent">
                            <ul>
                                <li><p><b>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</b></p></li>
                            </ul>
                        </div>
                        <div class="row justify-content-between">
                            <div class="pricingTable-sign-up col-md-6 col-sm-12">
                                <a href="?request=buy" class="btn btn-block btn-success">درخواست خرید</a>
                            </div>
                            <div class="pricingTable-sign-up lf col-md-6 col-sm-12">
                                <a href="?inbox=inbox1" class="btn btn-block bsecond btn-default">جزئیات / نمودار</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 col-sm-12 mb-3">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <span class="heading">
                                <h3><?php echo $inbox2_name; ?></h3>
                            </span>
                        </div>

                        <div class="pricingContent">
                            <ul>
                                <li><p><b>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</b></p></li>
                            </ul>
                        </div>

                        <div class="row justify-content-between">
                            <div class="pricingTable-sign-up col-md-6 col-sm-12">
                                <a href="?request=buy" class="btn btn-block btn-success">درخواست خرید</a>
                            </div>
                            <div class="pricingTable-sign-up lf col-md-6 col-sm-12">
                                <a href="?inbox=inbox2" class="btn btn-block bsecond btn-default">جزئیات / نمودار</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 col-sm-12 mb-3">
                    <div class="pricingTable">
                        <div class="pricingTable-header">
                            <span class="heading">
                                <h3><?php echo $inbox3_name; ?></h3>
                            </span>
                        </div>

                        <div class="pricingContent">
                            <ul>
                                <li><p><b>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد، در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها، و شرایط سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</b></p></li>
                            </ul>
                        </div>

                        <div class="row justify-content-between">
                            <div class="pricingTable-sign-up col-md-6 col-sm-12">
                                <a href="?request=buy" class="btn btn-block btn-success">درخواست خرید</a>
                            </div>
                            <div class="pricingTable-sign-up lf col-md-6 col-sm-12">
                                <a href="?inbox=inbox3" class="btn btn-block bsecond btn-default">جزئیات / نمودار</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
