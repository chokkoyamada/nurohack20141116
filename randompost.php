<?php
require 'vendor/autoload.php';

$client = new Elasticsearch\Client();

$params = array();
$params['body']  = array('team_id' => mt_rand(1, 2), 'emotion_id' => mt_rand(1, 5));
$params['index'] = 'nuro-2014.11.16';
$params['type']  = 'default';
$ret = $client->index($params);
