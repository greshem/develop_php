#2015_11_20   星期五   add by greshem

<?php
  
$options = array (
    'hostname' => '139.196.170.125',
);
  


$client = new SolrClient($options); // 参数4.0针对Solr4.x，其他版本时忽略
$doc = new SolrInputDocument();

$id= rand(1,10000);
  
$doc->addField('id', "id_".$id);
$doc->addField('question', 'quesiton');
$doc->addField('url', 'url');
$doc->addField('answers', 'answers1 answers2  answers3  ');

$response = $client->addDocument($doc);
  
$client->commit();


?> 
