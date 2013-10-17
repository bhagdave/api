// JS
document.addEventListener("DOMContentLoaded", function(){initialiseMediaPlayer();},false);
var mediaPlayer;
function initialiseMediaPlayer(){
	mediaPlayer = document.getElementById('media-video');
	mediaPlayer.controls = false;
	mediaPlayer.addEventListener('timeupdate',updateProgressBar,false);
	mediaPlayer.addEventListener('play',function(){
		var btn = document.getElementById('play-pause-button');
		changeButtonType(btn,'Pause');
	},false);
	mediaPlayer.addEventListener('pause',function(){
		var btn = document.getElementById('play-pause-button');
		changeButtonType(btn,'Play');
	},false);
}
function togglePlayPause(){
	var btn = document.getElementById('play-pause-button');
	if (mediaPlayer.paused || mediaPlayer.ended){
		changeButtonType(btn,'Pause');
		mediaPlayer.play();
	}
	else {
		changeButtonType(btn,'Play');
		mediaPlayer.pause();	
	}
}
function changeButtonType(btn, value){
		btn.title = value;
		btn.innerHTML = value;
		btn.className =  value;
}
function stopPlayer(){
	mediaPlayer.pause();
	mediaPlayer.currentTime =0;
}
function changeVolume(direction){
	if (direction === '+'){
		mediaPlayer.volume += mediaPlayer.volume == 1 ? 0: 0.1;
	} else {
		mediaPlayer.volume -= mediaPlayer.volume == 0 ? 0: 0.1;
	}
	mediaPlayer.volume = parseFloat(mediaPlayer.volume).toFixed(1);
}
function toggleMute(){
	var btn = document.getElementById('mute-button');
	if (mediaPlayer.muted){
		changeButtonType(btn,'Mute');
		mediaPlayer.muted = false;
	}
	else {
		changeButtonType(btn,'UnMute');
		mediaPlayer.muted = true;	
	}
}
function replayMedia(){
	resetPlayer();
	mediaPlayer.play();
}
function resetPlayer(){
	var btn = document.getElementById('play-pause-button');
	mediaPlayer.currentTime = 0;
	changeButtonType(btn,'Play');
}

function updateProgressBar(){
	var progressBar = document.getElementById('progress-bar');
	var percentage  = Math.floor((100 / mediaPlayer.duration) * mediaPlayer.currentTime);
	progressBar.value = percentage;
	progressBar.innerHTML - percentage + '% played';
}
