    </main>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Desa Bragang</h3>
                    <p class="footer-desc"><?= e($settings['tagline'] ?? 'Melayani dengan Sepenuh Hati') ?></p>
                    <p class="footer-address"><?= e($settings['alamat'] ?? '') ?></p>
                </div>
                <div class="footer-col">
                    <h3>Navigasi</h3>
                    <ul class="footer-links">
                        <li><a href="<?= baseUrl('/') ?>">Beranda</a></li>
                        <li><a href="<?= baseUrl('/sejarah.php') ?>">Sejarah Desa</a></li>
                        <li><a href="<?= baseUrl('/wilayah.php') ?>">Wilayah Desa</a></li>
                        <li><a href="<?= baseUrl('/struktur.php') ?>">Struktur Organisasi</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Informasi</h3>
                    <ul class="footer-links">
                        <li><a href="<?= baseUrl('/pendidikan.php') ?>">Pendidikan</a></li>
                        <li><a href="<?= baseUrl('/masjid.php') ?>">Masjid</a></li>
                        <li><a href="<?= baseUrl('/statistik.php') ?>">Statistik</a></li>
                        <li><a href="<?= baseUrl('/jam-kerja.php') ?>">Jam Kerja</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Kontak</h3>
                    <p><a href="https://wa.me/62<?= e($settings['telepon'] ?? '') ?>"><?= e($settings['telepon'] ?? '') ?></a></p>
                    <p><?= e($settings['email'] ?? '') ?></p>
                    <a href="<?= baseUrl('/lokasi.php') ?>" class="footer-map-link">Lihat Peta →</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= e($siteName) ?>. Kecamatan <?= e($settings['kecamatan'] ?? '') ?>, Kabupaten <?= e($settings['kabupaten'] ?? '') ?>. &bull; <a href="<?= baseUrl('/admin/login.php') ?>" style="color: inherit; opacity: 0.7; text-decoration: underline;">Portal Admin</a></p>
            </div>
        </div>
    </footer>
    <script src="<?= baseUrl('/assets/js/main.js') ?>"></script>
</body>
</html>
