<?php
//引入回复消息的函数文件
require_once 'customer.php';

// //引入回复文本的函数文件
// require_once 'responseText.func.inc.php';
// //引入记录消息的函数文件
// require_once 'record_message.func.inc.php';

        $from_username = $_GET["fromusername"];
        $message = $_GET["message"];

?>
<form method="post" action="reply.php?action=reply">
    <dl>
        <dd><strong>收件人：</strong><input type="text" name="tousername" class="text" value="<?php echo $from_username?>" /></dd>
        <dd><strong>原消息：</strong><input type="text" name="message" class="text" value="<?php echo $message?>" /></dd>
        <dd><span><strong>内　容：</strong></span><textarea rows="5" cols="34" name="content"></textarea></dd>
        <dd><input type="submit" class="submit" value="回复消息" /></dd>
    </dl>
</form>

<?php

if(isset($_GET['action'])){

if($_GET['action'] == "reply"){

    $touser = $_POST['tousername'];
    $content = $_POST['content'];
    $result = _reply_customer($touser, $content);

    if($result["errcode"] == '0'){
        echo "<script> alert('消息回复成功！'); </script>";
    }
}

}
?>