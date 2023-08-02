<?php
    session_start();
    ini_set('memory_limit', '-1');
    include "chat_functions.php";
    require "components/head.inc.php";
    require "components/userpanel.inc.php";
    require "components/serverstatus.inc.php";
    require "components/infobox.inc.php";
    require "components/chatbox.inc.php";
    require "components/todo.inc.php";

// Check if the user is not logged in, then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit();
}
// Logout functionality
if (isset($_POST["logout"])) {
    // Open a connection to the database
    $con = mysqli_connect("localhost", "root", "", "webdev");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the DELETE statement
    $stmt = $con->prepare("DELETE FROM online_users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->close();

    // Close the connection
    mysqli_close($con);

    // Destroy the session and redirect to login page
    session_destroy();
    header("Location: login.php");
    exit();
}

if (isset($_POST["refresh"])) {
    // Simply return the current count without incrementing or decrementing
    echo $count;
    exit(); // Exit to prevent further execution of the script
}
// Fetch the avatar_url from the $_SESSION array or use a default avatar URL
if (isset($_SESSION["avatar_url"])) {
    $avatar_url = $_SESSION["avatar_url"];
} else {
    // Use a default avatar URL if avatar_url is not set
    $avatar_url = "img/default_avatar.png"; // Replace "default_avatar.png" with the URL of your default avatar image or just replace the image inside the img folder
    $avatar_url2 = "img/system_avatar.png";
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_fivemtest";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$servername_webdev = "localhost";
$username_webdev = "root";
$password_webdev = "";
$database_webdev = "webdev";

$conn_webdev = new mysqli(
    $servername_webdev,
    $username_webdev,
    $password_webdev,
    $database_webdev
);

if ($conn_webdev->connect_error) {
    die("Connection to webdev failed: " . $conn_webdev->connect_error);
}

$sqlUsers =
    "SELECT identifier, firstname, lastname, job, job_grade, accounts, `group` FROM users";
$resultUsers = $conn->query($sqlUsers);
//
$sqlOwnedVehicles = "SELECT * FROM owned_vehicles";
$resultOwnedVehicles = $conn->query($sqlOwnedVehicles);
//
$sqlCodemFishing = "SELECT * FROM `codem-fishing`";
$resultCodemFishing = $conn->query($sqlCodemFishing);
//
$sqlCodemCrafting = "SELECT * FROM `codem-craft`";
$resultCodemCrafting = $conn->query($sqlCodemCrafting);
//
$sqlCompanyMoney = "SELECT * FROM company_money";
$resultCompanyMoney = $conn->query($sqlCompanyMoney);
//
$sqlLiveCall = "SELECT * FROM codem_livecall";
$resultLiveCall = $conn->query($sqlLiveCall);
//
$sqlGeparkteAutos = "SELECT * FROM vehicle_parking";
$resultGeparkteAutos = $conn->query($sqlGeparkteAutos);
//
$sqlGangStashes = "SELECT * FROM t1ger_gangs";
$resultGangStashes = $conn->query($sqlGangStashes);
//
$sqlPlayerInventory = "SELECT * FROM ox_inventory";
$resultPlayerInventory = $conn->query($sqlPlayerInventory);
//
$sqlSpeedCams = "SELECT * FROM speedcams_profit";
$resultSpeedCams = $conn->query($sqlSpeedCams);
//
$sqlTigerMechanic = "SELECT * FROM t1ger_mechanic";
$resultTigerMechanic = $conn->query($sqlTigerMechanic);
//
$sqlOKOKBilling = "SELECT * FROM okokbilling";
$resultOKOKBilling = $conn->query($sqlOKOKBilling);

$accountIcons = [
    "bank" => '<i class="fas fa-piggy-bank"></i>',
    "black_money" => '<i class="fas fa-money-bill-alt"></i>',
    "cosmo" => '<i class="fas fa-globe"></i>',
    "money" => '<i class="fas fa-money-bill"></i>',
];

function formatIcon($account)
{
    global $accountIcons;
    return $accountIcons[$account];
}
//
function formatAccountValue($account, $value)
{
    return formatIcon($account) . ": " . $value;
}
//
function formatAccounts($jsonString)
{
    // Decode the JSON string into an associative array
    $accounts = json_decode($jsonString, true);

    // Format the accounts data
    $formattedAccounts = "";
    foreach ($accounts as $account => $value) {
        $formattedAccounts .= formatAccountValue($account, $value) . ", ";
    }

    // Remove the trailing comma and space
    $formattedAccounts = rtrim($formattedAccounts, ", ");

    return $formattedAccounts;
}

function totalAccounts($conn) {
    // Get users
    $resultUsers = $conn->query("SELECT accounts FROM users");

    $totalAccounts = [
        "bank" => 0,
        "black_money" => 0,
        "cosmo" => 0,
        "money" => 0,
    ];

    // Loop through each user
    while ($row = $resultUsers->fetch_assoc()) {
        // Decode the JSON string into an associative array
        $accounts = json_decode($row["accounts"], true);

        // Add the account values to the total
        foreach ($accounts as $account => $value) {
            $totalAccounts[$account] += $value;
        }
    }

    return $totalAccounts;
}
?>

<div class="wirtschafts-header"><i class="fa-solid fa-chart-simple fa-bounce wheadericon"></i>Wirtschaftsübersicht</div>
<div class="wirtschafts-subheader">Erhalte einen Überblick über die Wirtschaft auf Rogue-V</div>
<div class="wirtschafts-container">
    <?php 
        $totalAccounts = totalAccounts($conn);
        $icons = [
            "bank" => '<i class="fas fa-building-columns box-icon"></i>',
            "black_money" => '<i class="fas fa-sack-dollar box-icon"></i>',
            "cosmo" => '<i class="fas fa-bitcoin-sign box-icon"></i>',
            "money" => '<i class="fas fa-money-bill-1 box-icon"></i>',
        ];

        foreach ($totalAccounts as $account => $total) {
            echo "<div class=\"box\">";
            echo $icons[$account];
            echo "<p class=\"box-text\">" . ucfirst($account) . "</p>";
            echo "<p class=\"box-total\">Total: " . $total . "</p>";
            echo "</div>";
        }
    ?>
</div>

    <div class="logo-imagetext2"></div>
    <div class="spacer01"></div>

<div class="container" id="rvdatenbank">
<div class="users-section">
    <h2><i class="fa-solid fa-user fontawesomeicons" style="color: #007bff;"></i>Registrierte Spieler</h2>
    <!-- Add search box for users -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-users" placeholder="Suche nach Spielern...">
    </div>
    <div class="info-accounts">
    <i class="fa-solid fa-info info-accounticon fa-lg"></i>Bei den Konten steht das Symbol
    <i class="fas fa-building-columns icon-beschreibung1 fa-lg"></i> für Bank,
    <i class="fas fa-sack-dollar icon-beschreibung2 fa-lg"></i>  für Schwarzgeld,
    <i class="fas fa-bitcoin-sign icon-beschreibung3 fa-lg"></i>  für Crypto &
    <i class="fas fa-money-bill-1 icon-beschreibung4 fa-lg"></i>  für Bargeld.
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultUsers->num_rows > 0) {
            echo '<table id="users-table">';
            echo "<tr><th>Konten</th><th>Identifier</th><th>Vorname</th><th>Nachname</th><th>Beruf</th><th>Rang</th><th>Gruppe</th></tr>";
            while ($row = $resultUsers->fetch_assoc()) {
                // Convert the JSON string to an array
                $accounts = json_decode($row["accounts"], true);

                $formattedAccounts = "";
                foreach ($accounts as $account => $value) {
                    // Define the Font Awesome icon for each account
                    $icons = [
                        "bank" =>
                            '<i class="fas fa-building-columns icon-beschreibung1"></i>',
                        "black_money" =>
                            '<i class="fas fa-sack-dollar icon-beschreibung2"></i>',
                        "cosmo" =>
                            '<i class="fas fa-bitcoin-sign icon-beschreibung3"></i>',
                        "money" =>
                            '<i class="fas fa-money-bill-1 icon-beschreibung4"></i>',
                    ];

                    // Append the account icon and value with a line break
                    $formattedAccounts .=
                        $icons[$account] . " : " . $value . "<br>";
                }

                echo "<tr>";
                echo "<td>" . $formattedAccounts . "</td>";
                echo "<td>" . $row["identifier"] . "</td>";
                echo "<td>" . $row["firstname"] . "</td>";
                echo "<td>" . $row["lastname"] . "</td>";
                echo "<td>" . $row["job"] . "</td>";
                echo "<td>" . $row["job_grade"] . "</td>";
                echo "<td>" . $row["group"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="owned-vehicles-section">
    <h2><i class="fa-solid fa-car fontawesomeicons" style="color: #007bff;"></i>Fahrzeuge von Usern</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-vehicles" placeholder="Suche nach Fahrzeugen...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultOwnedVehicles->num_rows > 0) {
            echo '<table id="vehicles-table">';
            echo "<tr><th>Besitzer</th><th>Kennzeichen</th><th>Klasse</th><th>Garage</th><th>Abschlepphof</th></tr>";
            while ($row = $resultOwnedVehicles->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["owner"] . "</td>";
                echo "<td>" . $row["plate"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["parking"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="parked-vehicles-section">
    <h2><i class="fa-solid fa-car fontawesomeicons" style="color: #007bff;"></i>Ausgeparkte Fahrzeuge</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-parked-vehicles" placeholder="Nach einem Fahrzeug suchen...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultGeparkteAutos->num_rows > 0) {
            echo '<table id="parked-vehicles-table">';
            echo "<tr><th>Kennzeichen</th><th>Position X</th><th>Position Y</th><th>Position Z</th></tr>";
            while ($row = $resultGeparkteAutos->fetch_assoc()) {
                echo "<tr>";
                $tuningData = json_decode($row["tuning"], true); // Decode the JSON data into an array
                $firstWord = explode("-", $tuningData[0])[0]; // Get the first word from the first element of the array
                echo "<td>" . $firstWord . "</td>";
                echo "<td>" . $row["posX"] . "</td>";
                echo "<td>" . $row["posY"] . "</td>";
                echo "<td>" . $row["posZ"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="codem-fishing-section">
    <h2><i class="fa-solid fa-fish fontawesomeicons" style="color: #007bff;"></i>Angeln</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-fishing" placeholder="Suche nach Spielern...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultCodemFishing->num_rows > 0) {
            echo '<table id="fishing-table">';
            echo "<tr><th>Identifier</th><th>Level</th><th>XP</th><th>IC-Name</th></tr>";
            while ($row = $resultCodemFishing->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["identifier"] . "</td>";
                echo "<td>" . $row["level"] . "</td>";
                echo "<td>" . $row["xp"] . "</td>";
                echo "<td>" . $row["playername"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="codem-crafting-section">
    <h2><i class="fa-solid fa-hammer fontawesomeicons" style="color: #007bff;"></i>Crafting</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-crafting" placeholder="Suche nach Spielern...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultCodemCrafting->num_rows > 0) {
            echo '<table id="crafting-table">';
            echo "<tr><th>Identifier</th><th>Level</th><th>XP</th></tr>";
            while ($row = $resultCodemCrafting->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["identifier"] . "</td>";
                echo "<td>" . $row["level"] . "</td>";
                echo "<td>" . $row["xp"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="company-money-section">
    <h2><i class="fa-solid fa-money-check-dollar fontawesomeicons" style="color: #007bff;"></i>Firmenkonten</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-company" placeholder="Suche nach Firmen...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultCompanyMoney->num_rows > 0) {
            echo '<table id="company-table">';
            echo "<tr><th>Firma</th><th>Kontostand</th></tr>";
            while ($row = $resultCompanyMoney->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["money"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="live-call-section">
    <h2><i class="fa-solid fa-headset fontawesomeicons" style="color: #007bff;"></i>Livesupport (über ESC)</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-livecall" placeholder="Supportfall suchen...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultLiveCall->num_rows > 0) {
            echo '<table id="livecall-table">';
            echo "<tr><th>IC Name</th><th>Nachricht</th><th>Datum</th></tr>";
            while ($row = $resultLiveCall->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["playername"] . "</td>";

                // Decode the JSON data
                $messageData = json_decode($row["message"], true);

                // Check if "message" exists in the decoded data
                if (isset($messageData["message"])) {
                    $message = $messageData["message"];
                } else {
                    // Fallback to the original message if "message" field is not found
                    $message = $row["message"];
                }

                echo "<td>" . $message . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="gangstashes-section">
    <h2><i class="fa-solid fa-hands-asl-interpreting fontawesomeicons" style="color: #007bff;"></i>Gangübersicht</h2>
    <!-- Add search box for users -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-gangstashes" placeholder="Suche nach Spielern...">
    </div>
    <div class="info-accounts">
    <i class="fa-solid fa-info info-accounticon fa-lg"></i>In der Spalte "Deaktiviert?" steht 0 für NEIN, 1 für JA.
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultGangStashes->num_rows > 0) {
            echo '<table id="vehicles-table">';
            echo "<tr><th>Gang / Fraktion</th><th>Gang Notirity</th><th>Gangkonto</th><th>Gangleitung</th><th>Deaktiviert?</th></tr>";
            while ($row = $resultGangStashes->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["notoriety"] . "</td>";
                echo "<td>" . $row["cash"] . "</td>";
                echo "<td>" . $row["leader"] . "</td>";
                echo "<td>" . $row["disabled"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>


<div class="inventory-section">
    <h2><i class="fa-solid fa-box-open fontawesomeicons" style="color: #007bff;"></i>Inventare</h2>
    <!-- Add search box for users -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-inventory" placeholder="Suche nach einem Inventar...">
    </div>
    <div class="info-inventory">
    <i class="fa-solid fa-info info-accounticon fa-lg"></i>Hier kannst du alle Gegenstände einsehen die sich in einem Lager / Inventar befinden. Für Gegenstände mit dem <i class="fas fa-box icon-beschreibung3"></i> wurden die Symbole noch nicht angepasst.
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
    <?php if ($resultPlayerInventory->num_rows > 0) {
        echo '<table id="inventory-table">';
        echo "<tr><th>Identifier</th><th>Bezeichnung</th><th>Inhalt</th></tr>";
        while ($row = $resultPlayerInventory->fetch_assoc()) {
            // Check if 'data' key exists in the row
            if (isset($row["data"])) {
                // Convert the JSON string to an array
                $data = json_decode($row["data"], true);

                $formattedInventory = "";
                if (is_array($data)) {
                    // Construct the formatted inventory entry
                    foreach ($data as $item) {
                        if (
                            isset($item["name"]) &&
                            isset($item["count"])
                        ) {
                            // Define the Font Awesome icon based on the item name
                            $icon = "";

                            // Check for different item name prefixes and set the corresponding icon
                            if (
                                strpos($item["name"], "WEAPON_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gun icon-beschreibung5"></i>';
                            } elseif (
                                strpos($item["name"], "ammo-") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-battery-three-quarters icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "joint_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-joint icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "drug_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-tablets icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "money") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-dollar icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "diamond") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gem icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "washed_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gem icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "stone") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gem icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "washpan") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gem icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "waffen_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-screwdriver icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "police_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-person-military-pointing icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "cd") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-compact-disc icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "medbag") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-suitcase-medical icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "medikit") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-suitcase-medical icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "defib") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-suitcase-medical icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "lighter") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "at_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-circle-plus icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "tailor") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "woodenrod") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "spray") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "grubber") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "meth") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-tablets icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "boombox") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-music icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "hammer") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-hammer icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "pickaxe") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "pipette") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-eye-dropper icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "handsaw") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "shovel") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "woodaxe") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "crowbar") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos(
                                    $item["name"],
                                    "heckenscheere"
                                ) === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wrench icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "juwerlycore") ===
                                0
                            ) {
                                $icon =
                                    '<i class="fas fa-gem icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "hacking") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-microchip icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "usb") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-microchip icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "dongle") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-microchip icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "black_usb") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-microchip icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "vpn") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-microchip icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "weed") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cannabis icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "papes") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cannabis icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "duenger") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cannabis icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "handcuffs") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-handcuffs icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "zipties") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-hands-bound icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "headbag") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-eye-slash icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "cutter") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-scissors icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "plastik") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-sheet-plastic icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "metal") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-sheet-plastic icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "metall") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-sheet-plastic icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "carjack") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-car icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "carokit") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-car icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "lab_key") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-key icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "gym_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-id-card-clip icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "grinder") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cannabis icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "fake_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-list-ol icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "nitrous") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gauge-high icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "raw_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cannabis icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "plantpot") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cannabis icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "water") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-glass-water icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "mars") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cookie icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "snickers") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cookie icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "bounty") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cookie icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "milkyway") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cookie icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "donut2") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cookie icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "donut1") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cookie icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "twix") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-cookie icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "black_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "red_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "gold_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "wet_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "pink_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "phone") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "pet") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-dog icon-beschreibung6"></i>';
                            } elseif (
                                strpos(
                                    $item["name"],
                                    "healthybabymineral"
                                ) === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-baby icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "contract") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-file-signature icon-beschreibung6"></i>';
                            } elseif (
                                strpos(
                                    $item["name"],
                                    "healthybabyfood"
                                ) === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-baby icon-beschreibung6"></i>';
                            } elseif (
                                strpos(
                                    $item["name"],
                                    "comfortdiaper"
                                ) === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-baby icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "baby") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-baby icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "classic_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "white_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-phone icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "panties") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-shirt icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "tvremote") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-tv icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "garbage") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-trash icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "vest_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-vest icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "bandage") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-bandage icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "uncut_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gem icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "laptop") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-laptop icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "gasoline") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-gas-pump icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "id_card") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-id-card icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "car_") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-car-battery icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "repair") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-toolbox icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "advrepair") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-toolbox icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "backpack") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-bag-shopping icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "burger") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-burger icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "coffee") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-mug-saucer icon-beschreibung6"></i>';
                            } elseif (
                                strpos($item["name"], "wallet") === 0
                            ) {
                                $icon =
                                    '<i class="fas fa-wallet icon-beschreibung6"></i>';
                            } else {
                                $icon =
                                    '<i class="fas fa-box icon-beschreibung3"></i>';
                            }

                            // Append the formatted inventory entry to the overall formatted inventory
                            $formattedInventory .=
                                $icon .
                                " " .
                                $item["name"] .
                                " : " .
                                $item["count"] .
                                "<br>";
                        }
                    }
                }

                echo "<tr>";
                echo "<td>" .
                    (isset($row["owner"]) ? $row["owner"] : "") .
                    "</td>";
                echo "<td>" .
                    (isset($row["name"]) ? $row["name"] : "") .
                    "</td>";
                echo "<td>" . $formattedInventory . "</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    } else {
        echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
    } ?>
    </div>
