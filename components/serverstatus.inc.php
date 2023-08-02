<?php
// Here you need to set your server_id from trackyserver.com, i use it to fetch the server status, online players & voting
$server_id = "YOUR_SERVER_ID_FROM_TRACKYSERVER.COM";
$url = "https://api.trackyserver.com/widget/index.php?id=" . $server_id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = json_decode(curl_exec($ch), true);
curl_close($ch);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








?>
<div class="server-status-container">
    <div class="server-status-section">
        <h2><i class="fas fa-server gameservericon" style="color: #007bff;"></i>FiveM Serverstatus</h2>
    </div>
        <div class="server-status">
            <div class="status-circle" id="serverStatusCircle"></div>
            <span id="serverStatusText">Serverstatus: Fetching...</span>
        </div>
        <div class="countdown-timer-t">Nächster Neustart:</div>
            <div id="countdown-timer"></div></br>
            <button class="player-list-button" id="playerListButton">Verbundene Spieler</button>
                <div class="player-list-modal" id="playerListModal">
                    <h2>Verbundene Spieler</h2>
                    <?php if ($result) {
                        echo "<p><strong>Spielerzahl: </strong> " .
                            $result["playerscount"] .
                            "</p>";
                        if (isset($result["playerslist"])) {
                            echo "<ul>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Serverinformationen können nicht abgerufen werden.</p>";
                    } ?>
                    <!-- Player list will be dynamically populated using JavaScript -->
                    <ul id="playerList"></ul>
                    <button class="close-button" id="closeButton">Schließen</button>
                </div>
        <div class="modal-overlay"></div>
    </div>
    </div>
</div>
</section>
<script>
const playerListButton = document.getElementById('playerListButton');
const playerListModal = document.getElementById('playerListModal');
const closeButton = document.getElementById('closeButton');
const playerList = document.getElementById('playerList');
const modalOverlay = document.querySelector('.modal-overlay');
// Function to show the player list modal
function showPlayerListModal() {
    // Clear existing player list
    playerList.innerHTML = '';
    // Add connected players to the modal
    <?php if ($result && isset($result["playerslist"])) {
        echo "const players = " .
            json_encode($result["playerslist"]) .
            ";";
        echo "players.forEach(player => {";
        echo 'const listItem = document.createElement("li");';
        echo "listItem.textContent = player.name;";
        echo "playerList.appendChild(listItem);";
        echo "});";
    } ?>
    // Show the modal and overlay
    playerListModal.style.display = 'block';
    modalOverlay.style.display = 'block';
}
// Function to hide the player list modal
function hidePlayerListModal() {
    // Hide the modal and overlay
    playerListModal.style.display = 'none';
    modalOverlay.style.display = 'none';
}
// Add event listeners to the button and close button
playerListButton.addEventListener('click', showPlayerListModal);
closeButton.addEventListener('click', hidePlayerListModal);
</script>