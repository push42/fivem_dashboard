<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is already logged in, then redirect to the dashboard page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "webdev");

    // Check if the connection was successful
    if (!$con) {
        die("Verbindung Fehlgeschlagen: " . mysqli_connect_error());
    }

    // Sanitize the user input to prevent SQL injection
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $provided_code = $_POST['security_code'];

    // List of valid codes
    $valid_codes = array('dosenbier14', 'sammy098', 'balu881', 'fivemdev001', '1337luna');

    // Validate input and check if passwords match
    if ($password !== $confirm_password) {
        $register_error = "Die Passwörter stimmen nicht überein.";
    } else {
        // Check if the username is already taken
        $stmt = $con->prepare("SELECT id FROM staff_accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $register_error = "Der Benutzername ist bereits vergeben.";
        } else {
            // Check if the provided code is valid
            if (in_array($provided_code, $valid_codes)) {
                // Code is valid, proceed with registration

                // Save the avatar URL from the form in a variable
                $avatar_url = $_POST['avatar_url'];

                // Prepare and execute the INSERT statement
                $stmt = $con->prepare("INSERT INTO staff_accounts (username, password, avatar_url) VALUES (?, ?, ?)");
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bind_param("sss", $username, $hashed_password, $avatar_url);

                if ($stmt->execute()) {
                    // Registration successful, display success message
                    $register_success = "Registrierung erfolgreich! Sie können sich jetzt einloggen.";
                } else {
                    // Registration failed
                    $register_error = "Fehler bei der Registrierung. Bitte versuchen Sie es erneut.";
                }
            } else {
                // Invalid code
                $register_error = "Ungültiger Sicherheitscode.";
            }
        }
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/style_register.css">
    <title>Registrierung</title>
    <div class="header-text">
        <h2>Registrierung</h2>
    </div>
</head>
<body>
<div id="particles-js"></div>
<div class="register-container">
    <?php
    if (isset($register_error)) {
        echo '<p style="color: red;">' . $register_error . '</p>';
    } elseif (isset($register_success)) {
        echo '<p style="color: green;">' . $register_success . '</p>';

        // Redirect to the login page after a successful registration
        echo '<script>';
        echo 'alert("' . $register_success . '");';
        echo 'window.location.href = "login.php";';
        echo '</script>';
    }
    ?>
    <form method="post" action="">
        <label class="register-username">
            <span class="form-icons">&#128100;</span> Benutzername:
        </label>
        <input type="text" name="username" required><br>
        <label class="register-password">
            <span class="form-icons2">&#128273;</span> Passwort:
        </label>
        <input type="password" name="password" required><br>
        <label class="register-password">
            <span class="form-icons2">&#128273;</span> Passwort bestätigen:
        </label>
        <input type="password" name="confirm_password" required><br>
        <label class="register-password">
            <span class="form-icons2">&#128274;</span> Avatar-URL:
        </label>
        <input type="text" name="avatar_url"><br>
        <!-- Input field for security code -->
        <label class="register-security-code">
            <span class="form-icons4">&#128274;</span> Sicherheitscode:
        </label>
        <input type="text" name="security_code" required><br>

        <!-- Info icon button -->
        <div class="info-icon" onclick="toggleInfoBox()">
            <span class="form-icons3">&#8505;</span>
        </div>

        <!-- Information box -->
        <div class="info-box" id="infoBox">
            <p>Um dich hier Registrieren zu können, benötigst du einen Code. Diesen erhälst du bei einem unserer Entwickler.</p>
        </div>
        <!-- New input field for the avatar URL -->
        <input type="submit" value="Registrieren">
    </form>
</div>
<script>
    // Particle.js configuration
    particlesJS("particles-js", {
        particles: {
            number: { value: 80, density: { enable: true, value_area: 800 } },
            color: { value: "#ffffff" },
            shape: { type: "circle", stroke: { width: 0, color: "#181A47" }, polygon: { nb_sides: 5 }, image: { src: "img/github.svg", width: 100, height: 100 } },
            opacity: { value: 0.5, random: false, anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false } },
            size: { value: 3, random: true, anim: { enable: false, speed: 40, size_min: 0.1, sync: false } },
            line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
            move: { enable: true, speed: 6, direction: "none", random: false, straight: false, out_mode: "out", bounce: false, attract: { enable: false, rotateX: 600, rotateY: 1200 } }
        },
        interactivity: {
            detect_on: "canvas",
            events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" }, resize: true },
            modes: { grab: { distance: 400, line_linked: { opacity: 1 } }, bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 }, repulse: { distance: 200, duration: 0.4 }, push: { particles_nb: 4 }, remove: { particles_nb: 2 } }
        },
        retina_detect: true
    });

    // Toggle info box
    function toggleInfoBox() {
        var infoBox = document.getElementById('infoBox');
        if (infoBox.style.display === 'block') {
            infoBox.style.display = 'none';
        } else {
            infoBox.style.display = 'block';
        }
    }
</script>
</body>
</html>
