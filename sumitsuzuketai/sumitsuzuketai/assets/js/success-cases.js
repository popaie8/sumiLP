// success-cases.js
document.addEventListener('DOMContentLoaded', function() {
  // Initialize testimonial carousel
  function initSuccessCases() {
    // Get all necessary elements
    const slides = document.querySelectorAll('.sc-slide');
    const dots = document.querySelectorAll('.sc-dot');
    const prevButton = document.querySelector('.sc-nav-prev');
    const nextButton = document.querySelector('.sc-nav-next');
    const totalSlides = slides.length;
    let currentSlide = 0;
    let autoplayTimer = null;
    const autoplayDelay = 6000; // 6 seconds between auto slides
    
    // Function to show a specific slide
    function showSlide(index) {
      // Reset autoplay timer
      if (autoplayTimer) {
        clearTimeout(autoplayTimer);
      }
      
      // Hide all slides
      slides.forEach(slide => {
        slide.classList.remove('active');
      });
      
      // Deactivate all dots
      dots.forEach(dot => {
        dot.classList.remove('active');
      });
      
      // Show the selected slide
      slides[index].classList.add('active');
      
      // Activate the corresponding dot
      dots[index].classList.add('active');
      
      // Update current slide index
      currentSlide = index;
      
      // Start autoplay again
      startAutoplay();
    }
    
    // Function to go to the next slide
    function nextSlide() {
      let newIndex = currentSlide + 1;
      if (newIndex >= totalSlides) {
        newIndex = 0;
      }
      showSlide(newIndex);
    }
    
    // Function to go to the previous slide
    function prevSlide() {
      let newIndex = currentSlide - 1;
      if (newIndex < 0) {
        newIndex = totalSlides - 1;
      }
      showSlide(newIndex);
    }
    
    // Function to start autoplay
    function startAutoplay() {
      autoplayTimer = setTimeout(function() {
        nextSlide();
      }, autoplayDelay);
    }
    
    // Add click event to dots
    dots.forEach(dot => {
      dot.addEventListener('click', function() {
        const slideIndex = parseInt(this.getAttribute('data-slide'));
        showSlide(slideIndex);
      });
    });
    
    // Add click event to prev button
    prevButton.addEventListener('click', function(e) {
      e.preventDefault();
      prevSlide();
    });
    
    // Add click event to next button
    nextButton.addEventListener('click', function(e) {
      e.preventDefault();
      nextSlide();
    });
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
      if (e.key === 'ArrowLeft') {
        prevSlide();
      } else if (e.key === 'ArrowRight') {
        nextSlide();
      }
    });
    
    // Pause autoplay on hover
    const carousel = document.querySelector('.sc-carousel');
    carousel.addEventListener('mouseenter', function() {
      if (autoplayTimer) {
        clearTimeout(autoplayTimer);
      }
    });
    
    // Resume autoplay on mouse leave
    carousel.addEventListener('mouseleave', function() {
      startAutoplay();
    });
    
    // Add swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    carousel.addEventListener('touchstart', function(e) {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    
    carousel.addEventListener('touchend', function(e) {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
      const threshold = 50; // Minimum distance for swipe
      
      if (touchEndX < touchStartX - threshold) {
        // Swipe left, show next slide
        nextSlide();
      } else if (touchEndX > touchStartX + threshold) {
        // Swipe right, show previous slide
        prevSlide();
      }
    }
    
    // Initialize with the first slide and start autoplay
    showSlide(0);
    startAutoplay();
  }
  
  // Initialize the carousel when the DOM is ready
  initSuccessCases();
});