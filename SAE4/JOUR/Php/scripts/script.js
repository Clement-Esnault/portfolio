let currentIndex = 0;

function updateCarousel() {
    const carousel = document.querySelector(".carousel");
    const totalSlides = document.querySelectorAll(".review-card").length;
    if (currentIndex < 0) {
        currentIndex = totalSlides - 1;
    } else if (currentIndex >= totalSlides) {
        currentIndex = 0;
    }
    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
}

function prevSlide() {
    currentIndex--;
    updateCarousel();
}

function nextSlide() {
    currentIndex++;
    updateCarousel();
}

// Auto-slide every 5 seconds
setInterval(nextSlide, 5000);
