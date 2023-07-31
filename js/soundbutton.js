// Sound Button
// Get a reference to the button and the audio element
var button = document.getElementById('header-info-right-login');
var audio = document.getElementById('mySound2');
//
var button = document.getElementById('joinchat-button');
var audio = document.getElementById('mySound');

// Add an event listener to the button
button.addEventListener('click', function() {
// Play the audio
audio.play();
});