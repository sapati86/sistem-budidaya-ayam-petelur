<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Informasi Manajemen Budidaya Ayam Petelur</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(160deg, #eff6ff 0%, #dbeafe 40%, #bfdbfe 70%, #93c5fd 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 70% 30%, rgba(255, 255, 255, 0.4) 0%, transparent 60%),
                        radial-gradient(ellipse at 30% 70%, rgba(147, 197, 253, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }

        /* ===== FLOATING EGG ANIMATION ===== */
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        .floating-delay-1 { animation-delay: 1s; }
        .floating-delay-2 { animation-delay: 2s; }
        .floating-delay-3 { animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-16px) rotate(3deg); }
        }

        .illustration-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .illustration-container .barn {
            font-size: 140px;
            filter: drop-shadow(0 20px 60px rgba(37, 99, 235, 0.15));
            animation: float 7s ease-in-out infinite;
        }

        .illustration-container .chicken {
            font-size: 80px;
            position: absolute;
            animation: float 5s ease-in-out infinite;
        }

        .illustration-container .chicken:nth-child(2) {
            top: 10%;
            right: 5%;
            animation-delay: 0.5s;
            font-size: 70px;
        }

        .illustration-container .chicken:nth-child(3) {
            bottom: 15%;
            left: 0%;
            animation-delay: 1.5s;
            font-size: 60px;
        }

        .illustration-container .chicken:nth-child(4) {
            top: 25%;
            left: 15%;
            animation-delay: 2.5s;
            font-size: 50px;
        }

        .illustration-container .egg-float {
            position: absolute;
            font-size: 30px;
            animation: float 4s ease-in-out infinite;
        }

        .illustration-container .egg-float:nth-child(5) {
            top: 5%;
            left: 40%;
            animation-delay: 0.8s;
            font-size: 28px;
        }

        .illustration-container .egg-float:nth-child(6) {
            bottom: 5%;
            right: 25%;
            animation-delay: 1.8s;
            font-size: 24px;
        }

        .illustration-container .egg-float:nth-child(7) {
            top: 40%;
            right: 0%;
            animation-delay: 3s;
            font-size: 32px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .glass-card-dark {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.35);
        }

        .btn-outline {
            border: 1.5px solid rgba(37, 99, 235, 0.3);
            color: #1e40af;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: rgba(37, 99, 235, 0.05);
            border-color: #2563eb;
            transform: translateY(-2px);
        }

        .stats-number {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-card {
            background: white;
            transition: all 0.3s ease;
            border: 1px solid rgba(37, 99, 235, 0.06);
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.08);
            border-color: rgba(37, 99, 235, 0.15);
        }

        .feature-icon {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #2563eb;
        }

        .egg-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .egg-bg .egg {
            position: absolute;
            font-size: 24px;
            opacity: 0.06;
            animation: eggFloat 25s linear infinite;
        }

        .egg-bg .egg:nth-child(1) { left: 5%; top: 10%; animation-duration: 22s; }
        .egg-bg .egg:nth-child(2) { left: 15%; top: 70%; animation-duration: 28s; animation-delay: 3s; }
        .egg-bg .egg:nth-child(3) { left: 30%; top: 25%; animation-duration: 20s; animation-delay: 5s; }
        .egg-bg .egg:nth-child(4) { left: 50%; top: 80%; animation-duration: 26s; animation-delay: 1s; }
        .egg-bg .egg:nth-child(5) { left: 65%; top: 15%; animation-duration: 24s; animation-delay: 7s; }
        .egg-bg .egg:nth-child(6) { left: 80%; top: 60%; animation-duration: 30s; animation-delay: 2s; }
        .egg-bg .egg:nth-child(7) { left: 90%; top: 35%; animation-duration: 18s; animation-delay: 4s; }
        .egg-bg .egg:nth-child(8) { left: 40%; top: 45%; animation-duration: 27s; animation-delay: 6s; }

        @keyframes eggFloat {
            0% { transform: translateY(0) rotate(0deg) scale(1); opacity: 0.04; }
            25% { transform: translateY(-80px) rotate(90deg) scale(1.2); opacity: 0.1; }
            50% { transform: translateY(60px) rotate(180deg) scale(0.8); opacity: 0.06; }
            75% { transform: translateY(-60px) rotate(270deg) scale(1.1); opacity: 0.08; }
            100% { transform: translateY(0) rotate(360deg) scale(1); opacity: 0.04; }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem !important;
            }
            .illustration-container .barn {
                font-size: 80px;
            }
            .illustration-container .chicken {
                font-size: 40px !important;
            }
            .illustration-container .chicken:nth-child(2) { font-size: 35px !important; }
            .illustration-container .chicken:nth-child(3) { font-size: 30px !important; }
            .illustration-container .chicken:nth-child(4) { font-size: 28px !important; }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.8rem !important;
            }
            .illustration-container .barn {
                font-size: 60px;
            }
            .illustration-container .chicken {
                font-size: 28px !important;
            }
        }
    </style>
