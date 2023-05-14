const startButton = document.getElementById('start');
const stopButton = document.getElementById('stop');
const timer = document.getElementById('timer');

let intervalId = null;
let time = 0;

startButton.addEventListener('click', () => {
    intervalId = setInterval(() => {
        time++;
        const hours = Math.floor(time / 3600).toString().padStart(2, '0');
        const minutes = Math.floor((time % 3600) / 60).toString().padStart(2, '0');
        const seconds = (time % 60).toString().padStart(2, '0');
        timer.textContent = `${hours}:${minutes}:${seconds}`;
    }, 1000);
});

stopButton.addEventListener('click', () => {
    clearInterval(intervalId);
});
