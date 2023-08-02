<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/favicon.png"><!-- icon that is shown in the browser tab -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="css/main.css"><!-- main css file, other get imported in there -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9d1f4cdd15.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/todo.js"></script>
    <script type="text/javascript" src="js/chatstatistics.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <audio id="mySound" src="audio/button-click2.mp3" style="display:none"></audio>
    <audio id="mySound2" src="audio/button-click.mp3" style="display:none"></audio>
    <!-- React.js -->
    <script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Extras -->
    <link rel="manifest" href="manifest.json">
    <title>Rogue-V | Dashboard</title>
</head>

<!-- Navigation -->
<section class="page-section bg-dark-lighter" id="navigation">
    <div class="container relative">         
        <!-- Navigation grid -->
        <div class="navigation-grid">
            <!-- Navigation -->
            <a href="https://roguev.de" target="_blank">
            <div class="navigation-item animate-init" data-anim-type="fade-in" data-anim-delay="100">
                <div class="navigation-item-descr dark">
                    <div class="navigation-item-name">
                    <i class="fa-solid fa-globe  todoicon"></i>Homepage
                    </div>
                    <div class="navigation-item-role glow-text2">
                        Gelange zurück auf die Hauptseite von Rogue-V
                    </div>
                </div>
            </div>
            </a>
            <!-- End Navigation -->
            <!-- Navigation -->
            <a href="https://roguev.de" target="_blank">
            <div class="navigation-item animate-init" data-anim-type="fade-in" data-anim-delay="100">
                <div class="navigation-item-descr dark">
                    <div class="navigation-item-name">
                    <i class="fa-solid fa-users  todoicon"></i>Forum
                    </div>
                    <div class="navigation-item-role glow-text2">
                        Gelange zu unserem Forum
                    </div>
                </div>
            </div>
            </a>
            <!-- End Navigation -->             
            <!-- Navigation -->
            <a href="https://roguev.de" target="_blank">
            <div class="navigation-item animate-init" data-anim-type="fade-in" data-anim-delay="300">
                <div class="navigation-item-descr dark">
                    <div class="navigation-item-name">
                    <i class="fa-solid fa-server  todoicon"></i>txAdmin
                    </div>
                    <div class="navigation-item-role glow-text2">
                        Gelange auf das txAdmin Dashboard
                    </div>
                </div>
            </div>
            </a>
            <!-- End Navigation -->
            <!-- Navigation -->
            <a href="https://roguev.de" target="_blank">
            <div class="navigation-item animate-init" data-anim-type="fade-in" data-anim-delay="300">
                <div class="navigation-item-descr dark">
                    <div class="navigation-item-name">
                    <i class="fa-solid fa-ticket  todoicon"></i>Ticketsystem
                    </div>
                    <div class="navigation-item-role glow-text2">
                        Siehe dir alle Tickets an, bearbeite oder schließe Sie
                    </div>
                </div>
            </div>
            </a>
            <!-- End Navigation -->                        
        </div>
        <!-- End navigation Grid -->
    </div>
</section>
<!-- End navigation Section -->

<header class="image-header">
        <div class="header-content">
            <h1><img src="https://i.ibb.co/smLg902/Untitled-1.gif" alt="Logo" class="logo-image">ROGUEV - DASHBOARD</h1>
            <div class="subheader-text">Willkommen im Rogue-V Dashboard! Behalte die Wirtschaft sowie weitere wichtige Datenbankeinträge im Blick.</div>
            <div class="logo-image-text">made with<i class="fa-solid fa-heart fa-beat icon-image-text" style="color: #fc5458;"></i>by push.42</div>
        </div>
</header>