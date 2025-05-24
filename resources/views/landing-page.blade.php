<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiTani - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@700&family=Poppins:wght@400&display=swap" rel="stylesheet">


    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .hero {
        min-height: 100vh;
        color: white;
        padding: 300px 30px;
        text-align: left;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: background-image 1s ease-in-out;
        }
        @media (max-width: 768px) {
    .hero {
        min-height: auto;
        padding: 100px 20px;
    }
        }

        .hero h1 {
        font-family: 'Lora', serif;
        font-weight: 700;
        font-size: 48px;
        margin-bottom: 10px;
        }

        .hero p {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        font-size: 18px;
        }



        .rounded-circle {
            object-fit: cover;
            border-radius: 50%;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        footer {
            background: #00886a;
            color: #fff;
            padding: 40px 20px;
            text-align: center;
        }

        /* FAQ Styles */
        .faq-section {
            background-color: #3BA54A;
            padding: 40px 20px;
            color: white;
        }

        .faq-item {
            background-color: white;
            color: black;
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 15px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
        }

        .faq-item.active {
            background-color: #d9f2dd;
        }

        .faq-item .faq-question {
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-item .faq-answer {
            margin-top: 10px;
            display: none;
            font-size: 14px;
            color: #555;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-toggle-icon {
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-toggle-icon {
            transform: rotate(180deg);
        }

        /* Navbar Style */
        .navbar {
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
        }

        .navbar-brand img {
            width: 60px;
            height: 60px;
        }

        .nav-link {
            padding-top: 0;
            padding-bottom: 0;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 16px;
            transition: color 0.3s ease, border-bottom 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #3BA54A;
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: #3BA54A;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* ====== Gambar Tentang ====== */
        .image-wrapper {
            position: relative;
            width: 250px;
            height: 250px;
            margin: 0 auto;
        }

        .image-wrapper img.main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .image-wrapper img.small-image {
            position: absolute;
            bottom: -10px;
            right: -10px;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Berlaku untuk semua layar (termasuk desktop) */
        .logo-img {
            width: 120px;
            height: 120px;
            position: absolute;
            top: 10px;
            left: 0;
            z-index: 10;
        }

        .navbar-brand {
            padding-left: 600px;
            height: 60px;
            overflow: visible;
        }

        /* Responsive: HP ukuran kecil */
        @media (max-width: 768px) {
            .logo-img {
                width: 80px;
                height: 80px;
                top: 5px;
            }

            .navbar-brand {
                padding-left: 100px;
            }

            .hero {
                padding: 100px 20px;
            }
        }



            .faq-item .faq-question {
                font-size: 16px;
            }

            .faq-answer {
                font-size: 14px;
            }

            /* Responsive untuk gambar tentang */
            .image-wrapper {
                width: 200px;
                height: 200px;
            }

            .image-wrapper img.small-image {
                width: 100px;
                height: 100px;
                bottom: -5px;
                right: -5px;
            }

    </style>
</head>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 sticky-top">
    <a class="navbar-brand position-relative" href="#">
      <img src="{{ asset('storage/images/image4.png') }}" alt="Logo SiTani" class="logo-img rounded-circle">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="#hero">Utama</a></li>
        <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="#data">Data</a></li>
        <li class="nav-item"><a class="nav-link" href="#melayani">Melayani</a></li>
        <li class="nav-item"><a class="nav-link" href="#hubungi">Hubungi</a></li>
      </ul>
    </div>
  </nav>


<!-- HERO -->
<section id="hero" class="hero">
    <div class="container text-left">
        <h1 data-aos="fade-down"
            data-aos-duration="1500"
            data-aos-easing="ease-in-out-cubic">
            Agriculture & Eco Farming
        </h1>
        <p data-aos="fade-up"
           data-aos-delay="300"
           data-aos-duration="1500"
           data-aos-easing="ease-in-out-cubic">
            Selamat datang di pertanian berkelanjutan
        </p>
    </div>
</section>
<script>
    const heroSection = document.querySelector('.hero');
    const images = [
        "{{ asset('storage/images/image3.png') }}",
        "{{ asset('storage/images/image10.webp') }}",
        "{{ asset('storage/images/image11.png') }}",
        "{{ asset('storage/images/image12.jpeg') }}"
    ];

    let current = 0;

    function changeBackground() {
      heroSection.style.backgroundImage = `url('${images[current]}')`;
      current = (current + 1) % images.length;
    }

    // Ganti gambar setiap 5 detik
    setInterval(changeBackground, 5000);

    // Set gambar awal
    changeBackground();
  </script>

<!-- Tentang-->
<section id="tentang" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">

            <!-- Bagian Gambar -->
            <div class="col-md-5 text-center mb-4 mb-md-0"
                 data-aos="fade-right"
                 data-aos-duration="1200"
                 data-aos-easing="ease-in-out-cubic">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/images/image1.png') }}" alt="Ilustrasi Pertanian" class="main-image mb-3">
                    <img src="{{ asset('storage/images/image2.png') }}" alt="Ilustrasi Pertanian" class="small-image">
                </div>
            </div>

            <!-- Bagian Teks -->
            <div class="col-md-7 text-center text-md-start"
                 data-aos="fade-left"
                 data-aos-duration="1200"
                 data-aos-delay="200"
                 data-aos-easing="ease-in-out-cubic">
                <h2 class="text-success">Tentang SiTani</h2>
                <p>
                    Pertanian atau agrikultur adalah kegiatan pemanfaatan sumber daya hayati yang dilakukan manusia
                    untuk menghasilkan bahan pangan, bahan baku industri, atau sumber energi, serta untuk mengelola
                    lingkungan hidupnya.
                    Kegiatan ini mencakup budidaya tanaman, peternakan, serta pengolahan mikroorganisme untuk produk
                    lanjutan. SiTani hadir sebagai solusi digital yang mempermudah pengelolaan proses tersebut
                    secara terintegrasi dan efisien.
                </p>
            </div>

        </div>
    </div>
</section>

<!--Tambahan Gambar-->
<div class="container my-5">
    <div class="row justify-content-center text-center">
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up">
            <img src="{{ asset('storage/images/image14.png') }}" alt="Fitur Tambahan 1" class="img-fluid rounded shadow w-75">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
            <img src="{{ asset('storage/images/image8.png') }}" alt="Fitur Tambahan 2" class="img-fluid rounded shadow w-75">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <img src="{{ asset('storage/images/image9.png') }}" alt="Fitur Tambahan 3" class="img-fluid rounded shadow w-75">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="300">
            <img src="{{ asset('storage/images/image7.png') }}" alt="Fitur Tambahan 4" class="img-fluid rounded shadow w-75">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="300">
            <img src="{{ asset('storage/images/image13.png') }}" alt="Fitur Tambahan 5" class="img-fluid rounded shadow w-75">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="600">
            <img src="{{ asset('storage/images/image15.png') }}" alt="Fitur Tambahan 6" class="img-fluid rounded shadow w-75">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="700">
            <img src="{{ asset('storage/images/image16.png') }}" alt="Fitur Tambahan 6" class="img-fluid rounded shadow w-75">
        </div>
    </div>
</div>



<!-- Bagian Data Komoditas Pertanian -->
<section id="data" style="padding: 60px 0; background-color: #ffffff;">
  <div style="max-width: 1000px; margin: auto; text-align: center;">
    <h2 style="color: #1d7b4f; font-size: 28px; margin-bottom: 16px;">Data Komoditas Pertanian</h2>
    <p style="font-size: 16px; color: #333;">
      Grafik ini menampilkan jumlah musim tanam setiap komoditas pertanian yang dibudidayakan oleh petani.
      Informasi ini penting dalam perencanaan panen, pengiriman logistik, dan pengawasan produksi.
    </p>

    <!-- Canvas untuk grafik komoditas -->
    <canvas id="grafikKomoditas" width="800" height="400" style="margin-top: 40px;"></canvas>
    <div id="errorKomoditasMsg" style="color: red; margin-top: 20px;"></div>
  </div>
</section>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  async function loadGrafikKomoditas() {
    try {
      const response = await fetch('https://websitaniproject-production-ab46.up.railway.app/api/komoditas/musim');
      const result = await response.json();

      console.log("Respon API:", result); // Debug

      if (!result.data || !Array.isArray(result.data) || result.data.length === 0) {
        throw new Error('Data tidak ditemukan atau kosong.');
      }

      const labels = result.data.map(item => item.nama);
      const dataMusim = result.data.map(item => parseInt(item.musim || 0));

      // Fungsi untuk generate warna unik dari nama komoditas
      function hashStringToNumber(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
          hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        return hash;
      }

      function stringToHslColor(str, saturation = 70, lightness = 60) {
        const hash = hashStringToNumber(str);
        const hue = Math.abs(hash) % 360;
        return `hsl(${hue}, ${saturation}%, ${lightness}%)`;
      }

      // Jika ingin warna spesifik untuk komoditas tertentu, bisa diset manual di sini:
      const warnaKomoditasManual = {
  'Padi': 'rgba(34, 139, 34, 0.7)',      // hijau
  'Jagung': 'rgba(255, 206, 86, 0.7)',   // kuning
  'bawang': 'rgba(255, 159, 64, 0.7)',   // oranye
  'brambang': 'rgba(153, 102, 255, 0.7)', // ungu
};

const warnaBorderKomoditasManual = {
  'Padi': 'rgba(34, 139, 34, 1)',
  'Jagung': 'rgba(255, 206, 86, 1)',
  'bawang': 'rgba(255, 159, 64, 1)',
  'brambang': 'rgba(153, 102, 255, 1)',
};


      // Buat warna background, pakai manual dulu kalau ada, kalau tidak pakai generate otomatis
      const backgroundColors = labels.map(label =>
        warnaKomoditasManual[label] || stringToHslColor(label, 70, 60)
      );
      const borderColors = labels.map(label =>
        warnaBorderKomoditasManual[label] || stringToHslColor(label, 70, 40)
      );

      const ctx = document.getElementById('grafikKomoditas').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Jumlah Musim Tanam',
            data: dataMusim,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Jumlah Musim'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Komoditas'
              }
            }
          }
        }
      });

    } catch (error) {
      console.error('Gagal memuat data:', error.message);
      document.getElementById('errorKomoditasMsg').textContent = 'Gagal memuat grafik: ' + error.message;
    }
  }

  document.addEventListener('DOMContentLoaded', loadGrafikKomoditas);
