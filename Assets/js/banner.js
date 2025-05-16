let currentIndex = 0;
    const slides = document.getElementById('slides');
    const totalSlides = 3;

    function updateSlide() {
      slides.style.transform = `translateX(-${currentIndex * 40}%)`;
    }

    function nextSlide() {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateSlide();
    }

    function prevSlide() {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      updateSlide();
    }
    setInterval(nextSlide, 2500);