console.log('custom.js loaded - gift and gallery modules available');

const openBtn = document.getElementById('openInvitationBtn');
const closeBtn = document.getElementById('closeBtn');
const landingContainer = document.getElementById('landingContainer');
const invitationPanel = document.getElementById('invitationPanel');
const panelRight = document.querySelector('.panel-right');

// ==================== SLIDE TRANSITIONS ====================
// Open Invitation with improved animation
openBtn.addEventListener('click', function() {
    landingContainer.classList.add('slide-out');
    invitationPanel.classList.add('show');

    // Play video
    const panelVideo = document.getElementById('panelVideoBg');
    if (panelVideo) {
        panelVideo.play().catch(err => {
            console.log('Video autoplay failed:', err);
        });
    }

    // Scroll to top of invitation panel
    setTimeout(() => {
        if (panelRight) panelRight.scrollTop = 0;
    }, 300);
});

// Close Invitation
closeBtn.addEventListener('click', function() {
    landingContainer.classList.remove('slide-out');
    invitationPanel.classList.remove('show');
});

// Close when clicking outside (on landing area)
landingContainer.addEventListener('click', function(e) {
    if (e.target === landingContainer) {
        closeBtn.click();
    }
});

// ==================== AUDIO TOGGLE ====================
function initAudioToggle() {
    const panelVideo = document.getElementById('panelVideoBg');
    const audioToggleBtn = document.getElementById('panelAudioToggle');

    if (!audioToggleBtn || !panelVideo) {
        console.warn('Audio toggle or video element not found');
        return;
    }

    // Initialize audio as muted
    panelVideo.muted = true;
    updateAudioButtonState();

    audioToggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        panelVideo.muted = !panelVideo.muted;
        updateAudioButtonState();
    });

    function updateAudioButtonState() {
        if (panelVideo.muted) {
            audioToggleBtn.classList.add('muted');
            audioToggleBtn.title = 'Unmute Audio';
            audioToggleBtn.innerHTML = '<span class="audio-icon">🔇</span>';
        } else {
            audioToggleBtn.classList.remove('muted');
            audioToggleBtn.title = 'Mute Audio';
            audioToggleBtn.innerHTML = '<span class="audio-icon">🔊</span>';
        }
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAudioToggle);
} else {
    initAudioToggle();
}

// ==================== COUNTDOWN TIMER ====================
// Target date: 17 Januari 2026, 08:00
function updateCountdown() {
    const weddingDate = new Date('2026-01-17T08:00:00').getTime();
    const now = new Date().getTime();
    const distance = weddingDate - now;

    if (distance > 0) {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
        if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
        if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
        if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
    }
}

updateCountdown();
setInterval(updateCountdown, 1000);

// ==================== SCROLL ANIMATIONS ====================
// Smooth scroll animations for elements
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('scroll-animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Target all right-section elements for animation
    const sections = document.querySelectorAll('.right-section');
    sections.forEach((section) => {
        section.classList.add('scroll-animate');
        observer.observe(section);
    });
}

// Initialize scroll animations when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollAnimations);
} else {
    initScrollAnimations();
}