</script>








<!-- Bagian Data Lahan Pertanian -->
<section style="padding: 60px 0; background-color: #f9f9f9;">
  <div style="max-width: 1000px; margin: auto; text-align: center;">
    <h2 style="color: #1d7b4f; font-size: 28px; margin-bottom: 16px;">Data Lahan Pertanian</h2>
    <p style="font-size: 16px; color: #333;">
      Sitani menyediakan data lahan pertanian yang mencakup luas lahan, jenis tanaman yang dibudidayakan, serta
      persebarannya. Data ini membantu pemerintah dan petani dalam melakukan analisis potensi, distribusi bantuan,
      dan perencanaan program pertanian yang lebih tepat sasaran.
    </p>

    <!-- Canvas untuk grafik -->
    <canvas id="grafikLahan" width="800" height="400" style="margin-top: 40px;"></canvas>
    <div id="errorMsg" style="color: red; margin-top: 20px;"></div>
  </div>
</section>

<!-- Tambahkan Chart.js jika belum -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  async function loadGrafikLuasLahan() {
    try {
      const response = await fetch('https://websitaniproject-production-ab46.up.railway.app/api/laporan-kondisi/total-luas-lahan');
      const result = await response.json();

      if (!Array.isArray(result.data) || result.data.length === 0) {
        throw new Error('Format data dari API tidak sesuai (harus array dengan data).');
      }

      const labels = result.data.map(item => item.tahun);
      const dataLuas = result.data.map(item => item.total_luas_lahan);

      const ctx = document.getElementById('grafikLahan').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Luas Lahan Pertanian (ha)',
            data: dataLuas,
            backgroundColor: 'rgba(25, 135, 84, 0.7)',
            borderColor: 'rgba(25, 135, 84, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top'
            },
            title: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                precision: 0
              },
              title: {
                display: true,
                text: 'Luas (ha)'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Tahun'
              }
            }
          }
        }
      });

    } catch (error) {
      console.error('Gagal memuat data dari API:', error.message);
      document.getElementById('errorMsg').textContent = 'Gagal memuat data grafik: ' + error.message;
    }
  }

  document.addEventListener('DOMContentLoaded', loadGrafikLuasLahan);
