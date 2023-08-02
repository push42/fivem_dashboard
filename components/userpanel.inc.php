<?php
// Fetch the avatar_url from the $_SESSION array or use a default avatar URL
if (isset($_SESSION["avatar_url"])) {
    $avatar_url = $_SESSION["avatar_url"];
} else {
    // Use a default avatar URL if avatar_url is not set
    $avatar_url = "img/default_avatar.png"; // Replace "default_avatar.png" with the URL of your default avatar image or just replace the image inside the img folder
    $avatar_url2 = "img/system_avatar.png";
}
?>


<body>
    <noscript>Du musst Javascript aktiviert haben.</noscript>
<div id="particles-js"></div>
   
<section class="user-serverpanel">
    <div class="server-status-container2">
    <div class="header-info-right">
        <!-- Display the user's avatar using the $avatar_url variable -->
        <img src="<?php echo $avatar_url; ?>" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
        <?php echo "Willkommen zurück, " . $_SESSION["username"] . "<br>"; ?>
        <a href="#" id="settings-icon"> <!-- Link to the settings page -->
            <i class="fa-solid fa-cog form-icons" style="color: #ffffff;"></i> <!-- Replace with your settings icon -->
        </a>
        <form method="post" action="">
            <button type="submit" name="logout" id="header-info-right-login" class="fancy-button">Abmelden</button>
        </form>
    </div>
</div>

<!-- Hidden modal container -->
<div id="avatar-modal" class="modal">
    <div class="account-settings-modal">
        <span class="close-icon" id="close-modal">&times;</span>
        <h2><i class="fa-solid fa-user-gear labelicon"></i>Kontoeinstellungen</h2>
        <form id="avatar-form" method="post" action="update_avatar.php">
            <label><i class="fa-solid fa-image labelicon"></i>Avatar (URL):</label>
            <input type="text" name="new_avatar_url" placeholder="www.dein-link.de/image.png" >

            <label><i class="fa-solid fa-signature labelicon"></i>Benutzername:</label>
            <input type="text" placeholder="Gib deinen neuen Benutzernamen ein" name="new_username" >
            <input type="submit" name="update_avatar" value="> Avatar ändern">
            <input type="submit" name="update_username" value="> Benutzername ändern">
        </form>
    </div>
</div>

<div class="online-users-count" id="onlineUsersCount">
    <span class="online-badge"></span>Staff Online: <span id="onlineUsersCounter"></span>
</div>