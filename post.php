<?php
require 'vendor/autoload.php';

$team_id = validate_team_id($_REQUEST['team_id']);
$emotion_id = validate_emotion_id($_REQUEST['emotion_id']);
$emotion_rate = validate_emotion_rate($_REQUEST['emotion_rate']);

if($_REQUEST['random'] == 'true') {
$team_id = mt_rand(1, 2);
$emotion_id = mt_rand(1, 5);
$emotion_rate = mt_rand(0 ,100);

}

post_to_es($team_id, $emotion_id);
post_to_mysql($team_id, $emotion_id);

function post_to_es($team_id, $emotion_id) {
	$client = new Elasticsearch\Client();

	$params = array();
	$params['body']  = array(
			'team_id' => intval($team_id),
			'emotion_id' => intval($emotion_id),
                        'timestamp' => time() * 1000
			);
	$params['index'] = 'nuro-2014.11.16';
	$params['type']  = 'default';
	var_dump($params);
	$ret = $client->index($params);
}

function post_to_mysql($team_id, $emotion_id) {
	$dsn = 'mysql:dbname=nuro;host=localhost';
	$user = 'root';
	$password = 'rootpasswd';

	$dbh = new PDO($dsn, $user, $password);
	$sql = "INSERT INTO nurodata (team_id, emotion_id, post_datetime) VALUES($team_id, $emotion_id, now())";
	$dbh->query($sql);
}

function validate_team_id($team_id){
	if($team_id != 1 && $team_id != 2){
		echo "invalid team_id";
		var_dump($team_id);
		exit();
	} 
	return $team_id;
}

function validate_emotion_id($emotion_id){
	if($emotion_id != 1 && $emotion_id != 2 && $emotion_id != 3 && $emotion_id != 4 && $emotion_id != 5){
		echo "invalid emotion_id. emotion_id is set to default.";
		$emotion_id = 3;
		return $emotion_id;
	} 
	return $emotion_id;
}

function validate_emotion_rate($emotion_rate) {
	$emotion_rate = intval($emotion_rate);
	if($emotion_rate < 0 || $emotion_rate > 100) {
		$emotion_rate = 0;
	}
	return $emotion_rate;
}
