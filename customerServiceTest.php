<?php
/**
  * wechat php test
  */
require_once 'common.php';
require_once 'WeChat.class.php';
//define your token
define("TOKEN", "weixinwxl");
class wechatCallbackapiTest extends WeChat
{

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

          //extract post data
        if (!empty($postStr)){

                libxml_disable_entity_loader(true);
                //加载 postStr 字符串
                  $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                global $tmp_arr;
                //根据接收到的消息类型，来进行分支处理(switch)
                switch($postObj->MsgType)
                {

                    case 'text':
                        //回复文本模板

                        if($keyword == '微信连')
                        {
                            //获取token
                            require_once 'get_token.php';
                            //发送的内容
                                $contentStr = '微信连www.phpos.net';
                                //对发送的内容进行urlencode编码，防止中文乱码
                                $contentStr = urlencode($contentStr);
                                $content_arr = array('content' => "{$contentStr}");
                                $reply_arr = array('touser' => "{$fromUsername}", 'msgtype' => 'text', 'text' => $content_arr);
                            //编码成json格式
                            $post = json_encode($reply_arr);
                            //url解码
                            $post = urldecode($post);
                            $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
                            //这里我们使用类的继承机制，来简化代码.
                            $this->http_request($url, $post);
                            $this->http_request($url, $post);
                                                        $this->http_request($url, $post);

                        }else{
                            $contentStr = "您输入的格式不正确";
                            $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $contentStr);
                            echo $resultStr;
                        }
                        break;

                }
        }else {
            echo "";
            exit;
        }
    }

}

$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

?>
<?php
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