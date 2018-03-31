var needed_files = 0;
var total_files = 0;
var downloading_file = false;

var difference = 0;
var percentage = 0;

var rainbow = new Rainbow();
var colors = new Array();

function SetFilesNeeded(needed) {
	needed_files = needed;
}

function SetFilesTotal(total) {
	total_files = total;
}

function DownloadingFile(filename) {
	if (downloading_file)
		needed_files -= 1;

	$('#download-item').text(filename);
	downloading_file = true;
	Refresh();
}

function SetStatusChanged(status) {
	if (downloading_file) {
		needed_files -= 1;
		downloading_file = false;
	}

	$('#download-item').text(status);
	Refresh();
}

function GenerateColors() {
	var numberOfItems = 100; 
	rainbow.setNumberRange(1, numberOfItems);
	rainbow.setSpectrum('#914a00', '#430039', '#0d0161');

	for (var i = 1; i <= numberOfItems; i++)
	    colors.push(rainbow.colourAt(i));
}
GenerateColors();

function Refresh() {
	difference = total_files - needed_files;
	percentage = Math.round(difference / total_files * 100);
		
	$('#percentage').text(percentage + '%');
	$('body').css('background-color', colors[percentage - 1]);
	$('#bar').css('width', percentage + '%');
	
	if (total_files > 0)
		$('#percentage').css('visibility', 'visible');
	else {
		$('#percentage').css('visibility', 'hidden');
		$('#percentage').css('margin-right', 0);
		$('#percentage').text('');
	}
}
Refresh();

function GameDetails(servername, serverurl, mapname, maxplayers, steamid, gamemode) {
	switch(gamemode.toLowerCase()) {
		case 'darkrp':
        case 'darkrp-master':
        case 'darkrp':
        	gamemode = 'Dark RP';
        	break;
        case 'ttt':
        case 'terrortown':
        	gamemode = 'Trouble in Terrorist Town';
        	break;
        default:
        	gamemode = gamemode.charAt(0).toUpperCase() + gamemode.slice(1);
	}

	$('#servername').text(servername.length > 35 ? servername.substr(0, 35) + '...' : servername);
	$('#gamemode').text(gamemode);
	$('#mapname').text('on ' + mapname);
}