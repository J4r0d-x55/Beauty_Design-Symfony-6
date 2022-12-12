// Menu Hamburger

const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
})

document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}))

window.addEventListener("scroll", function() {
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
})

// -----------------------------------------------------------

// Flower Animation avec gsap

const titre = document.querySelector('h1');
const imgs = document.querySelectorAll('img');

// Ordre d'apparition des images en utilisant une timeline
const TL = gsap.timeline({paused: true});
// Durée entre chaque apparition d'image avec stagger
TL
.to(imgs, {scale: 1, duration: 0.5, stagger: 0.1, ease: "back.out(1.5)"});

titre.addEventListener('mouseenter', () =>{
    TL.play();
})

// ------------------------------------------------------------

// Slider

gsap.set('main', {
    perspective: 700
});
var slides = document.querySelectorAll('.slide'),
    tl = gsap.timeline({
        paused: true,
    });

let pauseTl = function (e) {
      tl.seek(e.target.id).pause();
    };

for (var i = 0; i < slides.length; i++) {
    var D = document.createElement('div');
    D.className = 'Dot';
    D.id = 'Dot' + i;
    D.addEventListener('click', pauseTl);
    document.getElementById('Dots').appendChild(D);
    tl.addPause('Dot' + i);
    if (i != slides.length - 1) {
        tl.to(slides[i], 0.5, {
                scale: 0.8,
                ease: "back.easeOut"
            })
            .to(slides[i], 0.7, {
                xPercent: -100,
                rotationY: 80
            }, 'L' + i)
            .from(slides[i + 1], 0.7, {
                xPercent: 100,
                rotationY: -80
            }, 'L' + i)
            .to('#Dot' + i, 0.7, {
                backgroundColor: 'rgba(255,255,255,0.2)'
            }, 'L' + i)
            .from(slides[i + 1], 0.5, {
                scale: 0.8,
                ease: "back.easeIn"
            });
    }
}

function GO(e) {
    var SD = isNaN(e) ? e.wheelDelta || -e.detail : e;
    if (SD < 0) {
        tl.play();
    } else {
        tl.reverse();
    }
}

document.addEventListener("mousewheel", GO);
document.addEventListener("DOMMouseScroll", GO);
document.getElementById('nextBtn').addEventListener("click", function () {
    GO(-1);
});
document.getElementById('prevtBtn').addEventListener("click", function () {
    GO(1);
});