// ==================== GIFT MODAL ====================
// Function to create and manage gift modal
function initGiftModal() {
    const giftBtn = document.querySelector('.btn-gift');

    console.log('Gift button found:', giftBtn);
    if (!giftBtn) {
        console.warn('Gift button (.btn-gift) not found in DOM');
        return;
    }

    // Create modal HTML
    const modalHTML = `
        <div class="gift-modal" id="giftModal">
            <div class="gift-modal-content">
                <button class="gift-modal-close" id="giftModalClose">&times;</button>

                <p class="gift-modal-title">Silakan transfer hadiah melalui nomor rekening berikut:</p>

                <div class="bank-account-card">
                    <div class="bank-account-content">
                        <div class="bank-name">BCA</div>
                        <div class="bank-account-wrapper">
                            <span class="bank-account-number">xxxxxx</span>
                            <button class="copy-btn" data-account="xxxxxxx" title="Copy account number">📋</button>
                        </div>
                        <div class="bank-account-name">xxxxxxxxxx</div>
                    </div>
                </div>

                <div class="bank-account-card">
                    <div class="bank-account-content">
                        <div class="bank-name">BCA</div>
                        <div class="bank-account-wrapper">
                            <span class="bank-account-number">xxxxxx</span>
                            <button class="copy-btn" data-account="xxxxx" title="Copy account number">📋</button>
                        </div>
                        <div class="bank-account-name">xxxxxxx</div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Insert modal into the page
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const giftModal = document.getElementById('giftModal');
    const giftModalClose = document.getElementById('giftModalClose');
    const copyButtons = document.querySelectorAll('.copy-btn');

    // Open modal
    giftBtn.addEventListener('click', function() {
        console.log('Gift button clicked!');
        giftModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    // Close modal
    function closeModal() {
        giftModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    giftModalClose.addEventListener('click', closeModal);

    // Close modal when clicking outside
    giftModal.addEventListener('click', function(e) {
        if (e.target === giftModal) {
            closeModal();
        }
    });

    // Copy to clipboard functionality
    copyButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const accountNumber = this.getAttribute('data-account');
            navigator.clipboard.writeText(accountNumber).then(() => {
                const originalText = btn.textContent;
                btn.textContent = '✓';
                btn.style.color = '#d4af8a';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.color = '#d4af8a';
                }, 2000);
            });
        });
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && giftModal.classList.contains('active')) {
            closeModal();
        }
    });
}

// Initialize gift modal when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGiftModal);
} else {
    initGiftModal();
}

// ==================== GALLERY LIGHTBOX ====================
function initGalleryLightbox() {
    const galleryImages = document.querySelectorAll('.gallery-img');
    const couplePhoto = document.querySelector('.couple-photo');

    console.log('Gallery images found:', galleryImages.length);
    if (galleryImages.length === 0 && !couplePhoto) {
        console.warn('No gallery images (.gallery-img) or couple photo found in DOM');
        return;
    }

    // Create lightbox HTML
    const lightboxHTML = `
        <div class="gallery-lightbox" id="galleryLightbox">
            <button class="lightbox-close" id="lightboxClose">&times;</button>
            <button class="lightbox-prev" id="lightboxPrev">❮</button>
            <button class="lightbox-next" id="lightboxNext">❯</button>
            <div class="lightbox-container">
                <img class="lightbox-image" id="lightboxImage" src="" alt="Gallery image">
            </div>
            <div class="lightbox-counter">
                <span id="currentImage">1</span> / <span id="totalImages">1</span>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', lightboxHTML);

    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxClose = document.getElementById('lightboxClose');
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');
    const currentImageSpan = document.getElementById('currentImage');
    const totalImagesSpan = document.getElementById('totalImages');

    let currentIndex = 0;
    const images = [];

    // Add couple photo first if it exists
    if (couplePhoto) {
        images.push(couplePhoto.src);
        couplePhoto.style.cursor = 'pointer';
        couplePhoto.addEventListener('click', () => {
            console.log('Couple photo clicked');
            openLightbox(0);
        });
    }

    // Add gallery images
    galleryImages.forEach(img => {
        images.push(img.src);
    });

    totalImagesSpan.textContent = images.length;

    function showImage(index) {
        if (index < 0) currentIndex = images.length - 1;
        if (index >= images.length) currentIndex = 0;

        lightboxImage.src = images[currentIndex];
        currentImageSpan.textContent = currentIndex + 1;
    }

    function openLightbox(index) {
        currentIndex = index;
        showImage(currentIndex);
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Add click listeners to gallery images
    galleryImages.forEach((img) => {
        img.addEventListener('click', () => {
            const imageIndex = images.indexOf(img.src);
            console.log('Gallery image clicked:', imageIndex);
            openLightbox(imageIndex);
        });
        img.style.cursor = 'pointer';
    });

    // Lightbox controls
    lightboxClose.addEventListener('click', closeLightbox);
    lightboxPrev.addEventListener('click', () => {
        currentIndex--;
        showImage(currentIndex);
    });
    lightboxNext.addEventListener('click', () => {
        currentIndex++;
        showImage(currentIndex);
    });

    // Close when clicking outside the image
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox.classList.contains('active')) return;

        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') {
            currentIndex--;
            showImage(currentIndex);
        }
        if (e.key === 'ArrowRight') {
            currentIndex++;
            showImage(currentIndex);
        }
    });
}

// Initialize gallery lightbox when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGalleryLightbox);
} else {
    initGalleryLightbox();
}