</script>




<!-- Melayani-->
<section id="melayani" class="py-5 bg-white mt-5">
  <div class="container">
    <h2 class="text-center mb-4 text-success" data-aos="fade-up">Melayani</h2>
    <div class="row">
      <div class="col-12 col-md-6 mb-4" data-aos="fade-right">
        <h4 class="text-success">Pengajuan Hibah Alat</h4>
        <p>
          Sitani menyediakan fitur pengajuan hibah alat pertanian secara digital untuk memudahkan petani,
          kelompok tani, atau pihak terkait dalam mengakses bantuan dari Dinas Pertanian. Layanan ini
          dirancang agar proses pengajuan menjadi lebih cepat, transparan, dan terdokumentasi dengan baik.
        </p>
      </div>
      <div class="col-12 col-md-6 mb-4" data-aos="fade-left">
        <h4 class="text-success">Pelaporan Benih Berkualitas</h4>
        <p>
          Selain pengajuan bantuan, Sitani juga menyediakan fitur pelaporan bibit untuk memantau kualitas
          dan distribusi bibit yang telah diberikan kepada petani. Pelaporan ini sangat membantu Dinas
          Pertanian dalam mengevaluasi efektivitas program bantuan bibit dan membuat kebijakan yang
          berbasis data.
        </p>
      </div>
    </div>
  </div>
