import '@fontsource-variable/inter';
import '@fontsource/bebas-neue';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

/* ---- Scroll-reveal: IntersectionObserver adds .revealed ---- */
Alpine.data('revealOnScroll', () => ({
    init() {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
        );
        this.$el.querySelectorAll('[x-reveal]').forEach((el) => observer.observe(el));
        // Also observe the host element itself if it has x-reveal
        if (this.$el.hasAttribute('x-reveal')) observer.observe(this.$el);
    },
}));

/* ---- Count-up animation for stat numbers ---- */
Alpine.data('countUp', () => ({
    target: 0,
    current: 0,
    suffix: '',
    init() {
        this.target = parseInt(this.$el.dataset.count ?? '0', 10);
        this.suffix = this.$el.dataset.suffix ?? '';
        this.$el.textContent = '0' + this.suffix;

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        this.animate();
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.3 }
        );
        observer.observe(this.$el);
    },
    animate() {
        const duration = 1800;
        const start = performance.now();
        const ease = (t) => 1 - Math.pow(1 - t, 3); // ease-out cubic

        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            this.current = Math.round(ease(progress) * this.target);
            this.$el.textContent = this.current + this.suffix;
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    },
}));

window.Alpine = Alpine;

Alpine.start();
