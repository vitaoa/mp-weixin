<?php
header('content-type:text/html;charset=utf-8');

//require_once 'wechat.class.php';
//require_once 'common.php';
//define your token
define("TOKEN", "weixin");

    $tmp_arr = array(
    'text' => <<<XML
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>0</FuncFlag>
</xml>
XML

);

$wechatObj = new wechatCallbackapiTest();

if (!isset($_GET['echostr'])) {
  $wechatObj->responseMsg();
}else{
  $wechatObj->valid();
}
class wechatCallbackapiTest{
    //验证消息
    public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
          echo $echoStr;
          exit;
        }
    }
    //检查签名
    private function checkSignature(){
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
    }

    //回复消息
    public function responseMsg(){
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents("php://input");

print_r($postStr);
echo '=======$postStr</br>';
        if (!empty($postStr)){
            libxml_disable_entity_loader(true);

            //$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
//            echo $postObj;

            //转换为simplexml对象
            $postObj = simplexml_load_string($postStr);

            $fromUsername = trim($postObj->FromUserName);
            $toUsername = trim($postObj->ToUserName);
            $keyword = trim($postObj->Content);
            $time = time();
            global $tmp_arr;
            if(!empty( $keyword )){
                //发送的内容
                $contentStr = 'Welcome to wechat world。。。。。!';
                //对发送的内容进行urlencode编码，防止中文乱码
                $contentStr = urlencode($contentStr);
                $content_arr = array('content' => $contentStr);

                $reply_arr = array('touser' => $fromUsername, 'msgtype' => 'text', 'text' => $content_arr);

                //编码成json格式
                $post = json_encode($reply_arr);
                echo "<br>&&&&&&&&&&&&&&post&&&<br>";
                print_r($post);
                //url解码
                $post = urldecode($post);


                $APPID='wxd19dff706393a011';
                $APPSECRET='82827388ebc129585cca5ec213c772bd';

                $TOKEN_URL='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$APPSECRET;
                $json=file_get_contents($TOKEN_URL);
                $result=json_decode($json);
                $access_token=$result->access_token;

                $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
                //这里我们使用类的继承机制，来简化代码.
                $this->http_request($url, $post);
            }else{
                $contentStr = "您输入的格式不正确";
                $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $contentStr);
                echo $resultStr;
            }
        }else {
            echo "";
            exit;
        }
    }
    public function http_request($url,$data){
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
         if(!empty($data)){
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         }
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
echo '<br/>#####url###########</br>';
echo $url;
echo '<br/>#####data###########</br>';
echo $data;
         $output = curl_exec($ch);
         curl_close($ch);
echo '*******$output</br>';
         echo $output;
         return json_decode($output, true);

    }

}

?>