</section>



<!-- FAQ Baru -->
<section class="faq-section">
    <div class="container">
        <h2 class="text-center mb-4 fw-bold">Frequently Asked Questions</h2>

        <div class="faq-item" onclick="toggleFaq(this)">
            <div class="faq-question">
                Siapa saja yang dapat menggunakan sistem Sitani?
                <span class="faq-toggle-icon">❯</span>
            </div>
            <div class="faq-answer">
                Semua petani, kelompok tani, dan pihak terkait lainnya.
            </div>
        </div>

        <div class="faq-item" onclick="toggleFaq(this)">
            <div class="faq-question">
                Bagaimana jika saya mengalami kendala teknis saat menggunakan Sitani?
                <span class="faq-toggle-icon">❯</span>
            </div>
            <div class="faq-answer">
                Silakan hubungi admin melalui kontak yang tersedia di bawah.
            </div>
        </div>

        <div class="faq-item" onclick="toggleFaq(this)">
            <div class="faq-question">
                Apa saja dokumen yang dibutuhkan untuk pengajuan hibah?
                <span class="faq-toggle-icon">❯</span>
            </div>
            <div class="faq-answer">
                Proposal, surat permohonan, dan data pendukung.
            </div>
        </div>

        <div class="faq-item active" onclick="toggleFaq(this)">
            <div class="faq-question">
                Bagaimana saya tahu status pengajuan saya?
                <span class="faq-toggle-icon">⌃</span>
            </div>
            <div class="faq-answer">
                Setelah mengajukan hibah, Anda dapat memantau status pengajuan melalui dashboard Sitani. Setiap
                tahapan (verifikasi, disetujui, atau ditolak) akan ditampilkan secara real-time.
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer id="hubungi">
    <div class="text-center mb-4">
        <img src="{{ asset('storage/images/Group 6.png') }}" alt="Logo SiTani & Kabupaten Nganjuk" class="img-fluid"
            style="max-width: 400px;">
    </div>

    <div class="container d-flex flex-column flex-md-row justify-content-between text-start flex-wrap">
        <div class="mb-3 me-md-4">
            <h5>Dinas Pertanian Kabupaten Nganjuk</h5>
            <p>
                <a href="https://www.google.com/maps/dir//Jl.+Anjuk+Ladang+No.37,+Bedingin,+Sukorejo,+Kec.+Loceret,+Kabupaten+Nganjuk,+Jawa+Timur+64471/@-7.6252226,111.8149094,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x2e784b70a0612cd9:0x8f4e5ce1af3dcd6a!2m2!1d111.8973113!2d-7.6252304?entry=ttu&g_ep=EgoyMDI1MDQxNi4xIKXMDSoJLDEwMjExNDUzSAFQAw%3D%3D"
                    target="_blank" style="text-decoration: none; color: inherit;">
                    Jl. Anjuk Ladang No.37, Bedingin, Sukorejo,<br>
                    Kec. Loceret, Kabupaten Nganjuk, Jawa Timur 64471
                </a>
            </p>
        </div>

        <div class="mb-3 me-md-4">
            <h5>Layanan</h5>
            <ul class="list-unstyled">
                <li>Pengajuan Alat</li>
                <li>Pelaporan</li>
            </ul>
        </div>

        <div class="mb-3 me-md-4">
            <h5>Beri Bantuan</h5>
            <ul class="list-unstyled">
                <li>Memudahkan untuk pengajuan alat</li>
                <li>Pelaporan yang cepat</li>
            </ul>
        </div>

        <div class="mb-3">
            <h5>Kontak</h5>
            <p><i class="bi bi-whatsapp"></i> (0358) 321728</p>
            <p>
                <a href="https://www.instagram.com/diperta_nganjuk/" target="_blank"
                    style="text-decoration: none; color: inherit;">
                    @diperta_nganjuk
                </a>
            </p>

            <a href="https://www.youtube.com/@Diperta.Nganjuk" target="_blank"
                style="text-decoration: none; color: inherit;">
                @diperta.nganjuk
            </a>
            </p>
        </div>
    </div>
