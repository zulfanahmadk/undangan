<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fitri & Syifa - Wedding Invitation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Sacramento&family=Agbalumo&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/custom.js') }}" defer></script>
</head>

<body>
    <div class="page-wrapper">
        <!-- Landing Container -->
        <div class="landing-container" id="landingContainer" style="background-image: url('{{ asset('img/background.jpg') }}');">
            <div class="landing-content">
                <h1 class="wedding-title">The Wedding Of</h1>
                <h2 class="couple-names">Pipit & Pael</h2>
                <p class="guest-info">Dear</p>
                <p class="guest-name">{{ $guestName ?? 'Guest' }}</p>
                <button class="open-invitation-btn" id="openInvitationBtn">Buka Undangan</button>
            </div>
        </div>

        <!-- Invitation Panel -->
        <div class="invitation-panel" id="invitationPanel">
            <button class="close-btn" id="closeBtn">&times;</button>

            <!-- Left Side (Static) -->
            <div class="panel-left">
                <button class="panel-audio-toggle" id="panelAudioToggle" title="Toggle Audio">
                    <span class="audio-icon">🔊</span>
                </button>
                <div class="panel-left-content">
                    <div class="left-title">The Wedding Of</div>
                    <div class="left-subtitle">Pipit & Pael</div>
                    <div class="left-text">
                        <p style="margin-top: 20px; font-size: 12px;">Sabtu, 17 Januari 2026<br>Garut, Indonesia</p>
                    </div>
                </div>
            </div>

            <!-- Right Side (Scrollable) -->
            <div class="panel-right">
                <video autoplay muted loop id="panelVideoBg" class="panel-video-bg">
                    <source src="{{ asset('img/intro.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <div class="panel-scroll-container">

                    <div class="right-section couple-photos-section">
                        <div class="couple-photo-wrapper">
                            <video controls preload="metadata" class="couple-photo" id="coupleVideo">
                                <source src="{{ asset('img/intro2.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>

                    <div class="right-section save-date-section">
                        <h3 class="save-date-title">Save The Date</h3>
                        <p class="save-date-subtitle">FOR THE WEDDING OF</p>
                        <h2 class="save-date-names">PIPIT & PAEL</h2>
                        <p class="save-date-date">Sabtu, 17 Januari 2026</p>

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
                        <p class="gift-subtitle">"وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً ۚ إِنَّ فِي ذَٰلِكَ لَآيَاتٍ لِّقَوْمٍ يَتَفَكَّرُونَ"</p>
                        <p class="gift-subtitle">"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum yang berpikir."</p>
                        <h3 class="section-title">QS. Ar-Rum 21</h3>
                    </div>

                    <div class="right-section event-section">
                        <h3 class="section-title">FITRI UTAMI, S.M</h3>
                        <p class="event-location-text-nama">Putri dari</p>
                        <p class="event-location-text-keluarga">Bapak Maman Firmasyah & Ibu Nurjanah (Ibu Ade)</p>

                        <h3 class="section-title">&</h3>

                        <h3 class="section-title">SYIFA EL YANUAR, S.P</h3>
                        <p class="event-location-text-nama">Putra dari</p>
                        <p class="event-location-text-keluarga">Bapak Alm. H. Yanto & Ibu Alm. Hj. Nia Kurniati, S.E</p>
                    </div>

                    <div class="right-section event-section">
                        <h3 class="section-title">Akad Nikah</h3>
                        <p class="event-date">Sabtu 17 Januari 2026</p>
                        <p class="event-time-text">10:00 - 10:00 WIB</p>

                        <h3 class="section-title">Resepsi</h3>
                        <p class="event-date">Sabtu 17 Januari 2026</p>
                        <p class="event-time-text">11:00 - 14:00 WIB</p>
                        <p class="event-location-text">BALLROOM AL-MUSSADADIYAH<br>Jl. Mayor Syamsu No.2, Jayaraga, Kec. Tarogong Kidul, Kab. Garut, 44151</p>
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
                            <img src="{{ asset('img/galeri/DSC_1154.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1195.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1320.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1354.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1427.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1493.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1557.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1614.jpg') }}" alt="Gallery" class="gallery-img">
                            <img src="{{ asset('img/galeri/DSC_1689.jpg') }}" alt="Gallery" class="gallery-img">
                        </div>
                    </div>

                    <div class="right-section story-section">
                        <h3 class="section-title">Kisah Cinta</h3>
                        <p class="story-text">
                            Tidak ada yang kebetulan di dunia ini, kami bertemu pada tahun 2016 sebagai teman satu kelas di SMA.
                            Awalnya kami hanyalah dua orang yang sekedar saling mengenal dan hanya sebatas teman yang tidak banyak percakapan maupun cerita panjang.
                            <br><br>
                            Waktu perlahan mempertemukan kami pada momen-momen istimewa. Kehendak Allah menuntun kami pada sebuah pertemuan yang tak pernah di sangka hingga akhirnya membawa kami pada sebuah jawaban dengan komitmen yang mengantarkan kami untuk melangsungkan lamaran pada bulan juli 2024.
                        </p>
                    </div>

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

                        <div class="wishes-list">
                            <div class="wish-item">
                                <p class="wish-author">Keluarga Besar</p>
                                <p class="wish-text">Selamat menjalani bahtera rumah tangga, semoga lancar selalu dan penuh berkah 🎉</p>
                            </div>
                            <div class="wish-item">
                                <p class="wish-author">Sahabat-Sahabat</p>
                                <p class="wish-text">Barakallah untuk kalian berdua, semoga menjadi keluarga yang bahagia dan harmonis</p>
                            </div>
                        </div>
                    </div>

                    <div class="right-section closing-section">
                        <p class="closing-text">
                            Menjadi sebuah kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dalam hari bahagia ini.
                            Terima kasih atas segala ucapan, doa, dan perhatian yang diberikan.
                        </p>
                        <p class="closing-names">Pipit & Pael</p>
                        <p class="closing-footer">Powered by Zulfan Ganteng</p>
                    </div>

                    <div style="height: 40px;"></div>
                </div>
            </div>

            <script>
                console.log('Page loaded - checking for custom.js');
            </script>
</body>

</html>
