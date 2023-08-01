<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style_login.css">
    <link rel="shortcut icon" href="img/favicon.png">
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9d1f4cdd15.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <title>Login</title>
</head>
<body>
    <div id="particles-js"></div>
    <div class="login-container">
        <img src="https://i.ibb.co/smLg902/Untitled-1.gif" alt="Logo" class="logo-image">
        <h2>ROGUE-V DASHBOARD</h2>
        <p>Willkommen, bitte melde dich an.</p>
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            include "login_handler.php";
            include "gather_info.php";
        ?>
        <form method="post" action="">
        <div class="login-username">
            <label></label>
        </div>
        <i class="fa-solid fa-user-shield form-icons" style="color: #ffffff;"></i><input type="text" name="username" required>
        <div class="login-username">
            <label></label>
        <div>
        <i class="fa-solid fa-lock form-icons2" style="color: #ffffff;"></i><input type="password" name="password" required>
        <div class="spacer01"><i class="fa-solid fa-info hinweis"></i>Solltest du noch keinen Account haben,</br> melde dich bitte im Discord im Teamchannel.</div>
            <input type="submit" value="ANMELDEN">
        </form>
        <div class="madeby"><i class="fa-solid fa-heart fa-beat iconsfont" style="color: #ff0000;"></i>made by push42
            <i class="fa-brands fa-discord fa-beat iconsfont" style="color: #1395ff;"></i>dsc.gg/roguev
        </div>
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
    </script>
</body>
</html>