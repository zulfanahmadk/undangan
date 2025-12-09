/**
 * Custom JS for Wedding Invitation
 * Fixed & Optimized
 */

console.log('custom.js loaded - waiting for DOM...');

// Global audio element for backsound
let backsoundAudio = null;

// ==================== 1. MAIN INVITATION LOGIC (OPEN/CLOSE) ====================
function initInvitationController() {
    const openBtn = document.getElementById('openInvitationBtn');
    const closeBtn = document.getElementById('closeBtn');
    const landingContainer = document.getElementById('landingContainer');
    const invitationPanel = document.getElementById('invitationPanel');
    const panelRight = document.querySelector('.panel-right');
    const panelVideo = document.getElementById('panelVideoBg');

    // Safety check: Jika elemen tidak ditemukan, stop agar tidak error
    if (!openBtn || !landingContainer || !invitationPanel) {
        console.warn('Invitation control elements missing (openInvitationBtn/landingContainer/invitationPanel)');
        return;
    }

    // Create backsound audio element if not exists
    if (!backsoundAudio) {
        backsoundAudio = new Audio('./lagu/backsound.mp3');
        backsoundAudio.loop = true;
        backsoundAudio.volume = 1;
    }

    // Open Invitation
    openBtn.addEventListener('click', function() {
        landingContainer.classList.add('slide-out');
        invitationPanel.classList.add('show');

        // Play backsound audio
        if (backsoundAudio) {
            backsoundAudio.play().catch(err => {
                console.log('Audio autoplay failed:', err);
            }).then(() => {
                // Update button state after audio starts playing
                updateAudioToggleState();
            });
        }

        // Play video background if exists
        if (panelVideo) {
            panelVideo.play().catch(err => {
                console.log('Video autoplay failed:', err);
            });
        }

        // Scroll to top of invitation panel smoothly
        setTimeout(() => {
            if (panelRight) panelRight.scrollTop = 0;
            window.scrollTo(0, 0);
        }, 300);
    });

    // Close Invitation
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            landingContainer.classList.remove('slide-out');
            invitationPanel.classList.remove('show');

            // Pause backsound audio when closing
            if (backsoundAudio) {
                backsoundAudio.pause();
                backsoundAudio.currentTime = 0;
            }
        });
    }

    // Close when clicking outside (on landing area/overlay)
    landingContainer.addEventListener('click', function(e) {
        if (e.target === landingContainer && closeBtn) {
            closeBtn.click();
        }
    });
}

// Helper function to update audio toggle button state
function updateAudioToggleState() {
    const audioToggleBtn = document.getElementById('panelAudioToggle');

    if (!audioToggleBtn) return;

    if (!backsoundAudio || backsoundAudio.paused) {
        audioToggleBtn.classList.add('muted');
        audioToggleBtn.title = 'Unmute Audio';
        audioToggleBtn.innerHTML = '<span class="audio-icon">🔇</span>';
    } else {
        audioToggleBtn.classList.remove('muted');
        audioToggleBtn.title = 'Mute Audio';
        audioToggleBtn.innerHTML = '<span class="audio-icon">🔊</span>';
    }
}

// ==================== 2. AUDIO TOGGLE ====================
function initAudioToggle() {
    const audioToggleBtn = document.getElementById('panelAudioToggle');

    if (!audioToggleBtn) {
        console.warn('Audio toggle button not found');
        return;
    }

    // Initialize audio toggle state
    updateAudioToggleState();

    audioToggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (backsoundAudio) {
            if (backsoundAudio.paused) {
                backsoundAudio.play().catch(err => {
                    console.log('Audio play failed:', err);
                });
            } else {
                backsoundAudio.pause();
            }
            updateAudioToggleState();
        }
    });
}

// ==================== 3. COUNTDOWN TIMER ====================
function initCountdown() {
    // Target date: 17 Januari 2026, 08:00
    const weddingDate = new Date('2026-01-17T08:00:00').getTime();

    function updateTimer() {
        const now = new Date().getTime();
        const distance = weddingDate - now;

        // Elements
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        // Check if elements exist before updating
        if (!daysEl) return; 

        if (distance > 0) {
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            daysEl.textContent = String(days).padStart(2, '0');
            if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        } else {
            // If date passed
            daysEl.textContent = "00";
            if (hoursEl) hoursEl.textContent = "00";
            if (minutesEl) minutesEl.textContent = "00";
            if (secondsEl) secondsEl.textContent = "00";
        }
    }

    updateTimer(); // Run once immediately
    setInterval(updateTimer, 1000); // Loop
}

