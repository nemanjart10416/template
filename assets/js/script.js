/*
* USAGE: new bootstrapCarousel('carouselID').init();
* */
var bootstrapCarousel = function (customID) {
    this.carousel = document.getElementById(customID);
    this.slides = this.carousel.querySelectorAll('.carousel-item');
    this.indicators = this.carousel.querySelectorAll('.carousel-indicators button');
    this.currentSlide = 0;

    this.showSlide = (slideIndex) => {
        this.slides[this.currentSlide].classList.remove('active');
        this.slides[slideIndex].classList.add('active');
        this.indicators[this.currentSlide].classList.remove('active');
        this.indicators[slideIndex].classList.add('active');
        this.currentSlide = slideIndex;
    };

    this.init = () => {
        this.carousel.querySelector('.carousel-control-prev').addEventListener('click', () => {
            const prevSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.showSlide(prevSlide);
        });

        this.carousel.querySelector('.carousel-control-next').addEventListener('click', () => {
            const nextSlide = (this.currentSlide + 1) % this.slides.length;
            this.showSlide(nextSlide);
        });

        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.showSlide(index);
            });
        });
    }
}

new bootstrapCarousel('carouselExampleIndicators').init();

/*
* USAGE: new bootstrapNavbar().init();
* */
var BootstrapNavbar = function () {
    this.navbarTogglerButton = document.querySelector('.navbar-toggler');
    this.navbarCollapse = document.getElementById('navbarSupportedContent');
    this.dropdowns = document.querySelectorAll('.nav-item.dropdown');

    this.init = () => {
        // Toggle navbar collapse on button click
        this.navbarTogglerButton.addEventListener('click', () => {
            const isExpanded = this.navbarCollapse.classList.toggle('show');
            this.navbarTogglerButton.setAttribute('aria-expanded', isExpanded);
        });

        // Handle each dropdown toggle for custom dropdown behavior
        this.dropdowns.forEach(dropdown => {
            const dropdownToggle = dropdown.querySelector('.nav-link.dropdown-toggle');
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');

            dropdownToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const isShown = dropdownMenu.classList.toggle('show');
                dropdownToggle.setAttribute('aria-expanded', isShown);
            });
        });

        // Close dropdowns and collapse menu when clicking outside
        document.addEventListener('click', (e) => {
            this.dropdowns.forEach(dropdown => {
                const dropdownMenu = dropdown.querySelector('.dropdown-menu');
                if (!dropdown.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                    dropdown.querySelector('.nav-link.dropdown-toggle').setAttribute('aria-expanded', 'false');
                }
            });

            if (!this.navbarCollapse.contains(e.target) && !this.navbarTogglerButton.contains(e.target)) {
                this.navbarCollapse.classList.remove('show');
                this.navbarTogglerButton.setAttribute('aria-expanded', 'false');
            }
        });

        // Close all dropdowns and collapse on window resize
        window.addEventListener('resize', () => {
            this.dropdowns.forEach(dropdown => {
                dropdown.querySelector('.dropdown-menu').classList.remove('show');
                dropdown.querySelector('.nav-link.dropdown-toggle').setAttribute('aria-expanded', 'false');
            });
            this.navbarCollapse.classList.remove('show');
            this.navbarTogglerButton.setAttribute('aria-expanded', 'false');
        });
    }
}

new BootstrapNavbar().init();