// ==================== COUPLE VIDEO PLAYBACK ====================
function initCoupleVideoPlayback() {
    const coupleVideo = document.getElementById('coupleVideo');

    if (!coupleVideo) {
        console.warn('Couple video element not found');
        return;
    }

    // Video load event - check if video loaded properly
    coupleVideo.addEventListener('loadedmetadata', () => {
        console.log('Couple video metadata loaded successfully');
    });

    // Video error handling
    coupleVideo.addEventListener('error', (e) => {
        const error = coupleVideo.error;
        if (error) {
            console.error('Video playback error:', error.message, 'Code:', error.code);
            if (error.code === error.MEDIA_ERR_SRC_NOT_SUPPORTED) {
                console.error('The video format is not supported by this browser');
            }
        }
    });

    // Handle source error
    const sources = coupleVideo.querySelectorAll('source');
    sources.forEach(source => {
        source.addEventListener('error', () => {
            console.error('Failed to load video source:', source.src);
        });
    });

    // Request screen orientation to landscape when entering fullscreen
    function requestOrientationLandscape() {
        if (screen.orientation && screen.orientation.lock) {
            screen.orientation.lock('landscape').then(() => {
                console.log('Screen locked to landscape');
            }).catch(err => {
                console.log('Could not lock screen orientation:', err);
            });
        }
    }

    // Restore screen orientation when exiting fullscreen
    function exitOrientationLock() {
        if (screen.orientation && screen.orientation.unlock) {
            screen.orientation.unlock();
            console.log('Screen orientation unlocked');
        }
    }

    // Fullscreen with cross-browser support
    function requestFullscreen(element) {
        const fsRequest = element.requestFullscreen
            || element.webkitRequestFullscreen
            || element.mozRequestFullScreen
            || element.msRequestFullscreen;

        if (fsRequest) {
            fsRequest.call(element).then(() => {
                console.log('Fullscreen entered successfully');
                requestOrientationLandscape();
                coupleVideo.play().catch(err => console.log('Play after fullscreen failed:', err));
            }).catch(err => {
                console.error('Fullscreen request failed:', err);
            });
        }
    }

    // Handle fullscreen exit
    document.addEventListener('fullscreenchange', () => {
        if (!document.fullscreenElement && !document.webkitFullscreenElement) {
            console.log('Exiting fullscreen');
            exitOrientationLock();
        }
    });

    document.addEventListener('webkitfullscreenchange', () => {
        if (!document.webkitFullscreenElement) {
            console.log('Exiting fullscreen (webkit)');
            exitOrientationLock();
        }
    });

    // Allow fullscreen on double-click
    coupleVideo.addEventListener('dblclick', function(e) {
        e.preventDefault();
        console.log('Double-click detected, requesting fullscreen');
        requestFullscreen(coupleVideo);
    });

    // Also allow fullscreen when tapping the video on mobile
    coupleVideo.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            console.log('Mobile tap detected, requesting fullscreen');
            requestFullscreen(coupleVideo);
        }
    });

    // Video can be played directly with native controls
    coupleVideo.style.cursor = 'pointer';
}

// Initialize couple video when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCoupleVideoPlayback);
} else {
    initCoupleVideoPlayback();
}

// ==================== WISHES SUBMISSION ====================
function initWishesSection() {
    const wishesInput = document.querySelector('.wishes-input');
    const wishesTextarea = document.querySelector('.wishes-textarea');
    const sendBtn = document.querySelector('.btn-send');
    const wishesList = document.querySelector('.wishes-list');

    if (!wishesInput || !wishesTextarea || !sendBtn) {
        console.warn('Wishes section elements not found');
        return;
    }

    // Load existing wishes on page load
    loadWishes();

    // Handle send button click
    sendBtn.addEventListener('click', submitWish);

    // Allow Enter key in textarea to submit (Ctrl+Enter)
    wishesTextarea.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && e.ctrlKey) {
            submitWish();
        }
    });

    async function submitWish() {
        const name = wishesInput.value.trim();
        const text = wishesTextarea.value.trim();

        if (!name || !text) {
            alert('Mohon isi nama dan ucapan/doa Anda');
            return;
        }

        // Show loading state
        const originalText = sendBtn.textContent;
        sendBtn.textContent = 'SENDING...';
        sendBtn.disabled = true;

        try {
            const response = await fetch('/api/wishes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ name, text })
            });

            const data = await response.json();

            if (response.ok) {
                // Clear inputs
                wishesInput.value = '';
                wishesTextarea.value = '';

                // Add new wish to the list
                if (data.wish) {
                    addWishToList(data.wish);
                }

                console.log('Wish submitted successfully');
            } else {
                alert('Gagal mengirim ucapan. Silakan coba lagi.');
                console.error('Error:', data.message);
            }
        } catch (error) {
            console.error('Error submitting wish:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            sendBtn.textContent = originalText;
            sendBtn.disabled = false;
        }
    }

    async function loadWishes() {
        try {
            const response = await fetch('/api/wishes');
            const data = await response.json();

            if (response.ok && data.wishes) {
                // Clear existing wishes (except the default ones)
                const wishItems = wishesList.querySelectorAll('.wish-item');
                wishItems.forEach(item => item.remove());

                // Add wishes to list
                data.wishes.forEach(wish => {
                    addWishToList(wish);
                });
            }
        } catch (error) {
            console.error('Error loading wishes:', error);
        }
    }

    function addWishToList(wish) {
        const wishHTML = `
            <div class="wish-item">
                <p class="wish-author">${escapeHtml(wish.name)}</p>
                <p class="wish-text">${escapeHtml(wish.text)}</p>
            </div>
        `;
        wishesList.insertAdjacentHTML('beforeend', wishHTML);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize wishes section when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWishesSection);
} else {
    initWishesSection();
}

// ==================== LOCATION BUTTON ====================
function initLocationButton() {
    const locationButtons = document.querySelectorAll('.btn-location');

    if (locationButtons.length === 0) {
        console.warn('Location buttons (.btn-location) not found');
        return;
    }

    locationButtons.forEach(btn => {
        btn.removeEventListener('click', handleLocationClick);
        btn.addEventListener('click', handleLocationClick);
    });
}

function handleLocationClick(e) {
    e.preventDefault();
    window.open('https://maps.app.goo.gl/PV3DLW1Ngjeua5Eu6', '_blank');
}

// Initialize location button with multiple timing strategies
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLocationButton);
} else {
    initLocationButton();
}

// Also try after a short delay to catch dynamic content
setTimeout(initLocationButton, 100);
