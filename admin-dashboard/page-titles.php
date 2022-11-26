<?php

$site_title = "EMX";
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

if(empty($_GET)){
    echo "پیشخوان | $site_title";
}
elseif(isset($_GET['support']) && $_GET['support'] == "list"){
    echo "تیکت ها | $site_title";
}
elseif(isset($_GET['support']) && $_GET['support'] == "show"){
    echo "نمایش تیکت | $site_title";
}
elseif(isset($_GET['user']) && $_GET['user'] == "list"){
    echo "کاربران | $site_title";
}
elseif(isset($_GET['user']) && isset($_GET['mail']) && isset($_GET['cardex']) && $_GET['user'] == "show"){
    echo "کاردکس کاربر | $site_title";
}
elseif(isset($_GET['user'])  && $_GET['user'] == "show"){
    echo "جزئیات کاربر | $site_title";
}
elseif(isset($_GET['notification']) && $_GET['notification'] == "list"){
    echo "لیست اعلانات | $site_title";
}
elseif(isset($_GET['notification']) && $_GET['notification'] == "show"){
    echo "نمایش اعلان | $site_title";
}
elseif(isset($_GET['request']) && $_GET['request'] == "list"){
    echo "درخواست ها | $site_title";
}
elseif(isset($_GET['request']) && isset($_GET['id']) && $_GET['request'] == "show"){
    echo "رسیدگی به درخواست | $site_title";
}
elseif(isset($_GET['wallet']) && $_GET['wallet'] == "list"){
    echo "کیف پول ها | $site_title";
}
elseif(isset($_GET['setting']) && $_GET['setting'] == "nav"){
    echo "تنظیمات NAV | $site_title";
}
elseif(isset($_GET['setting']) && $_GET['setting'] == "tax"){
    echo "تنظیمات هزینه ابطال | $site_title";
}
elseif(isset($_GET['setting']) && $_GET['setting'] == "inbox"){
    echo "تنظیمات صندوق ها | $site_title";
}
elseif(isset($_GET['setting']) && $_GET['setting'] == "wallet"){
    echo "تنظیمات کیف پول ها | $site_title";
}
elseif(isset($_GET['admin']) && $_GET['admin'] == "list"){
    echo "مدیران | $site_title";
}
elseif(isset($_GET['admin']) && $_GET['admin'] == "add"){
    echo "افزودن مدیر | $site_title";
}

else{
    echo "صفحه پیدا نشد | $site_title";
}

?>