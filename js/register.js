particlesJS("particles-js", {
    particles: {
        number: { value: 100, density: { enable: true, value_area: 800 } },
        color: { value: "#ffffff" },
        size: { value: 3 },
        line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
        move: { enable: true, speed: 3 }
    },
    interactivity: {
        detect_on: "canvas",
        events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" }, resize: true },
    },
    retina_detect: true
});

function toggleInfoBox() {
    var infoBox = document.getElementById('infoBox');
    if (infoBox.style.display === 'block') {
        infoBox.style.display = 'none';
    } else {
        infoBox.style.display = 'block';
    }
}