// ==================== 4. SCROLL ANIMATIONS ====================
function initScrollAnimations() {
    if (!('IntersectionObserver' in window)) return;

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

    const sections = document.querySelectorAll('.right-section');
    sections.forEach((section) => {
        section.classList.add('scroll-animate');
        observer.observe(section);
    });
}

// ==================== 5. GIFT MODAL ====================
function initGiftModal() {
    const giftBtn = document.querySelector('.btn-gift');
    
    if (!giftBtn) return;

    // Remove existing modal if any to prevent duplicates
    const existingModal = document.getElementById('giftModal');
    if (existingModal) existingModal.remove();

    // Create modal HTML
    const modalHTML = `
        <div class="gift-modal" id="giftModal">
            <div class="gift-modal-content">
                <button class="gift-modal-close" id="giftModalClose">×</button>
                <p class="gift-modal-title">Silakan transfer hadiah melalui nomor rekening berikut:</p>
                
                <div class="bank-account-card">
                    <div class="bank-account-content">
                        <div class="bank-name">BCA</div>
                        <div class="bank-account-wrapper">
                            <span class="bank-account-number">1234567890</span>
                            <button class="copy-btn" data-account="1234567890" title="Copy">📋</button>
                        </div>
                        <div class="bank-account-name">NAMA PENGANTIN</div>
                    </div>
                </div>

                <div class="bank-account-card">
                    <div class="bank-account-content">
                        <div class="bank-name">BRI</div>
                        <div class="bank-account-wrapper">
                            <span class="bank-account-number">0987654321</span>
                            <button class="copy-btn" data-account="0987654321" title="Copy">📋</button>
                        </div>
                        <div class="bank-account-name">NAMA PENGANTIN</div>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    const giftModal = document.getElementById('giftModal');
    const giftModalClose = document.getElementById('giftModalClose');
    const copyButtons = document.querySelectorAll('.copy-btn');

    giftBtn.addEventListener('click', function(e) {
        e.preventDefault();
        giftModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    function closeModal() {
        giftModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (giftModalClose) giftModalClose.addEventListener('click', closeModal);

    giftModal.addEventListener('click', function(e) {
        if (e.target === giftModal) closeModal();
    });

    copyButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const accountNumber = this.getAttribute('data-account');
            navigator.clipboard.writeText(accountNumber).then(() => {
                const originalText = btn.textContent;
                btn.textContent = '✓';
                setTimeout(() => {
                    btn.textContent = originalText;
                }, 2000);
            });
        });
    });
}

// ==================== 6. GALLERY LIGHTBOX ====================
function initGalleryLightbox() {
    const galleryImages = document.querySelectorAll('.gallery-img');
    const couplePhoto = document.querySelector('.couple-photo');
    
    // Collect all valid image sources
    const images = [];
    if (couplePhoto) images.push(couplePhoto.src);
    galleryImages.forEach(img => images.push(img.src));

    if (images.length === 0) return;

    // Check if lightbox already exists
    if (!document.getElementById('galleryLightbox')) {
        const lightboxHTML = `
            <div class="gallery-lightbox" id="galleryLightbox">
                <button class="lightbox-close" id="lightboxClose">×</button>
                <button class="lightbox-prev" id="lightboxPrev">❮</button>
                <button class="lightbox-next" id="lightboxNext">❯</button>
                <div class="lightbox-container">
                    <img class="lightbox-image" id="lightboxImage" src="" alt="Gallery">
                </div>
                <div class="lightbox-counter">
                    <span id="currentImage">1</span> / <span id="totalImages">1</span>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', lightboxHTML);
    }

    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const totalImagesSpan = document.getElementById('totalImages');
    const currentImageSpan = document.getElementById('currentImage');
    let currentIndex = 0;

    if (totalImagesSpan) totalImagesSpan.textContent = images.length;

    function openLightbox(index) {
        currentIndex = index;
        updateLightboxImage();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function updateLightboxImage() {
        if (currentIndex < 0) currentIndex = images.length - 1;
        if (currentIndex >= images.length) currentIndex = 0;
        
        lightboxImage.src = images[currentIndex];
        if (currentImageSpan) currentImageSpan.textContent = currentIndex + 1;
    }

    // Attach click events
    if (couplePhoto) {
        couplePhoto.style.cursor = 'pointer';
        couplePhoto.addEventListener('click', () => openLightbox(0));
    }

    galleryImages.forEach((img) => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', () => {
            const idx = images.indexOf(img.src);
            if (idx !== -1) openLightbox(idx);
        });
    });

    // Controls
    document.getElementById('lightboxClose')?.addEventListener('click', () => {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    });

    document.getElementById('lightboxPrev')?.addEventListener('click', () => {
        currentIndex--;
        updateLightboxImage();
    });

    document.getElementById('lightboxNext')?.addEventListener('click', () => {
        currentIndex++;
        updateLightboxImage();
    });

    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

