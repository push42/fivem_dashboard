    // Function to calculate the time remaining until the next restart
    function calculateCountdown() {
        const now = new Date();
        const restartTimes = [0, 6, 12, 18, 24]; // Restart times in hours (24-hour format)
        const nextRestart = new Date(now);

        // Find the next restart time
        for (const restartTime of restartTimes) {
        nextRestart.setHours(restartTime, 0, 0, 0);
        if (nextRestart > now) {
            break;
        }
        }

        // Calculate the time difference between now and the next restart
        const timeDiff = nextRestart - now;

        // Calculate hours, minutes, and seconds
        const hours = Math.floor(timeDiff / 3600000);
        const minutes = Math.floor((timeDiff % 3600000) / 60000);
        const seconds = Math.floor((timeDiff % 60000) / 1000);

        // Format the time as HH:MM:SS
        const formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        // Update the countdown timer element
        document.getElementById('countdown-timer').textContent = formattedTime;
    }

    // Call the calculateCountdown function initially to update the countdown immediately
    calculateCountdown();

    // Update the countdown every second (1000 milliseconds)
    setInterval(calculateCountdown, 1000);


  function isServerOnline(ip, port) {
    const timeout = 2000;
    const serverURL = `http://${ip}:${port}`;
    const statusCircle = document.getElementById('serverStatusCircle');
    const statusText = document.getElementById('serverStatusText');

    statusText.innerHTML = 'Serverstatus: Serverdaten werden abgefragt...';

    const xhr = new XMLHttpRequest();
    xhr.open('GET', serverURL, true);
    xhr.timeout = timeout;

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        statusCircle.classList.add('online');
        statusCircle.classList.remove('offline');
        statusText.innerHTML = 'Serverstatus: Online';
      } else {
        statusCircle.classList.add('offline');
        statusCircle.classList.remove('online');
        statusText.innerHTML = 'Serverstatus: Offline';
      }
    };

    xhr.onerror = function () {
        statusCircle.classList.add('error');
        statusCircle.classList.remove('online', 'offline');
        statusText.innerHTML = 'Serverstatus: Wartungsarbeiten';
    };

    xhr.send();
  }

const serverIP = 'your_server_ip_adress';
const serverPort = 'your_port_thats_open_to_listen_to';

document.addEventListener('DOMContentLoaded', function () {
    isServerOnline(serverIP, serverPort);
});


