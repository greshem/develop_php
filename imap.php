<?php
#imap_mailboxmsginfo

$userid = "kennychien";
$passwd = "kennychien123456";
$mb = imap_open("{mail.emotibot.com.cn:143}INBOX", $userid, $passwd);
if (!imap_ping($mb)) 
{
  imap_reopen($mb, $userid, $passwd);
}

print_r(imap_mailboxmsginfo($mb));


imap_close($mb);

?>
