(function () {
    'use strict';

    function initCarousel(root) {
        if (!root) return;

        var slides = root.querySelectorAll('.carousel-slide');
        var dots = root.querySelectorAll('.carousel-dot');
        var count = slides.length;
        if (!count) return;

        var index = 0;
        var timer = null;
        var DELAY = 2000;
        var motionOk =
            !(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);

        function paint(i, on) {
            slides[i].classList.toggle('is-active', on);
            slides[i].setAttribute('aria-hidden', on ? 'false' : 'true');
            if (dots[i]) {
                dots[i].classList.toggle('is-active', on);
                dots[i].setAttribute('aria-selected', on ? 'true' : 'false');
            }
        }

        function show(next) {
            next = (next % count + count) % count;
            if (next === index) return;
            paint(index, false);
            index = next;
            paint(index, true);
        }

        function stop() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        function play() {
            stop();
            if (count > 1 && motionOk) {
                timer = setInterval(function () { show(index + 1); }, DELAY);
            }
        }

        function move(delta) {
            show(index + delta);
            play();
        }

        var prev = root.querySelector('.carousel-prev');
        var next = root.querySelector('.carousel-next');

        if (prev) prev.addEventListener('click', function () { move(-1); });
        if (next) next.addEventListener('click', function () { move(1); });

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                show(parseInt(dot.dataset.index, 10) || 0);
                play();
            });
        });

        root.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') { e.preventDefault(); move(-1); }
            if (e.key === 'ArrowRight') { e.preventDefault(); move(1); }
        });

        play();
    }

    document.querySelectorAll('.imgcarousel').forEach(initCarousel);
})();