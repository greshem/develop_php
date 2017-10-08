<?php
$url   =   "http://www.baidu.com";
//$url   =   "https://www.baidu.com";
  $page   =   "/news/";
 // $post_string   =   "xml   data";
                   //$header     =   "POST   ".$page."   HTTP/1.0   \r\n";
                   $header     =   "GET   ".$page."   HTTP/1.0   \r\n";
        //         $header   .=   "MIME-Version:   1.0   \r\n";
                $header   .=   "Content-type:   text/html   \r\n";
  //              $header   .=   "Content-length:   ".strlen($post_string)."   \r\n";
        //         $header   .=   "Content-transfer-encoding:   text   \r\n";
        //         $header   .=   "Request-number:   1   \r\n";
        //         $header   .=   "Document-type:   Request   \r\n";
        //         $header   .=   "Interface-Version:   Test   1.4   \r\n";
    //            $header   .=   "Connection:   close   \r\n\r\n";
      //          $header   .=   $post_string;
echo $url;
echo $header;
                $ch   =   curl_init();
                curl_setopt($ch,   CURLOPT_URL,$url);
                curl_setopt($ch,   CURLOPT_RETURNTRANSFER,   1);
                curl_setopt($ch,   CURLOPT_TIMEOUT,   10);
                curl_setopt($ch,   CURLOPT_CUSTOMREQUEST,   $header);
                $data   =   curl_exec($ch);
                if   (curl_errno($ch))   {
                        print   curl_error($ch);
                }   else   {
                        curl_close($ch);
                }
  echo   $data;
?>
