<?php
header('Content-Type: text/html; charset=UTF-8');

function _reply_customer($touser,$content){
	
	//更换成自己的APPID和APPSECRET 
	$APPID='wxd19dff706393a011';
	$APPSECRET='82827388ebc129585cca5ec213c772bd';

	$TOKEN_URL='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$APPSECRET;

	$json=file_get_contents($TOKEN_URL);
	$result=json_decode($json);

	$ACC_TOKEN=$result->access_token;


//根据全局access_token和openid查询用户信息
$get_user_info_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$ACC_TOKEN.'&openid='.$touser.'&lang=zh_CN';
$userinfo = json_decode(file_get_contents($get_user_info_url));

//打印用户信息
//print_r($userinfo);
//print_r($userinfo->nickname);

	$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$ACC_TOKEN;
	$data = array(
        'touser'=>$touser,
        'template_id'=>'hTio3FaMQLYnclHdiFBz-uy16WfNxpE6dV1KtFRuI6Y',
        'url'=>'http://127.0.0.1/login.php',
        'msgtype'=>'text',
        'topcolor'=>'#7b68ee',
        'data' => array(
            'first' => array(
                'value' => $userinfo->nickname.'你好，最近上课时遇到什么疑问了吗？我是张老师。',
                'color' => '#FF0000'
            ),
            'keyword2' => array(
                'value' => $content,
                'color' => '#FF0000'
            ),
            'remark' => array(
                'value' => '请您务必准时到场！',
                'color' => '#FF0000'
            )
        )
    );

	$result = https_post($url,$data);

	echo $result;

	return json_decode($result,true);
}

function https_post($url,$data){
    $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
    $data=json_encode($data);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if(!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
    $outputs = curl_exec($curl);
    if (curl_errno($curl)) {
       return 'Errno'.curl_error($curl);
    }
    curl_close($curl);
    return $outputs;
}

?>