<?php

function errorMsg($msg) {
    header("Content-type: text/html; charset=utf-8");
    ?>
<script>
alert('<?php
    echo $msg;
    ?>');history.go(-1);
</script>
<?php
    die();
}

function succMsg($msg, $location) {
    header("Content-type: text/html; charset=utf-8");
    //header('location:'.$location );
    ?>
<script>
alert('<?php
    echo $msg;
    ?>');
window.location.href="<?php
    echo $location;
    ?>";
</script>
<?php
}

function getGender($no) {
    
    $genders = array(
        '未知', 
        '男', 
        '女'
    );
    return $genders[$no];
}

function myUrlEncode($string) {
    $entities = array(
        '%21', 
        '%2A', 
        '%27', 
        '%28', 
        '%29', 
        '%3B', 
        '%3A', 
        '%40', 
        '%26', 
        '%3D', 
        '%2B', 
        '%24', 
        '%2C', 
        '%2F', 
        '%3F', 
        '%25', 
        '%23', 
        '%5B', 
        '%5D', 
        '+'
    );
    $replacements = array(
        '!', 
        '*', 
        "'", 
        "(", 
        ")", 
        ";", 
        ":", 
        "@", 
        "&", 
        "=", 
        "+", 
        "$", 
        ",", 
        "/", 
        "?", 
        "%", 
        "#", 
        "[", 
        "]", 
        "%20"
    );
    return str_replace($entities, $replacements, urlencode($string));
}

function iaddslashes($data) {
    return is_array($data) ? array_map('iaddslashes', $data) : addslashes($data);
}

//入库前对数据进行处理
$_POST = iaddslashes($_POST);
$_GET = iaddslashes($_GET);