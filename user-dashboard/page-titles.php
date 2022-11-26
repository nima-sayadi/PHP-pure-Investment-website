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
elseif(isset($_GET['inbox']) && $_GET['inbox'] == "list"){
    echo "صندوق های سرمایه گذاری | $site_title";
}
elseif(isset($_GET['inbox']) && $_GET['inbox'] == "inbox1"){
    echo "$inbox1_name | $site_title";
}
elseif(isset($_GET['inbox']) && $_GET['inbox'] == "inbox2"){
    echo "$inbox2_name | $site_title";
}
elseif(isset($_GET['inbox']) && $_GET['inbox'] == "inbox3"){
    echo "$inbox3_name | $site_title";
}
elseif(isset($_GET['notification']) && $_GET['notification'] == "list"){
    echo "لیست اعلانات | $site_title";
}
elseif(isset($_GET['notification']) && $_GET['notification'] == "show"){
    echo "نمایش اعلان | $site_title";
}
elseif(isset($_GET['wallet']) && $_GET['wallet'] == "list"){
    echo "لیست کیف پول ها | $site_title";
}
elseif(isset($_GET['wallet']) && $_GET['wallet'] == "add"){
    echo "افزودن کیف پول | $site_title";
}
elseif(isset($_GET['request']) && $_GET['request'] == "list"){
    echo "لیست درخواست های خرید/فروش | $site_title";
}
elseif(isset($_GET['request']) && $_GET['request'] == "buy"){
    echo "درخواست خرید | $site_title";
}
elseif(isset($_GET['request']) && $_GET['request'] == "sell"){
    echo "درخواست فروش | $site_title";
}
elseif(isset($_GET['cardex']) && $_GET['cardex'] == "list"){
    echo "صندوق های من | $site_title";
}
elseif(isset($_GET['cardex']) && $_GET['cardex'] == "inbox1"){
    echo "کاردکس $inbox1_name | $site_title";
}
elseif(isset($_GET['cardex']) && $_GET['cardex'] == "inbox2"){
    echo "کاردکس $inbox2_name | $site_title";
}
elseif(isset($_GET['cardex']) && $_GET['cardex'] == "inbox3"){
    echo "کاردکس $inbox3_name | $site_title";
}
elseif(isset($_GET['profile'])){
    echo "پروفایل کاربری | $site_title";
}
elseif(isset($_GET['support'])){
    echo "پشتیبانی | $site_title";
}
else{
    echo "صفحه پیدا نشد | $site_title";
}

?>