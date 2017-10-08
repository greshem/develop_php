<?php
require 'Net/SMTP.php';

$host = '192.168.10.245';//smtp服务器的ip或域名
$username= 'qianzj';//登陆smtp服务器的用户名
$password= '081943';//登陆smtp服务器的密码
$from = 'arcow@126.com';   //谁发的邮件
$rcpt = array('test@test.com', 'arcow@126.com');//可设多个接收者
$subj = "Subject: 你是谁\n";//主题
$body = "test it";//邮件内容

/* 建立一个类 */
if (! ($smtp = new Net_SMTP($host))) {
    die("无法初始化类Net_SMTP!\n");
}

/* 开始连接SMTP服务器*/
if (PEAR::isError($e = $smtp->connect())) {
    die($e->getMessage() . "\n");
}

/* smtp需要身份验证 */
$smtp->auth($username,$password,"PLAIN");

/*设置发送者邮箱 */
if (PEAR::isError($smtp->mailFrom($from))) {
    die("无法设置发送者邮箱为 <$from>\n");
}

/* 设置接收邮件者 */
foreach ($rcpt as $to) {
    if (PEAR::isError($res = $smtp->rcptTo($to))) {
        die("邮件无法投递到 <$to>: " . $res->getMessage() . "\n");
    }
}

/* 开始发送邮件内容 */
if (PEAR::isError($smtp->data($subj . "\r\n" . $body))) {
    die("Unable to send data\n");
}

/* 断开连接 */
$smtp->disconnect();
echo "发送成功！";
?>