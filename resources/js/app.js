document.addEventListener('alpine:init', () => {
    Alpine.data('storefrontUi', () => ({
        toast: '',
        toastTimer: null,

        showToast(message) {
            this.toast = message;
            clearTimeout(this.toastTimer);
            this.toastTimer = setTimeout(() => {
                this.toast = '';
            }, 2200);
        },
    }));

    Alpine.data('contactModal', () => ({
        open: false,

        init() {
            this.$watch('open', (isOpen) => {
                document.body.style.overflow = isOpen ? 'hidden' : '';
            });
        },

        openModal() {
            this.open = true;
            this.$nextTick(() => this.$refs.firstField?.focus());
        },

        closeModal() {
            if (!this.open) {
                return;
            }

            this.open = false;
            this.$wire.resetForm();
            this.$dispatch('contact-form-closed');
        },

        complete(message) {
            this.open = false;
            this.$dispatch('contact-form-closed');
            this.$dispatch('store-toast', { message });
        },

        destroy() {
            document.body.style.overflow = '';
        },
    }));

    Alpine.data('heroSlider', () => ({
        slide: 0,
        slides: [
            { kicker: 'Сезонна пропозиція', title: 'ППУ вулики', subtitle: 'для сильних бджолосімей' },
            { kicker: 'Готові рішення', title: 'Пасіка під ключ', subtitle: 'усе необхідне в одному місці' },
            { kicker: 'Якість з України', title: 'Тепло та легко', subtitle: 'надійно у кожному сезоні' },
        ],
        timer: null,

        init() {
            this.timer = setInterval(() => {
                this.slide = (this.slide + 1) % this.slides.length;
            }, 5500);
        },

        destroy() {
            clearInterval(this.timer);
        },
    }));

    Alpine.data('categoryScroller', () => ({
        active: 'all',
        compact: false,
        search: '',
        cartCount: 0,
        dragging: false,
        didDrag: false,
        dragStartX: 0,
        scrollStartX: 0,
        compactScrollHandler: null,

        init() {
            this.compactScrollHandler = () => {
                const top = this.$el.getBoundingClientRect().top;
                this.compact = window.scrollY > 0 && top <= 0;
            };

            this.compactScrollHandler();
            window.addEventListener('scroll', this.compactScrollHandler, { passive: true });
        },

        searchCatalog() {
            Livewire.dispatch('catalog-search', { search: this.search.trim() });
        },

        syncSearch(search = '') {
            this.search = search ?? '';
        },

        openCart() {
            this.$dispatch('cart-open-requested');
            this.$dispatch('store-toast', {
                message: `У кошику: ${this.cartCount} товарів`,
            });
        },

        handleWheel(event) {
            if (Math.abs(event.deltaY) <= Math.abs(event.deltaX)) {
                return;
            }

            event.preventDefault();
            event.currentTarget.scrollLeft += event.deltaY;
        },

        startDrag(event) {
            if (event.pointerType !== 'mouse' || event.button !== 0) {
                return;
            }

            this.dragging = true;
            this.didDrag = false;
            this.dragStartX = event.clientX;
            this.scrollStartX = event.currentTarget.scrollLeft;
            event.currentTarget.setPointerCapture(event.pointerId);
        },

        drag(event) {
            if (!this.dragging) {
                return;
            }

            const distance = event.clientX - this.dragStartX;
            this.didDrag = Math.abs(distance) > 5;
            event.currentTarget.scrollLeft = this.scrollStartX - distance;
        },

        endDrag(event) {
            if (!this.dragging) {
                return;
            }

            this.dragging = false;
            if (event.currentTarget.hasPointerCapture(event.pointerId)) {
                event.currentTarget.releasePointerCapture(event.pointerId);
            }
        },

        selectCategory(event, category) {
            if (this.didDrag) {
                event.preventDefault();
                this.didDrag = false;
                return;
            }

            this.active = category;
            Livewire.dispatch('category-selected', { category });
            document.querySelector('#catalog')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        },

        destroy() {
            window.removeEventListener('scroll', this.compactScrollHandler);
        },
    }));

    Alpine.data('bottomNavigation', (initialActive = 'home') => ({
        active: initialActive,
        hidden: false,
        showScrollTop: false,
        lastScrollY: 0,
        scrollTimer: null,
        scrollHandler: null,

        init() {
            this.lastScrollY = window.scrollY;
            this.showScrollTop = this.lastScrollY > 280;
            this.scrollHandler = () => {
                const currentScrollY = Math.max(window.scrollY, 0);
                const isScrollingDown = currentScrollY > this.lastScrollY + 1;
                const isScrollingUp = currentScrollY < this.lastScrollY - 1;

                if (isScrollingDown && currentScrollY > 10) {
                    this.hidden = true;
                } else if (isScrollingUp || currentScrollY <= 10) {
                    this.hidden = false;
                }

                this.lastScrollY = currentScrollY;
                this.showScrollTop = currentScrollY > 280;
                clearTimeout(this.scrollTimer);
                this.scrollTimer = setTimeout(() => {
                    this.hidden = false;
                }, 160);
            };

            window.addEventListener('scroll', this.scrollHandler, { passive: true });
        },

        scrollToTop() {
            this.hidden = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        destroy() {
            clearTimeout(this.scrollTimer);
            window.removeEventListener('scroll', this.scrollHandler);
        },
    }));
});
