<?php

include ("vendor/jpgraph/jpgraph/lib/JpGraph/src/jpgraph.php");
include ("vendor/jpgraph/jpgraph/lib/JpGraph/src/jpgraph_bar.php");

$dsn = 'mysql:dbname=nuro;host=localhost';
$user = 'root';
$password = 'rootpasswd';

$dbh = new PDO($dsn, $user, $password);
$sql = "SELECT team_id, COUNT(*) as count FROM nurodata GROUP BY team_id";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$graphdata = array();

while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	array_push($graphdata, $result['count']);
}


$graphdata1 = $graphdata[0] / ($graphdata[0] + $graphdata[1]) * 100;
$graphdata2 = $graphdata[1] / ($graphdata[0] + $graphdata[1]) * 100;
$graphdata = array($graphdata1, $graphdata2);

plot_graph($graphdata);

function plot_graph($graphdata) {
	$graph = new Graph(800, 800, "auto"); 
	$graph->SetFrame(true);
	$graph->SetScale("textlin");

	$graph->Set90AndMargin(50,20,50,30);
	$graph->img->SetMargin(30, 30, 30, 30);

//var_dump($graphdata);

	$ydata1 = array(floor($graphdata[0]));
//var_dump($ydata1);
	$ydata2 = array(ceil($graphdata[1]));
//var_dump($ydata2);
//exit();

	$barplot1 = new BarPlot($ydata1);
	$barplot1->SetFillColor("orange");

	$barplot2 = new BarPlot($ydata2);
	$barplot2->SetFillColor("blue");

	$accbarplot = new AccBarPlot(array($barplot1, $barplot2));

	$graph->Add($accbarplot);

	$graph->Stroke();
}