// ==================== 7. COUPLE VIDEO ====================
function initCoupleVideoPlayback() {
    const coupleVideo = document.getElementById('coupleVideo');
    const bgVideo = document.getElementById('panelVideoBg');

    if (!coupleVideo) return;

    coupleVideo.style.cursor = 'pointer';

    // Helper to handle background audio
    function pauseBg() { if (bgVideo) bgVideo.pause(); }
    function playBg() { if (bgVideo) bgVideo.play().catch(() => {}); }

    coupleVideo.addEventListener('play', pauseBg);
    coupleVideo.addEventListener('pause', () => setTimeout(playBg, 100));
    coupleVideo.addEventListener('ended', () => setTimeout(playBg, 100));

    // Fullscreen handling
    coupleVideo.addEventListener('click', function() {
        if (coupleVideo.requestFullscreen) {
            coupleVideo.requestFullscreen();
        } else if (coupleVideo.webkitRequestFullscreen) {
            coupleVideo.webkitRequestFullscreen(); // Safari
        }
        coupleVideo.play();
    });
}

// ==================== 8. WISHES (UCAPAN) ====================
function initWishesSection() {
    const form = document.querySelector('.wishes-form'); // Assumed wrapper or adjust selector
    const sendBtn = document.querySelector('.btn-send');
    const wishesInput = document.querySelector('.wishes-input');
    const wishesTextarea = document.querySelector('.wishes-textarea');
    const wishesList = document.querySelector('.wishes-list');

    // Only proceed if elements exist
    if (!sendBtn || !wishesInput || !wishesTextarea) return;

    // Load initial wishes
    loadWishes();

    sendBtn.addEventListener('click', submitWish);

    async function submitWish() {
        const name = wishesInput.value.trim();
        const text = wishesTextarea.value.trim();

        if (!name || !text) {
            alert('Mohon isi nama dan ucapan/doa Anda');
            return;
        }

        const originalText = sendBtn.textContent;
        sendBtn.textContent = 'Mengirim...';
        sendBtn.disabled = true;

        try {
            // NOTE: Sesuaikan URL API Anda di sini
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
                wishesInput.value = '';
                wishesTextarea.value = '';
                if (data.wish) addWishToList(data.wish);
                alert('Terima kasih atas ucapan Anda!');
            } else {
                alert('Gagal mengirim: ' + (data.message || 'Error'));
            }
        } catch (error) {
            console.error('Submission error:', error);
            // Fallback for demo if no backend:
            // addWishToList({ name, text });
        } finally {
            sendBtn.textContent = originalText;
            sendBtn.disabled = false;
        }
    }

    async function loadWishes() {
        try {
            const response = await fetch('/api/wishes');
            if (response.ok) {
                const data = await response.json();
                if (data.wishes && wishesList) {
                    wishesList.innerHTML = ''; // Clear default
                    data.wishes.forEach(wish => addWishToList(wish));
                }
            }
        } catch (e) {
            console.log('Backend not connected yet for wishes');
        }
    }

    function addWishToList(wish) {
        if (!wishesList) return;
        const div = document.createElement('div');
        div.className = 'wish-item';
        div.innerHTML = `
            <p class="wish-author"><strong>${esc(wish.name)}</strong></p>
            <p class="wish-text">${esc(wish.text)}</p>
        `;
        wishesList.prepend(div);
    }

    function esc(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }
}

// ==================== 9. LOCATION BUTTON ====================
function initLocationButton() {
    const locationButtons = document.querySelectorAll('.btn-location');
    locationButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            // Ganti link di bawah sesuai link Google Maps venue Anda
            window.open('https://maps.app.goo.gl/PV3DLW1Ngjeua5Eu6', '_blank');
        });
    });
}

// ==================== MASTER INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Ready - Initializing Modules...');
    
    initInvitationController();
    initAudioToggle();
    initCountdown();
    initScrollAnimations();
    initGiftModal();
    initGalleryLightbox();
    initCoupleVideoPlayback();
    initWishesSection();
    initLocationButton();
});
