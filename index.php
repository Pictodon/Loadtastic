<?php
	require_once('auth/api.php');
	$apikey = $api_secure;

	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url_test = $url . "?steamid=76561198019896324";
	$url_game = $url . "?steamid=%s";

	if (empty($_GET["steamid"])) {
		die("For testing purposes<br>
		<a href='$url_test'>$url_test</a><br>

		Set this URL in your server.cfg<br>
		<a href='$url_game'>$url_game</a>");
	}

	$steamid64 = $_GET["steamid"];
	$accountID = bcsub($steamid64, '76561197960265728');
	$steamid = 'STEAM_0:'.bcmod($accountID, '2').':'.bcdiv($accountID, 2);

	$url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . $apikey . "&steamids=" . $steamid64;
	$json = @file_get_contents($url);
	$json_decoded = json_decode($json, true);
	$table = $json_decoded["response"]["players"][0];

	$username = $table['personaname'];
	if (strlen($username) >= 16)
		$username = substr($username, 0, 16).'...';
?>

<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Loadtastic</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	    <script src="scripts/rainbowvis.js"></script>
		<script src="scripts/center.js"></script>
	</head>
	
	<body>
	    <div id="container">
	        <div id="top-content">
	        	<p id="servername">Servername</p>
	        </div>

	    	<div id="floating-content">
		    	<div id="left-content" class="panel">
					<img src="<?php echo $table['avatarfull'] ?>"/>
					
					<div id="info">
						<h1><?php echo $username ?></h1>
						<p><?php echo $steamid ?></p>
					</div>
				</div>

				<div id="right-content" class="panel">
					<p id="gamemode">Gamemode</p>
            		<p id="mapname">Map name</p>
				</div>
			</div>

	    	<div id="content" class="panel">
		        <p id="percentage"></p>
		        <p id="download-item">Connecting...</p>
	      	</div>
	      	<div id="bar-container">
	        	<div id="bar"></div>
	       	</div>
	    
	    </div>

	    <script src="scripts/fetch_data.js"></script>
	</body>
</html>
