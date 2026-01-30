<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Salma & Fadli - Wedding Invitation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Sacramento&family=Agbalumo&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v=12">
    <script src="{{ asset('js/custom.js') }}?v=12" defer></script>
</head>

<body>
    <div class="page-wrapper">
        <!-- Landing Container -->
        <div class="landing-container" id="landingContainer" style="background-image: url('{{ asset('img/background.jpg') }}');">
            <div class="landing-content">
                <h1 class="wedding-title">The Wedding Of</h1>
                <h2 class="couple-names">Salma & Fadli</h2>
                <p class="guest-info">Dear</p>
                <p class="guest-name">{{ $guestName ?? 'Guest' }}</p>
                <button class="open-invitation-btn" id="openInvitationBtn">Buka Undangan</button>
            </div>
        </div>

        <!-- Invitation Panel -->
        <div class="invitation-panel" id="invitationPanel">

            <!-- Left Side (Static) -->
            <!--<div class="panel-left">-->
            <!--    <button class="panel-audio-toggle" id="panelAudioToggle" title="Toggle Audio">-->
            <!--        <span class="audio-icon">🔊</span>-->
            <!--    </button>-->
            <!--    <button class="close-btn" id="closeBtn">&times;</button>-->
            <!--    <div class="panel-left-content">-->
            <!--        <div class="left-title">The Wedding Of</div>-->
            <!--        <div class="left-subtitle">Salma & Fadli</div>-->
            <!--        <div class="left-text">-->
            <!--            <p style="margin-top: 20px; font-size: 16px;">Sabtu, 7 Februari 2026<br>Garut</p>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <!-- Right Side (Scrollable) -->
            <div class="panel-right">
                <button class="panel-audio-toggle" id="panelAudioToggle" title="Toggle Audio">
                    <span class="audio-icon">🔊</span>
                </button>
                <button class="close-btn" id="closeBtn">&times;</button>

                <video autoplay muted loop playsinline id="panelVideoBg" class="panel-video-bg">
                    <source src="{{ asset('img/intro.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <div class="panel-scroll-container">

                    <div class="right-section couple-photos-section">
                        <div class="couple-photo-wrapper">
                            <video controls preload="metadata" class="couple-photo" id="coupleVideo" allowfullscreen>
                                <source src="{{ asset('img/intro2.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>

                    <div class="right-section save-date-section">
                        <h3 class="save-date-title">Save The Date</h3>
                        <p class="save-date-subtitle">FOR THE WEDDING OF</p>
                        <h2 class="save-date-names">Salma & Fadli</h2>
                        <p class="save-date-date">Sabtu, 7 Februari 2026</p>

                        <div class="countdown-grid">
                            <div class="countdown-item">
                                <div class="countdown-number" id="days">0</div>
                                <div class="countdown-label">Hari</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-number" id="hours">0</div>
                                <div class="countdown-label">Jam</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-number" id="minutes">0</div>
                                <div class="countdown-label">Menit</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-number" id="seconds">0</div>
                                <div class="countdown-label">Detik</div>
                            </div>
                        </div>
                    </div>

                    <div class="right-section gift-section">
                        <p class="section-title">"وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً ۚ إِنَّ فِي ذَٰلِكَ لَآيَاتٍ لِّقَوْمٍ يَتَفَكَّرُونَ"</p>
                        <p class="gift-subtitle">"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum yang berpikir."</p>
                        <h3 class="section-title">QS. Ar-Rum 21</h3>
                    </div>

                    <div class="right-section event-section">
                        <h3 class="section-title">LUTFISALMA SULAFA</h3>
                        <p class="event-location-text-nama">Putri pertama dari</p>
                        <p class="event-location-text-keluarga">Alm. Bapak Hendar Suhendar & Ibu Wita Puspitasari</p>

                        <h3 class="section-title">&</h3>

                        <h3 class="section-title">FADLI FATHURAHMAN</h3>
                        <p class="event-location-text-nama">Putra ketiga dari</p>
                        <p class="event-location-text-keluarga">Bapak Sumarna Mantaero & Ibu Ina Aryani</p>
                    </div>

                    <div class="right-section event-section">
                        <h3 class="section-title">Akad Nikah</h3>
                        <p class="event-date">Sabtu 7 Februari 2026</p>
                        <p class="event-time-text">08:00 - Selesai</p>

                        <h3 class="section-title">Resepsi</h3>
                        <p class="event-date">Sabtu 7 Februari 2026</p>
                        <p class="event-time-text">11:00 - 14:00 WIB</p>
                        <p class="event-location-text">Graha Intan Balarea Jl. Patriot No.12-14, Sukagalih, Kec. Tarogong Kidul, Kabupaten Garut</p>

                        <div class="maps-preview-container">
                            <iframe class="maps-embed" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.36072087591!2d107.883874374545!3d-7.199620770673457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68b0f3059e7c57%3A0xf23fcebaef634b68!2sGraha%20Intan%20Balarea!5e0!3m2!1sid!2sid!4v1769708082167!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <button class="btn-location">Lihat Lokasi</button>
                    </div>

                    <!-- <div class="right-section event-section">
                        <h3 class="section-title">Resepsi</h3>
                        <p class="event-date">Sabtu 15 Juni 2024</p>
                        <p class="event-time-text">05:00 - 08:00 WIB</p>
                        <p class="event-location-text">Grand Ballroom Convention Center<br>Jln. Gatot Subroto No. 45, Jakarta Pusat</p>
                        <button class="btn-location">LIHAT LOKASI</button>
                    </div> -->

                    <div class="right-section gallery-section">
                        <h3 class="section-title">Gallery</h3>
                        <div class="gallery-grid">
                            <img src="{{ asset('img/galeri/DSC_7605.jpg') }}" alt="Gallery" class="gallery-img gallery-img1">
                            <img src="{{ asset('img/galeri/DSC_7883.jpg') }}" alt="Gallery" class="gallery-img gallery-img2">
                            <img src="{{ asset('img/galeri/IMG_4644.jpg') }}" alt="Gallery" class="gallery-img gallery-img3">
                            <img src="{{ asset('img/galeri/IMG_4645.jpg') }}" alt="Gallery" class="gallery-img gallery-img4">
                            <img src="{{ asset('img/galeri/IMG_4646.jpg') }}" alt="Gallery" class="gallery-img gallery-img5">
                            <img src="{{ asset('img/galeri/IMG_4643.jpg') }}" alt="Gallery" class="gallery-img gallery-img6">
                            <img src="{{ asset('img/galeri/DSC_8042.jpg') }}" alt="Gallery" class="gallery-img gallery-img7">
                            <img src="{{ asset('img/galeri/DSC_8368.jpg') }}" alt="Gallery" class="gallery-img gallery-img8">
                            <img src="{{ asset('img/galeri/DSC_7589.jpg') }}" alt="Gallery" class="gallery-img gallery-img9">
                            <img src="{{ asset('img/galeri/DSC_8552.jpg') }}" alt="Gallery" class="gallery-img gallery-img10">
                            <img src="{{ asset('img/galeri/DSC_8521.jpg') }}" alt="Gallery" class="gallery-img gallery-img11">
                            <img src="{{ asset('img/galeri/DSC_8076.jpg') }}" alt="Gallery" class="gallery-img gallery-img12">
                        </div>
                    </div>

                    <!--<div class="right-section story-section">-->
                    <!--    <h3 class="section-title">Kisah Cinta</h3>-->
                    <!--    <p class="story-text">-->
                    <!--        Kisah panjang penuh arti ini dimulai dari tahun 2017, kami dipertemukan di bangku SMA, sebagai kakak kelas dan adik kelas. Berlanjut dari kami yang hanya sering berpapasan di kantin sekolah, sampai seiring berjalannya waktu kami berkenalan dan komunikasi secara intens.-->
                    <!--        <br><br>-->
                    <!--        Meski terpisah oleh jarak dan waktu untuk menempuh jenjang perkuliahan, sampai pada akhirnya sempat tidak berkomunikasi. Pada akhirnya setelah 8 tahun bersama melewati pasang surut nya, Allah mempertemukan kembali dengan skenario Nya yang begitu indah.-->
                    <!--        <br><br>-->
                    <!--        November 2025 kami memutuskan untuk melangkah ke tahap berikutnya & menjalani hubungan yang lebih serius membangun masa depan bersama menjadikan perjalanan ini rumah, dan cinta selamanya tanpa pernah tahu bahwa perjalanan ini akan begitu panjang dan penuh cerita.-->
                    <!--    </p>-->
                    <!--</div>-->

                    <div class="right-section gift-section">
                        <h3 class="section-title">Wedding Gift</h3>
                        <p class="gift-subtitle">Bagi yang ingin memberikan tanda kasih, dapat mengirimkan melalui fitur di bawah ini:</p>
                        <button class="btn-gift">Kirim Hadiah</button>
                    </div>

                    <div class="right-section wishes-section">
                        <h3 class="section-title">Ucapan & Doa</h3>
                        <p class="wishes-subtitle">Tuliskan nama dan ucapan/doa Anda:</p>
                        <input type="text" class="wishes-input" placeholder="Nama Anda">
                        <textarea class="wishes-textarea" placeholder="Ucapan & doa Anda"></textarea>
                        <button class="btn-send">Kirim Ucapan</button>
                        <div class="wishes-list"></div>
                    </div>

                    <div class="right-section closing-section">
                       <p class="closing-text">
                            Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i dapat hadir untuk memberikan doa restu kepada putra putri kami.<br>
                            Atas kehadiran serta doa restunya kami ucapkan terima kasih.<br>
                            Wassalamu'alaikum Warahmatullahi Wabarakatuh
                        </p>
                        <p class="closing-names">Salma & Fadli</p>
                        <p class="closing-footer">Powered By <a href="https://www.malahphotobooth.com" target="_blank" rel="noopener noreferrer">malahphotobooth.com</a></p>
                    </div>

                    <div style="height: 40px;"></div>
                </div>
            </div>
</body>

</html>