</footer>

<!-- Package/Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Animasi melayani-->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init({
    duration: 1000,
    once: true,
    easing: 'ease-in-out' // animasi lebih smooth

});
</script>

<!-- Animasi gambar 3 -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
 AOS.init({
    duration: 1200,          // Animasi sedikit lebih lama
    once: true,              // Hanya animasi sekali saat muncul pertama
    easing: 'ease-in-out-cubic', // Lebih smooth dibanding 'ease-in-out'
    delay: 100               // Tambah delay default agar tidak terlalu cepat
});

</script>


<!-- Script -->
<script>
    function toggleFaq(el) {
        document.querySelectorAll('.faq-item').forEach(item => {
            if (item !== el) {
                item.classList.remove('active');
                item.querySelector('.faq-toggle-icon').textContent = '❯';
            }
        });

        el.classList.toggle('active');
        const icon = el.querySelector('.faq-toggle-icon');
        icon.textContent = el.classList.contains('active') ? '⌃' : '❯';
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Data default jika API gagal
        const defaultData = {
            labels: ['Data Kosong'],
            data: [0]
        };

        // Fungsi untuk buat chart
        function buatChart(labels, data) {
            const ctx = document.getElementById('produksiChart').getContext('2d');

            const backgroundColors = data.map(() => 'rgba(75, 192, 192, 0.5)');
            const borderColors = data.map(() => 'rgba(75, 192, 192, 1)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Musim per Tahun',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        fetch('https://websitaniproject-production-ab46.up.railway.app/api/komoditas/musim', {
                headers: {
                'Accept': 'application/json'
            }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Jaringan error');
                }
                return response.json();
            })
            .then(dataAPI => {
                if (dataAPI.success && Array.isArray(dataAPI.data)) {
                    const labels = dataAPI.data.map(item => item.nama);
                    const data = dataAPI.data.map(item => Number(item.musim));
                    buatChart(labels, data);
                } else {
                    buatChart(['Data Gaenek'], [0]);
                }
            })

            .catch(error => {
                console.error('Gagal mengambil data:', error.message);
                buatChart(['Data azka'], [0]);
            });
    });
</script>
</body>

</html>