</head>
<body>

    <div class="egg-bg">
        <div class="egg">🥚</div>
        <div class="egg">🥚</div>
        <div class="egg">🥚</div>
        <div class="egg">🥚</div>
        <div class="egg">🥚</div>
        <div class="egg">🥚</div>
        <div class="egg">🥚</div>
        <div class="egg">🥚</div>
    </div>

    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/70 backdrop-blur-md border-b border-blue-100/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🐔</span>
                    <span class="text-blue-900 font-bold text-xl tracking-tight">
                        Ayam<span class="text-blue-500">Petelur</span>
                    </span>
                </div>

                
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-blue-700/70 hover:text-blue-900 transition text-sm font-medium">Fitur</a>
                    <a href="#stats" class="text-blue-700/70 hover:text-blue-900 transition text-sm font-medium">Statistik</a>
                    <a href="#testimonials" class="text-blue-700/70 hover:text-blue-900 transition text-sm font-medium">Testimoni</a>
                    <a href="#contact" class="text-blue-700/70 hover:text-blue-900 transition text-sm font-medium">Kontak</a>
                </div>

                
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-blue-700 hover:text-blue-900 transition">
                            <i class="fas fa-user mr-1"></i> Dashboard
                        </a>
                    @else
                        <button onclick="openLoginModal()" class="text-sm text-blue-700 hover:text-blue-900 transition">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="hero-gradient min-h-screen flex items-center justify-center pt-16 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">

                {{-- Left Content --}}
                <div>
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 bg-white/60 backdrop-blur-sm rounded-full px-4 py-1.5 mb-6 border border-blue-100/50">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        <span class="text-blue-700 text-xs font-medium tracking-wider">SISTEM INFORMASI MANAJEMEN</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-blue-900 leading-tight hero-title">
                        Kelola Budidaya
                        <span class="text-blue-500">Ayam Petelur</span>
                        <br />
                        <span class="text-xl md:text-2xl font-normal text-blue-600/70">Modern & Terintegrasi</span>
                    </h1>

                    {{-- Description --}}
                    <p class="text-blue-700/60 text-lg mt-6 max-w-lg leading-relaxed">
                        Sistem informasi canggih untuk mengelola <strong class="text-blue-800">kandang</strong>,
                        <strong class="text-blue-800">ayam</strong>, <strong class="text-blue-800">produksi telur</strong>,
                        <strong class="text-blue-800">pakan</strong>, dan <strong class="text-blue-800">kesehatan</strong>
                        secara digital dan real-time.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap gap-4 mt-8">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary text-white px-8 py-3 rounded-xl font-semibold flex items-center gap-2">
                                <i class="fas fa-rocket"></i> Dashboard
                            </a>
                        @else
                            <button onclick="openLoginModal()" class="btn-primary text-white px-8 py-3 rounded-xl font-semibold flex items-center gap-2">
                                <i class="fas fa-rocket"></i> Mulai Sekarang
                            </button>
                            <button onclick="openLoginModal()" class="btn-outline px-8 py-3 rounded-xl font-semibold flex items-center gap-2">
                                <i class="fas fa-play-circle"></i> Lihat Fitur
                            </button>
                        @endauth
                    </div>

                    {{-- Trust Badges --}}
                    <div class="flex items-center gap-6 mt-8 text-blue-600/50 text-sm">
                        <span><i class="fas fa-check-circle text-blue-500 mr-1"></i> Gratis</span>
                        <span><i class="fas fa-check-circle text-blue-500 mr-1"></i> 2FA Security</span>
                        <span><i class="fas fa-check-circle text-blue-500 mr-1"></i> Real-time</span>
                    </div>
                </div>

                {{-- Right Content - Illustration --}}
                <div class="illustration-container">
                    {{-- Floating Eggs --}}
                    <div class="egg-float floating" style="top: 0%; left: 10%;">🥚</div>
                    <div class="egg-float floating floating-delay-1" style="bottom: 5%; right: 5%;">🥚</div>
                    <div class="egg-float floating floating-delay-2" style="top: 30%; right: -5%;">🥚</div>
                    <div class="egg-float floating floating-delay-3" style="bottom: 30%; left: -5%;">🥚</div>

                    {{-- Main Illustration --}}
                    <div class="relative flex justify-center items-center">
                        {{-- Barn / Kandang --}}
                        <div class="barn floating">🏚️</div>

                        {{-- Chickens around barn --}}
                        <div class="chicken floating" style="top: 5%; right: 5%;">🐔</div>
                        <div class="chicken floating floating-delay-1" style="bottom: 10%; left: 0%;">🐔</div>
                        <div class="chicken floating floating-delay-2" style="top: 20%; left: 10%;">🐔</div>
                        <div class="chicken floating floating-delay-3" style="bottom: 20%; right: 0%;">🐔</div>
                        <div class="chicken floating" style="top: 45%; left: -5%; font-size: 45px;">🐔</div>
                        <div class="chicken floating floating-delay-1" style="bottom: 45%; right: -5%; font-size: 45px;">🐔</div>
                    </div>

                    {{-- Glass Card overlay --}}
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/3 glass-card rounded-2xl px-6 py-3 shadow-lg">
                        <div class="flex items-center gap-4">
                            <span class="text-2xl">🥚</span>
                            <div>
                                <div class="text-blue-900 font-bold text-sm">10.000+</div>
                                <div class="text-blue-600/60 text-xs">Telur diproduksi</div>
                            </div>
                            <span class="w-px h-8 bg-blue-200/50"></span>
                            <div>
                                <div class="text-blue-900 font-bold text-sm">50+</div>
                                <div class="text-blue-600/60 text-xs">Peternak aktif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 30C240 55 480 5 720 30C960 55 1200 5 1440 30V60H0V30Z" fill="#f8fafc" opacity="0.4"/>
                <path d="M0 40C240 58 480 15 720 40C960 58 1200 15 1440 40V60H0V40Z" fill="#f8fafc" opacity="0.7"/>
                <path d="M0 50C240 60 480 25 720 50C960 60 1200 25 1440 50V60H0V50Z" fill="#f8fafc"/>
            </svg>
        </div>
    </section>

    <section id="features" class="bg-[#f8fafc] py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-500 text-sm font-semibold tracking-wider uppercase">Fitur Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mt-2">
                    Solusi Lengkap untuk <span class="text-blue-500">Peternakan Anda</span>
                </h2>
                <p class="text-blue-600/60 mt-4 max-w-2xl mx-auto">
                    Dirancang untuk membantu Anda mengelola budidaya ayam petelur dengan efisien dan efektif.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="feature-card rounded-2xl p-6">
                    <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-warehouse text-xl"></i>
                    </div>
                    <h3 class="text-blue-900 font-semibold text-lg">Manajemen Kandang</h3>
                    <p class="text-blue-600/60 text-sm mt-2 leading-relaxed">
                        Kelola data kandang, kapasitas, status, dan foto dengan sistem CRUD yang mudah.
                    </p>
                </div>

                <div class="feature-card rounded-2xl p-6">
                    <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-dove text-xl"></i>
                    </div>
                    <h3 class="text-blue-900 font-semibold text-lg">Manajemen Ayam</h3>
                    <p class="text-blue-600/60 text-sm mt-2 leading-relaxed">
                        Catat data ayam, jenis, umur, status kesehatan, dan produksi telur per minggu.
                    </p>
                </div>

                <div class="feature-card rounded-2xl p-6">
                    <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-egg text-xl"></i>
                    </div>
                    <h3 class="text-blue-900 font-semibold text-lg">Produksi Telur</h3>
                    <p class="text-blue-600/60 text-sm mt-2 leading-relaxed">
                        Pencatatan produksi telur harian dengan kualitas, berat, dan foto.
                    </p>
                </div>

                <div class="feature-card rounded-2xl p-6">
                    <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                    <h3 class="text-blue-900 font-semibold text-lg">Manajemen Pakan</h3>
                    <p class="text-blue-600/60 text-sm mt-2 leading-relaxed">
                        Kelola stok pakan, jenis, harga, dan konsumsi harian dengan notifikasi stok menipis.
                    </p>
                </div>

                <div class="feature-card rounded-2xl p-6">
                    <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-heartbeat text-xl"></i>
                    </div>
                    <h3 class="text-blue-900 font-semibold text-lg">Kesehatan Ayam</h3>
                    <p class="text-blue-600/60 text-sm mt-2 leading-relaxed">
                        Catat penyakit, gejala, tindakan, dan status kesehatan ayam secara terintegrasi.
                    </p>
                </div>

                <div class="feature-card rounded-2xl p-6">
                    <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-blue-900 font-semibold text-lg">Dashboard & Laporan</h3>
                    <p class="text-blue-600/60 text-sm mt-2 leading-relaxed">
                        Monitoring real-time dengan grafik interaktif dan ekspor laporan ke Excel.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="bg-white py-16 border-y border-blue-100/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold stats-number">7+</div>
                    <div class="text-blue-600/60 text-sm mt-1">Modul Terintegrasi</div>
                </div>
                <div>
                    <div class="text-4xl font-bold stats-number">100%</div>
                    <div class="text-blue-600/60 text-sm mt-1">Berbasis Web</div>
                </div>
                <div>
                    <div class="text-4xl font-bold stats-number">🔐</div>
                    <div class="text-blue-600/60 text-sm mt-1">Keamanan 2FA</div>
                </div>
                <div>
                    <div class="text-4xl font-bold stats-number">📊</div>
                    <div class="text-blue-600/60 text-sm mt-1">Laporan Real-time</div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="bg-[#f8fafc] py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-500 text-sm font-semibold tracking-wider uppercase">Testimoni</span>
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mt-2">
                    Apa Kata <span class="text-blue-500">Pengguna</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 border border-blue-100/30 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                            R
                        </div>
                        <div>
                            <h4 class="text-blue-900 font-semibold text-sm">Ricky Zulkarnain</h4>
                            <p class="text-blue-600/50 text-xs">Admin</p>
                        </div>
                    </div>
                    <p class="text-blue-700/60 text-sm leading-relaxed">
                        "Sistem ini sangat membantu saya mengelola kandang dan produksi telur dengan mudah. Dashboard yang informatif!"
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-blue-100/30 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                            F
                        </div>
                        <div>
                            <h4 class="text-blue-900 font-semibold text-sm">Fardin Rano</h4>
                            <p class="text-blue-600/50 text-xs">User</p>
                        </div>
                    </div>
                    <p class="text-blue-700/60 text-sm leading-relaxed">
                        "Pencatatan produksi harian jadi lebih cepat dan akurat. Fitur 2FA membuat data lebih aman."
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-blue-100/30 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                            W
                        </div>
                        <div>
                            <h4 class="text-blue-900 font-semibold text-sm">Wa Ode Farmika</h4>
                            <p class="text-blue-600/50 text-xs">User</p>
                        </div>
                    </div>
                    <p class="text-blue-700/60 text-sm leading-relaxed">
                        "Sangat membantu dalam memantau kesehatan ayam dan konsumsi pakan. Laporan Excel sangat berguna!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gradient-to-b from-[#f8fafc] to-white">
        <div class="max-w-4xl mx-auto text-center px-4">
            <div class="bg-white rounded-3xl p-12 border border-blue-100/30 shadow-lg">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900">
                    Siap Meningkatkan <span class="text-blue-500">Produktivitas</span> Peternakan?
                </h2>
                <p class="text-blue-600/60 mt-4 max-w-2xl mx-auto">
                    Bergabunglah dengan ribuan peternak yang sudah menggunakan sistem ini untuk mengelola budidaya ayam petelur secara modern.
                </p>
                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary text-white px-8 py-3 rounded-xl font-semibold flex items-center gap-2">
                            <i class="fas fa-rocket"></i> Dashboard
                        </a>
                    @else
                        <button onclick="openLoginModal()" class="btn-primary text-white px-8 py-3 rounded-xl font-semibold flex items-center gap-2">
                            <i class="fas fa-user-plus"></i> Mulai Sekarang
                        </button>
                        <button onclick="openLoginModal()" class="btn-outline px-8 py-3 rounded-xl font-semibold flex items-center gap-2">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <footer id="contact" class="bg-white border-t border-blue-100/30 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl">🐔</span>
                        <span class="text-blue-900 font-bold text-lg">Ayam<span class="text-blue-500">Petelur</span></span>
                    </div>
                    <p class="text-blue-600/50 text-sm">
                        Sistem Informasi Manajemen Budidaya Ayam Petelur berbasis web dengan teknologi modern.
                    </p>
                </div>
                <div>
                    <h4 class="text-blue-900 font-semibold mb-3">Fitur</h4>
                    <ul class="space-y-2 text-sm text-blue-600/50">
                        <li>Manajemen Kandang</li>
                        <li>Manajemen Ayam</li>
                        <li>Produksi Telur</li>
                        <li>Manajemen Pakan</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-blue-900 font-semibold mb-3">Teknologi</h4>
                    <ul class="space-y-2 text-sm text-blue-600/50">
                        <li>Laravel 12</li>
                        <li>Tailwind CSS</li>
                        <li>Chart.js</li>
                        <li>MySQL</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-blue-900 font-semibold mb-3">Kontak</h4>
                    <ul class="space-y-2 text-sm text-blue-600/50">
                        <li><i class="fas fa-envelope mr-2 text-blue-400"></i> info@ayampetelur.com</li>
                        <li><i class="fas fa-phone mr-2 text-blue-400"></i> +62 812 3456 7890</li>
                        <li><i class="fas fa-map-marker-alt mr-2 text-blue-400"></i> Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-blue-100/30 mt-8 pt-8 text-center text-blue-600/40 text-sm">
                &copy; {{ date('Y') }} Sistem Informasi Manajemen Budidaya Ayam Petelur. All rights reserved.
            </div>
        </div>
    </footer>

    @auth
        {{-- Jika sudah login, modal tidak perlu ditampilkan --}}
    @else
    <div id="loginModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 relative">

            {{-- Close Button --}}
            <button onclick="closeLoginModal()" type="button" 
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition text-xl">
                <i class="fas fa-times"></i>
            </button>

            {{-- Header --}}
            <div class="text-center mb-5">
                <div class="text-4xl mb-2">🐔</div>
                <h2 class="text-xl font-bold text-gray-800">Login</h2>
                <p class="text-gray-400 text-sm">Masuk ke akun Anda</p>
            </div>

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition @error('email') border-red-500 @enderror"
                           placeholder="admin@petelur.com" required autofocus>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition @error('password') border-red-500 @enderror"
                           placeholder="••••••••" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between text-sm mb-4">
                    <label class="flex items-center text-gray-600">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-blue-500 focus:ring-blue-200">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-blue-500 hover:text-blue-700 transition">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-semibold transition shadow-md shadow-blue-500/25 flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            {{-- Error Global --}}
            @if ($errors->any())
                <div class="mt-3 text-red-500 text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Register Link --}}
            <div class="mt-4 text-center text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 font-medium transition">
                    Daftar sekarang
                </a>
            </div>
        </div>
    </div>

    <script>

        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            if (!modal) return;
            modal.style.display = 'flex';
            modal.style.opacity = '0';
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                modal.style.opacity = '1';
            });
        }

        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            if (!modal) return;
            modal.style.opacity = '0';
            document.body.style.overflow = '';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 200);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('loginModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) closeLoginModal();
                });
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('loginModal');
                if (modal && modal.style.display === 'flex') {
                    closeLoginModal();
                }
            }
        });

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openLoginModal();
            });
        @endif
    </script>
    @endauth

</body>
</html>