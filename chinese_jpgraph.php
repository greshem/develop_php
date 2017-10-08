<?php
include ("lib/jpgraph/src/jpgraph.php");
include ("lib/jpgraph/src/jpgraph_bar.php");
// Some data
$databary=array(152,7,16,5,7,14,9,3);
$databarx= array("中文","德文", 'hi', 'd','dddd','a','b','e') ;
// New graph with a drop shadow
$graph = new Graph(300,200,'auto');
// Use a "text" X-scale
$graph->SetScale("textlin");
/**
 * X坐标的内容
 */
$graph->xaxis->SetTickLabels($databarx);
//$graph->xaxis->SetTextLabelInterval(3);
$graph->xaxis->SetFont(FF_SIMSUN,FS_NORMAL);
// Set title and subtitle
$graph->title->Set("测试数据");
// Use built in font
/**
 * 使用中文字体支持中文的显示
 */
$graph->title->SetFont(FF_SIMSUN,FS_BOLD,14);
// create the bar plot
$b1 = new BarPlot($databary);
/**
 * 这个是 图例
 */
$b1->SetLegend("Temperature");
/**
 * 这个是 柱状的宽度
 */
$b1->SetAbsWidth(6);

$graph->Add($b1);
// Finally output the image
$graph->Stroke();
?> 