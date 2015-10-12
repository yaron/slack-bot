<?php
require __DIR__ . '/vendor/autoload.php';
use WebSocket\Client;

$welcome_data = 'Welcome to the oneshoe slack channels. These channels are not official and not administrated by oneshoe management. '
. '\n*Please keep passwords and other sensitive information off these channels!*'
. '\nThese channels are meant for sharing information, interesting links and sending gifs (try /giphy  in the #gif channel ;))!'
. '\nAlso, to check who has to fetch beer, type \"beer\" in any channel on a friday.';

$return = slack_api('rtm.start', array(   
  'no_unreads' => true,
));
$return = json_decode($return);
$url = $return->url;

$client = new Client($url);
$id = 1;
//Start with a ping so we can ping again once we get the pong.
$client->send('{"id": ' . $id++ . ', "type": "ping"}');	
while(true) {
  sleep(2);
  $return = $client->receive();
  $data = json_decode($return);
  
  if ($data && isset($data->type)) {
    if ($data->type == 'team_join') {
	  $channel = slack_api('im.open', array('user' => $data->user->id));
	  $channel = json_decode($channel);
	  sleep(5);
	  $client->send('{"text": "' . $welcome_data . '", "channel": "' . $channel->channel->id . '", "id": ' . $id++ . ', "type": "message"}');	
	}
	// Only send a ping, if we have a pong. That way we won't create a long queue of pongs when stuff happens.
	elseif ($data->type == 'pong') {
	  $client->send('{"id": ' . $id++ . ', "type": "ping"}');	
	}
	else {
	  echo $data->type . PHP_EOL;
	}
  }
}

function slack_api($method, $data) {
  $url = 'https://slack.com/api/' . $method;
  $data['token'] = get_conf('token');
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, 1);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $return = curl_exec($ch);
  curl_close($ch);

  return $return;
}

function get_conf($key) {
  require_once('config.php');
  return isset($config[$key]) ? $config[$key] : NULL;
}
