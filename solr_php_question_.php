#2015_11_20   ������   add by greshem

<?php
  
$options = array (
    'hostname' => '139.196.170.125',
);
  


$client = new SolrClient($options); // ����4.0���Solr4.x�������汾ʱ����
$doc = new SolrInputDocument();

$id= rand(1,10000);
  
$doc->addField('id', "id_".$id);
$doc->addField('question', 'quesiton');
$doc->addField('url', 'url');
$doc->addField('answers', 'answers1 answers2  answers3  ');

$response = $client->addDocument($doc);
  
$client->commit();


?> 
