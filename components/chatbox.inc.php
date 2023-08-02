<div class="title2"><i class="fa-solid fa-crown title2icon"></i>Hall of Fame</div>
<div class="new-sections-container" style="display: flex; justify-content: space-between;">
    <div class="new-section-1" style="flex: 1;">
        <!-- Left box content goes here -->
        <img src="img/active.gif" alt="Active" class="activechat"><img>aktivste/r
    </div>
    <div class="equalsymbol"><i class="fa-solid fa-equals fa-beat"></i></div>
    <div class="new-section-2" style="flex: 1;">
        <!-- Right box content goes here -->
    </div>
    </div>
    </div>
</div>

<div class="chatbox-container">
  <div class="announcements">
    <marquee behavior="scroll" direction="left">
      <!-- Announcement messages go here -->
      <span>📢 Willkommen im navigationchat, bitte haltet euch auch hier an die Regeln und verhaltet euch dementsprechend.</span>
      <span><i class="fa-brands fa-discord title3icon"></i>dsc.gg/roguev</span>
      <span><i class="fa-solid fa-code title3icon"></i>Chat entwickelt von push42</span>
      <span><i class="fa-solid fa-wrench title3icon"></i>Der Chat bekommt regelmäßige Updates</span>
      <span><i class="fa-solid fa-face-grin-tongue-wink title3icon"></i>Emoji-Button wird demnächst eingebaut!</span>
    </marquee>
  </div>
  <div class="chatbox">
    <div class="chat-overview">
      <div class="overview-buttons">
      <button id="joinchat-button" class="fancy-button" onclick="updateActiveUsers(chatJoined ? 'leave' : 'join')">Chat beitreten
        </button>
      </div>
      <div class="online-symbol"></div>
        <div class="welcome-message">
      <p class="glowing-text">Chat ist Online!</p>
    </div>
      <p>
        <span id="active-users">2</span> neue Nachrichten
      </p>
      <p>
      <span id="total-messages">0</span> Nachrichten gesendet
      </p>
    </div>
    <div class="message-container" id="message-container">
      <!-- Chat messages go here -->
    </div>
    <div class="overlay">
      <span class="icon"><i class="fa-solid fa-eye-slash fa-beat" style="color: #1e90ff;"></i></span>
    </div>
    <div class="input-container">
      <input type="text" id="message-input" placeholder="Schreibe eine Nachricht...">
      <p>Übrig: <span id="remaining-characters">75</span></p>
      <button id="send-button">Nachricht senden</button>
    </div>
  </div>
</div>