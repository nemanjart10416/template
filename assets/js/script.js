/*
 * USAGE: new lightBox("class").init();
 */
var lightBox = function (imgClass) {
    this.galleryItems = document.querySelectorAll('.'+imgClass);
    this.currentIndex = 0;

    this.createModal = () => {
        this.modal = document.createElement("div");
        this.modal.classList.add("lightbox-modal");

        this.closeBtn = document.createElement("span");
        this.closeBtn.classList.add("lightbox-close");
        this.closeBtn.innerHTML = "&times;";
        this.modal.appendChild(this.closeBtn);

        var navigation = document.createElement("div");
        navigation.classList.add("lightbox-navigation");

        this.prevBtn = document.createElement("button");
        this.prevBtn.classList.add("lightbox-prev");
        this.prevBtn.innerHTML="&lt;";
        navigation.appendChild(this.prevBtn);

        this.nextBtn = document.createElement("button");
        this.nextBtn.classList.add("lightbox-next");
        this.nextBtn.innerHTML="&gt;";
        navigation.appendChild(this.nextBtn);

        this.modal.appendChild(navigation);

        this.modalImage = document.createElement("img");
        this.modalImage.classList.add("lightbox-modal-content");
        this.modal.appendChild(this.modalImage);

        document.body.appendChild(this.modal);
    }

    this.setListeners = () => {
        this.galleryItems.forEach((item, index) => {
            item.style.cursor = "pointer";
            item.addEventListener('click', () => {
                this.openModal(index);
            });
        });

        this.closeBtn.addEventListener('click', () => {
            this.modal.style.display = 'none';
        });

        this.prevBtn.addEventListener('click', () => {
            this.currentIndex = (this.currentIndex - 1 + this.galleryItems.length) % this.galleryItems.length;
            this.openModal(this.currentIndex);
            console.log("button")
            console.log(this.galleryItems)
        });

        this.nextBtn.addEventListener('click', () => {
            this.currentIndex = (this.currentIndex + 1) % this.galleryItems.length;
            this.openModal(this.currentIndex);
            console.log("button")
            console.log(this.galleryItems)
        });

        window.addEventListener('click', (event) => {
            if (event.target === this.modal) {
                this.modal.style.display = 'none';
            }
        });
    }

    this.init = () => {
        this.createModal();
        this.setListeners();
    }

    this.openModal = (index) => {
        this.modal.style.display = 'block';
        this.modalImage.src = this.galleryItems[index].src;
        this.currentIndex = index;
    }
}

var navbarSetup = () => {
    var navbarDropdown = document.getElementById("navbarDropdown");
    var dropdownmenu = document.getElementsByClassName("dropdown-menu");
    var navbartoggler = document.getElementsByClassName("navbar-toggler");
    var navbarcollapse = document.getElementsByClassName("navbar-collapse");

    window.addEventListener("click",(e)=>{
        if(!e.target.closest(".navbar-toggler") && !e.target.closest(".collapse")){
            navbarcollapse[0].classList.remove("show");
            navbartoggler[0].classList.add("collapsed");
        }
    });

    if(navbartoggler.length>0 && navbarcollapse.length>0){
        ['click'].forEach((event)=>{
            navbartoggler[0].addEventListener(event,(e)=>{
                console.log("click");
                if(e.target.classList.contains("collapsed")){
                    navbarcollapse[0].classList.add("show");
                    e.target.classList.remove("collapsed");
                }else{
                    navbarcollapse[0].classList.remove("show");
                    e.target.classList.add("collapsed");
                }
            });
        });
    }
}


navbarSetup();
