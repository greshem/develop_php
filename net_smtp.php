<?php
require 'Net/SMTP.php';

$host = '192.168.10.245';//smtp��������ip������
$username= 'qianzj';//��½smtp���������û���
$password= '081943';//��½smtp������������
$from = 'arcow@126.com';   //˭�����ʼ�
$rcpt = array('test@test.com', 'arcow@126.com');//������������
$subj = "Subject: ����˭\n";//����
$body = "test it";//�ʼ�����

/* ����һ���� */
if (! ($smtp = new Net_SMTP($host))) {
    die("�޷���ʼ����Net_SMTP!\n");
}

/* ��ʼ����SMTP������*/
if (PEAR::isError($e = $smtp->connect())) {
    die($e->getMessage() . "\n");
}

/* smtp��Ҫ�����֤ */
$smtp->auth($username,$password,"PLAIN");

/*���÷��������� */
if (PEAR::isError($smtp->mailFrom($from))) {
    die("�޷����÷���������Ϊ <$from>\n");
}

/* ���ý����ʼ��� */
foreach ($rcpt as $to) {
    if (PEAR::isError($res = $smtp->rcptTo($to))) {
        die("�ʼ��޷�Ͷ�ݵ� <$to>: " . $res->getMessage() . "\n");
    }
}

/* ��ʼ�����ʼ����� */
if (PEAR::isError($smtp->data($subj . "\r\n" . $body))) {
    die("Unable to send data\n");
}

/* �Ͽ����� */
$smtp->disconnect();
echo "���ͳɹ���";
?>