</div>

<div class="speedcams-section">
    <h2><i class="fa-solid fa-video fontawesomeicons" style="color: #007bff;"></i>Blitzer</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-speedcams" placeholder="Suche nach Blitzern...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultSpeedCams->num_rows > 0) {
            echo '<table id="speedcams-table">';
            echo "<tr><th>Blitzer ID</th><th>Bezeichnung</th><th>Einnahmen</th><th>Ausgelöst am</th><th>Summe</th><th>Geblitzte/r</th></tr>";
            while ($row = $resultSpeedCams->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["radarID"] . "</td>";
                echo "<td>" . $row["label"] . "</td>";
                echo "<td>" . $row["totalProfit"] . "</td>";
                echo "<td>" . $row["lastTime"] . "</td>";
                echo "<td>" . $row["lastProfit"] . "</td>";
                echo "<td>" . $row["lastUser"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="mechanic-section">
    <h2><i class="fa-solid fa-screwdriver fontawesomeicons" style="color: #007bff;"></i>Mechaniker</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-mechanic" placeholder="Suche nach Mechaniker Werkstätten...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultTigerMechanic->num_rows > 0) {
            echo '<table id="mechanic-table">';
            echo "<tr><th>Identifier</th><th>ID</th><th>Name</th><th>Kontostand</th><th>Angestellte</th><th>Lager</th></tr>";
            while ($row = $resultTigerMechanic->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["identifier"] . "</td>";
                echo "<td>" . $row["shopID"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["money"] . "</td>";
                echo "<td>" . $row["employees"] . "</td>";
                echo "<td>" . $row["storage"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>

<div class="okokbilling-section">
    <h2><i class="fa-solid fa-screwdriver fontawesomeicons" style="color: #007bff;"></i>Rechnungsübersicht</h2>
    <!-- Add search box for owned vehicles -->
    <div class="search-box">
        <i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>
        <input type="text" id="search-okokbilling" placeholder="Suche nach einer Rechnung...">
    </div>
    <!-- Wrap the table in a scrollable container -->
    <div class="table-container">
        <?php if ($resultOKOKBilling->num_rows > 0) {
            echo '<table id="okokbilling-table">';
            echo "<tr><th>Rechnungs Nr.</th><th>Empfänger</th><th>Aussteller</th><th>Summe</th><th>Zinsen</th><th>Status</th></tr>";
            while ($row = $resultOKOKBilling->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ref_id"] . "</td>";
                echo "<td>" . $row["receiver_name"] . "</td>";
                echo "<td>" . $row["author_name"] . "</td>";
                echo "<td>" . $row["invoice_value"] . "</td>";
                echo "<td>" . $row["fees_amount"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p><i class="fa-solid fa-magnifying-glass fontawesomeicons" style="color: #007bff;"></i>Noch keine Einträge..</p>';
        } ?>
    </div>
</div>
</div>


<script>

// **************************************** Suchfunktionen in den Datensätzen ****************************************
function searchUsers() {
    const input = document.getElementById("search-users");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("users-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchVehicles() {
    const input = document.getElementById("search-vehicles");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("vehicles-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchFishing() {
    const input = document.getElementById("search-fishing");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("fishing-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchCrafting() {
    const input = document.getElementById("search-crafting");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("crafting-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchCompany() {
    const input = document.getElementById("search-company");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("company-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchLiveCall() {
    const input = document.getElementById("search-livecall");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("livecall-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchGeparkteAutos() {
    const input = document.getElementById("search-parked-vehicles");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("parked-vehicles-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchGangStashes() {
    const input = document.getElementById("search-gangstashes");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("gangstashes-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchPlayerInventory() {
    const input = document.getElementById("search-inventory");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("inventory-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchSpeedCams() {
    const input = document.getElementById("search-speedcams");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("speedcams-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchTigerMechanic() {
    const input = document.getElementById("search-mechanic");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("mechanic-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function searchOKOKBilling() {
    const input = document.getElementById("search-okokbilling");
    const filter = input.value.toUpperCase();
    const table = document.getElementById("okokbilling-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        const columns = rows[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < columns.length; j++) {
            const cell = columns[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        if (found) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
// Add event listeners to the search boxes
const searchInputUsers = document.getElementById("search-users");
searchInputUsers.addEventListener("keyup", searchUsers);

const searchInputVehicles = document.getElementById("search-vehicles");
searchInputVehicles.addEventListener("keyup", searchVehicles);

const searchInputFishing = document.getElementById("search-fishing");
searchInputFishing.addEventListener("keyup", searchFishing);

const searchInputCrafting = document.getElementById("search-crafting");
searchInputCrafting.addEventListener("keyup", searchCrafting);

const searchInputCompany = document.getElementById("search-company");
searchInputCompany.addEventListener("keyup", searchCompany);

const searchInputLiveCall = document.getElementById("search-livecall");
searchInputLiveCall.addEventListener("keyup", searchLiveCall);

const searchInputGeparkteAutos = document.getElementById("search-parked-vehicles");
searchInputGeparkteAutos.addEventListener("keyup", searchGeparkteAutos);

const searchInputGangStashes = document.getElementById("search-gangstashes");
searchInputGangStashes.addEventListener("keyup", searchGangStashes);

const searchInputPlayerInventory = document.getElementById("search-inventory");
searchInputPlayerInventory.addEventListener("keyup", searchPlayerInventory);

const searchInputSpeedCams = document.getElementById("search-speedcams");
searchInputSpeedCams.addEventListener("keyup", searchSpeedCams);

const searchInputTigerMechanic = document.getElementById("search-mechanic");
searchInputTigerMechanic.addEventListener("keyup", searchSpeedCams);

const searchInputOKOKBilling = document.getElementById("search-okokbilling");
searchInputOKOKBilling.addEventListener("keyup", searchOKOKBilling);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* Avatar Logout Section Script */
    // Function to open the modal
    function openModal() {
        var modal = document.getElementById("avatar-modal");
        modal.style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        var modal = document.getElementById("avatar-modal");
        modal.style.display = "none";
    }

    // Event listener for the settings icon
    var settingsIcon = document.getElementById("settings-icon");
    settingsIcon.addEventListener("click", openModal);

    // Event listener for the close icon in the modal
    var closeModalIcon = document.getElementById("close-modal");
    closeModalIcon.addEventListener("click", closeModal);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var username = <?php echo json_encode($_SESSION['username']); ?>;
var avatarURL = <?php echo json_encode($avatar_url); ?>;
// Function to send a join or leave message to the server
function sendJoinOrLeaveMessage(username, avatarURL, message) {
  const xhr = new XMLHttpRequest();
  const data = new FormData();
  data.append('username', 'System'); // 'System' user for these actions
  data.append('avatar_url', 'img/system_avatar.png'); // Replace with your chosen path for System avatar
  data.append('message', message); // Complete message string
  xhr.open('POST', 'join_or_leave_chat.php', true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      // You can handle a successful response here if needed
    }
  };
  xhr.send(data);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

document.getElementById("joinchat-button").addEventListener("click", function() {
    document.querySelector(".overlay").style.display = "none";
    document.querySelector(".input-container").classList.add("input-allowed");
});

// Get the necessary elements
const joinChatButton = document.getElementById('joinchat-button');
const overlay = document.querySelector('.overlay');
const activeUsersSpan = document.getElementById('active-users');

// Define a variable to keep track of whether the chat is joined or not
let chatJoined = false;

// Define a variable to keep track of the active users
let activeUsers = 0;

// Set the initial number of active users
activeUsersSpan.textContent = activeUsers;

// Add a click event listener to the button
joinChatButton.addEventListener('click', function () {
  chatJoined = !chatJoined; // Toggle the variable

  if (chatJoined) {
    sendJoinOrLeaveMessage(username, avatarURL, username + ' ist dem Chat beigetreten!');
    // Hide the overlay and change the button's text if the chat is joined and send a announcement
    overlay.style.display = 'none';
    joinChatButton.textContent = 'Chat verlassen';


  } else {
    // Show the overlay and change the button's text if the chat is left and send a announcement
    sendJoinOrLeaveMessage(username, avatarURL, username + ' hat den Chat verlassen!');
    overlay.style.display = 'flex';
    joinChatButton.textContent = 'Chat beitreten';

  }
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to fetch and display the total number of messages
function fetchTotalMessages() {
  // Send an AJAX request to the fetch_messages.php file
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'fetch_messages.php', true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      // If the AJAX request is successful, update the total messages count on the page
      const response = JSON.parse(xhr.responseText);
      const totalMessagesSpan = document.getElementById('total-messages');
      totalMessagesSpan.textContent = response.totalMessages;
    } else {
      console.error('Error fetching total messages:', xhr.status);
    }
  };
  xhr.onerror = function () {
    console.error('Error sending AJAX request to fetch_messages.php');
  };
  xhr.send();
}

// Function to refresh the total number of messages every 5 seconds
function refreshTotalMessages() {
  fetchTotalMessages();
}

// Fetch and display the initial total number of messages
fetchTotalMessages();

// Refresh the total messages count every 5 seconds
setInterval(refreshTotalMessages, 5000);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // Function to fetch and display chat messages when the page loads
  function loadChatMessages() {
    // Fetch the chat messages from the server
    fetch('get_messages.php')
      .then((response) => response.json())
      .then((data) => {
        // Iterate through the retrieved messages in reverse order and display them in the chatbox
        for (let i = data.length - 1; i >= 0; i--) {
          const message = data[i];
          displayMessage(
            message.username,
            message.avatar_url,
            message.message,
            message.timestamp
          );
        }
      })
      .catch((error) => {
        console.error('Error fetching chat messages:', error);
      });
  }

  // Load chat messages when the page loads
  document.addEventListener('DOMContentLoaded', loadChatMessages);

    // Function to refresh the chat messages every 5 seconds
    function refreshChat() {
    loadChatMessages();
    }

    // Refresh the chat every 5 seconds
    setInterval(refreshChat, 5000);



  // JavaScript code for sending and displaying chat messages
  const messageContainer = document.getElementById('message-container');
  const messageInput = document.getElementById('message-input');
  const sendButton = document.getElementById('send-button');



// Function to display a new message in the chat
// Variable to store the timestamp of the latest message
let latestMessageTimestamp = null;

// Function to display a new message in the chat
function displayMessage(username, avatarURL, message, timestamp) {
  const messageDiv = document.createElement('div');
  messageDiv.classList.add('message');

  // Use inline style to set the background image as the user's avatar
  messageDiv.innerHTML = `
    <div class="avatar" style="background-image: url('${avatarURL}')"></div>
    <div class="message-content">
      <div>
        <span class="username">${username}</span>
        <span class="timestamp">${timestamp}</span>
        <span class="settings-icon" onclick="removeMessage(this)">&times;</span>
      </div>
      <p>${message}</p>
      <div class="new-message-indicator" style="display: ${isMessageNew(timestamp) ? 'block' : 'none'};"><img src="img/new.png" alt="Bew" class="new-message-image"></img></div>
    </div>
  `;

  // Append the new message to the messageContainer
  messageContainer.appendChild(messageDiv);

  // Scroll to the bottom of the messageContainer
  messageContainer.scrollTop = messageContainer.scrollHeight;

  // Update the timestamp of the latest message
  latestMessageTimestamp = timestamp;

  // Check and hide the "New" icon after 1 minute
  checkAndHideNewIcon();
}


// Function to check if a message is new based on its timestamp
function isMessageNew(timestamp) {
  if (!latestMessageTimestamp) {
    return true;
  }
  const currentTime = new Date().getTime();
  const messageTime = new Date(timestamp).getTime();
  return currentTime - messageTime <= 120000; // 2 minute in milliseconds
}

// Function to check and hide the "New" icon after 1 minute
function checkAndHideNewIcon() {
  const newMessageIndicators = document.querySelectorAll('.new-message-indicator');
  newMessageIndicators.forEach((indicator) => {
    const timestampSpan = indicator.parentElement.querySelector('.timestamp');
    const messageTimestamp = timestampSpan.textContent;
    indicator.style.display = isMessageNew(messageTimestamp) ? 'block' : 'none';
  });
}



// Call the function to check and hide the "New" icon every 5 seconds
setInterval(checkAndHideNewIcon, 5000);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Add the 'input' event listener to update the remaining character count
messageInput.addEventListener('input', updateCharacterCount);

// Function to update the remaining character count
function updateCharacterCount() {
  const maxCharacterLimit = 75; // Set the maximum character limit here
  const remainingCharacters = maxCharacterLimit - messageInput.value.length;
  const remainingCharactersElement = document.getElementById('remaining-characters');
  remainingCharactersElement.textContent = remainingCharacters;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to send a message with a cooldown timer
function sendMessageWithCooldown() {
  const message = messageInput.value.trim(); // Trim any leading/trailing whitespace

  // Check if the message is empty or exceeds the maximum length
  if (!message) {
    // If the message is empty, display an error message or take appropriate action
    console.error('Error: Empty message cannot be sent.');
    return;
  }

  const maxLength = 75; // Set the maximum allowed length for the message

  if (message.length > maxLength) {
    // If the message exceeds the maximum length, display an error message or take appropriate action
    console.error(`Error: Message exceeds the maximum length of ${maxLength} characters.`);
    return;
  }

  // Get the current timestamp (you can use your own function for this)
  const timestamp = getCurrentTime();

  // Replace 'avatar_url_value' with the correct key for the avatar URL in $_SESSION
  const avatarURL = '<?php echo $_SESSION["avatar_url"]; ?>';
  // Replace 'username_value' with the correct key for the username in $_SESSION
  const username = '<?php echo $_SESSION["username"]; ?>';

  // Disable the input and send button during cooldown
  messageInput.disabled = true;
  sendButton.disabled = true;

  // Show the cooldown timer inside the input box
  let cooldownSeconds = 3;
  messageInput.value = `Spam-Schutz: ${cooldownSeconds} Sekunden`;

  // Decrement the cooldown timer every second
  const cooldownInterval = setInterval(() => {
    cooldownSeconds--;
    messageInput.value = `Spam-Schutz: ${cooldownSeconds} Sekunden`;

    // If cooldown is over, enable the input and send button and clear the interval
    if (cooldownSeconds === 0) {
      clearInterval(cooldownInterval);
      messageInput.value = '';
      messageInput.disabled = false;
      sendButton.disabled = false;
    }
  }, 1000);

  // Send the message to the server
  sendMessageToServer(username, avatarURL, message);
}

// Event listener for the send button
sendButton.addEventListener('click', sendMessageWithCooldown);

// Event listener for Enter key in the message input field
messageInput.addEventListener('keydown', (event) => {
  if (event.keyCode === 13) {
    sendMessageWithCooldown();
  }
});


  // Function to get the current timestamp
  function getCurrentTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
  }

  // Function to send a message to the server
  function sendMessageToServer(username, avatar_url, message) {
    // Rest of the function code (the AJAX request and handling response)
    // ... Get username and avatar_url from your $_SESSION as before

   // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Prepare the data to be sent
    const data = new FormData();
    data.append('username', username);
    data.append('avatar_url', avatar_url);
    data.append('message', message);

    // Configure the AJAX request
    xhr.open('POST', 'save_message.php', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    // Define the callback function when the request completes
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Message saved successfully, you can display a success message if you want

        // After sending the message, display it in the chat immediately
        displayMessage(username, avatar_url, message, getCurrentTime());
      } else {
        // Handle error, display an error message or take appropriate action
      }
    };

    // Send the request
    xhr.send(data);
  }


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Function to add a new task to the To-Do list
function addTask() {
  const taskInput = document.getElementById('task-input');
  const taskText = taskInput.value.trim();

  if (!taskText) {
    // If the task text is empty, show an error message or take appropriate action
    console.error('Error: Empty task cannot be added.');
    return;
  }

  // AJAX request to save the task to the database
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'save_task.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
    if (xhr.status === 200) {
      // If the task is successfully saved in the database, update the To-Do list
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        // Call createTaskItem to create the task item with the "Delete" button
        createTaskItem(response.taskId, taskText);
        taskInput.value = '';
      } else {
        console.error('Error saving task:', response.message);
      }
    } else {
      console.error('Error saving task:', xhr.status);
    }
  };
  xhr.onerror = function () {
    console.error('Error sending AJAX request to save_task.php');
  };
  xhr.send('task=' + encodeURIComponent(taskText));
}
  
  // Function to toggle the completion status of a task
function toggleTaskCompletion(taskItem, taskId) {
    // AJAX request to toggle the completion status in the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'toggle_task_completion.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
      if (xhr.status === 200) {
        // If the task completion status is successfully updated in the database, update the display
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          taskItem.classList.toggle('completed');
        } else {
          console.error('Error toggling task completion:', response.message);
        }
      } else {
        console.error('Error toggling task completion:', xhr.status);
      }
    };
    xhr.onerror = function () {
      console.error('Error sending AJAX request to toggle_task_completion.php');
    };
    xhr.send('taskId=' + encodeURIComponent(taskId));
}


// Function to load tasks from the database and display them in the To-Do list
function loadTasks() {
  // AJAX request to load tasks from the database
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_tasks.php', true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      // If tasks are successfully retrieved from the database, display them in the To-Do list
      const response = JSON.parse(xhr.responseText);
      if (response.success) {
        const tasks = response.tasks;
        const taskList = document.getElementById('task-list');

        // Clear the taskList before adding new tasks
        taskList.innerHTML = '';

        tasks.forEach((task) => {
          console.log(task.id, task.task); // Debug output
          const newTaskItem = createTaskItem(task.id, task.task); // Call createTaskItem for each task
          if (task.completed) {
            newTaskItem.classList.add('completed');
          }

          // Add a click event listener to mark the task as completed when clicked
          newTaskItem.addEventListener('click', function () {
            toggleTaskCompletion(this, task.id);
          });

          taskList.appendChild(newTaskItem);
        });
      } else {
        console.error('Error loading tasks:', response.message);
      }
    } else {
      console.error('Error loading tasks:', xhr.status);
    }
  };
  xhr.onerror = function () {
    console.error('Error sending AJAX request to get_tasks.php');
  };
  xhr.send();
}

  // Function to delete a task from the To-Do list
function deleteTask(taskItem, taskId) {
    // AJAX request to delete the task from the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_task.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
      if (xhr.status === 200) {
        // If the task is successfully deleted from the database, remove it from the display
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          taskItem.remove();
        } else {
          console.error('Error deleting task:', response.message);
        }
      } else {
        console.error('Error deleting task:', xhr.status);
      }
    };
    xhr.onerror = function () {
      console.error('Error sending AJAX request to delete_task.php');
    };
    xhr.send('taskId=' + encodeURIComponent(taskId));
  }

  // Event listener for the "Add Task" button
document.getElementById('add-task-button').addEventListener('click', function () {
    addTask();
  });

  // Event listener for Enter key in the task input field
document.getElementById('task-input').addEventListener('keydown', function (event) {
    if (event.keyCode === 13) {
      addTask();
    }
  });

// Event listener for the delete task button
document.getElementById('task-list').addEventListener('click', function (event) {
  if (event.target.classList.contains('delete-task-button')) {
    const taskItem = event.target.parentElement;
    const taskId = taskItem.dataset.taskId;
    deleteTask(taskItem, taskId);
  }
});
////////////////////////////////////////////////////////////////////////////////////////////////
// Function to create a new task item in the To-Do list
function createTaskItem(taskId, taskContent) {
  const taskList = document.getElementById('task-list');
  const li = document.createElement('li');
  li.dataset.taskId = taskId;
  li.innerHTML = `
    <span>${taskContent}</span>
    <button class="delete-task-button" onclick="deleteTask(this.parentElement, ${taskId})">&#10006; Löschen</button>
  `;
  return li; // <-- Add this line to return the created li element
}

document.addEventListener('DOMContentLoaded', loadTasks);

// Sound Button
var logoutButton = document.getElementById('header-info-right-login');
var logoutAudio = document.getElementById('mySound2');
logoutButton.addEventListener('click', function() {
  logoutAudio.play();
});

var joinTeamChatButton = document.getElementById('joinchat-button');
var joinTeamChatAudio = document.getElementById('mySound');
joinTeamChatButton.addEventListener('click', function() {
  joinTeamChatAudio.play();
});


// Check if the player is still connected / has the window open
setInterval(function() {
  // Perform an AJAX request to a PHP script to update the user's "last seen" time
  $.post('heartbeat.php', function(data) {
    // You can handle the response here if needed
  });
}, 5000); // Every 5 seconds


// Update Online Staffmember every 5 seconds
function updateOnlineUsers() {
        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open('GET', 'get_online_users.php', true);

        xhr.onload = function() {
            if (this.status === 200) {
                // Update the online users count on the page
                document.getElementById('onlineUsersCounter').innerText = this.responseText;
            }
        }

        // Send the request
        xhr.send();
    }

    // Call the function once to initialize
    updateOnlineUsers();

    // Set an interval to call the function every 5 seconds
    setInterval(updateOnlineUsers, 5000);
  </script>
  <script type="text/javascript" src="js/serverrestart.js"></script>
</body>

</html>
