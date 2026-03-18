let muted = true;

const button = document.getElementById("speakerbutton");
const icon = document.getElementById("speakericon");
const music = document.getElementById("bgmusic");

music.volume=0.3;

button.addEventListener("click", function() {

    if (muted) {
        icon.src = "speaker_50x50_45x45.png";
        music.play();
        muted = false;
    } else {
        icon.src = "mspeaker_45x45.png";
        music.pause();
        muted = true;
    }

});