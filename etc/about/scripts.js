const playlist = [
  { title: "Deal In Wit Stress – onefang", url: "https://cdn.glitch.global/11dcdd8b-4c3e-419a-95ff-597c381ec1a4/SpotifyMate.com%20-%20dealin%20wit%20stress_%20-%20onefang.mp3?v=1745344109444" },
  { title: "Whats up - Astrid, Issbrokie", url: "https://cdn.glitch.global/5970b456-17e9-4f56-b0f2-46f0d4636862/Whats%20Up%20-%20Astrid%20Issbrokie.mp3?v=1745345033951" },
  { title: "Audition - Who Who", url: "https://cdn.glitch.global/5970b456-17e9-4f56-b0f2-46f0d4636862/Audition%20-%20Who%20Who.mp3?v=1745411534137" }
];

const audio = document.getElementById("audio");
const playlistEl = document.getElementById("playlist");

playlist.forEach((song, idx) => {
  const li = document.createElement("li");
  li.textContent = song.title;
  li.addEventListener("click", () => loadTrack(idx));
  playlistEl.appendChild(li);
});

let currentTrackIndex = null;

function getRandomTrackIndex(excludeIndex) {
  let index;
  do {
    index = Math.floor(Math.random() * playlist.length);
  } while (index === excludeIndex);
  return index;
}

function loadTrack(index) {
  currentTrackIndex = index;
  audio.src = playlist[index].url;
  audio.play();
  updateSelection(index);
}

function updateSelection(selectedIndex) {
  Array.from(playlistEl.children).forEach((li, idx) => {
    li.classList.toggle("selected", idx === selectedIndex);
  });
}

loadTrack(getRandomTrackIndex(null));

audio.addEventListener("ended", () => {
  const nextIndex = getRandomTrackIndex(currentTrackIndex);
  loadTrack(nextIndex);
});

const canvas = document.getElementById("oscilloscope");
const ctx = canvas.getContext("2d");
audio.crossOrigin = "anonymous";

const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
const analyser = audioCtx.createAnalyser();
analyser.fftSize = 2048;

const bufferLength = analyser.fftSize;
const dataArray = new Uint8Array(bufferLength);

const source = audioCtx.createMediaElementSource(audio);
source.connect(analyser);
analyser.connect(audioCtx.destination);

function resizeCanvas() {
  canvas.width = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
}
resizeCanvas();
window.addEventListener("resize", resizeCanvas);

function draw() {
  requestAnimationFrame(draw);
  analyser.getByteTimeDomainData(dataArray);
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.strokeStyle = "rgba(255,255,102,0.8)";
  ctx.lineWidth = 5;
  ctx.beginPath();
  const sliceWidth = canvas.width / bufferLength;
  let x = 0;
  for (let i = 0; i < bufferLength; i++) {
    const v = dataArray[i] / 128.0;
    const y = (v * canvas.height) / 2;
    i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
    x += sliceWidth;
  }
  ctx.lineTo(canvas.width, canvas.height / 2);
  ctx.stroke();
}

audio.onplay = () => {
  if (audioCtx.state === "suspended") audioCtx.resume();
  draw();
};

const navLink2 = document.getElementById("navLink2");
const overlay = document.getElementById("iframeOverlay");
const closeBtn = document.getElementById("closeOverlay");

navLink2.addEventListener("click", e => {
  e.preventDefault();
  overlay.style.display = "block";
});
closeBtn.addEventListener("click", () => {
  overlay.style.display = "none";
});
