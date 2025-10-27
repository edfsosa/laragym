<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
            }

            50% {
                box-shadow: 0 0 40px rgba(168, 85, 247, 0.6);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #000000 100%);
        }

        .purple-gradient {
            background: linear-gradient(135deg, #a855f7 0%, #7c3aed 100%);
        }

        .feature-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: #a855f7;
            box-shadow: 0 20px 40px rgba(168, 85, 247, 0.3);
        }

        .logo-text {
            font-weight: 900;
            font-size: 1.75rem;
            letter-spacing: -0.02em;
        }

        .smart-white {
            color: white;
        }

        .gym-purple {
            color: #a855f7;
        }

        .scroll-smooth {
            scroll-behavior: smooth;
        }

        .nav-glass {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(168, 85, 247, 0.2);
        }
    </style>
</head>

<body class="scroll-smooth bg-black text-white">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 nav-glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="logo-text">
                        <span class="smart-white">SMART</span><span class="gym-purple">GYM</span>
                    </div>
                </div>
                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-8">
                    <a href="#instalaciones"
                        class="text-gray-300 hover:text-purple-500 transition font-semibold">Instalaciones</a>
                    <a href="#servicios"
                        class="text-gray-300 hover:text-purple-500 transition font-semibold">Servicios</a>
                    <a href="#membresias"
                        class="text-gray-300 hover:text-purple-500 transition font-semibold">Membresías</a>
                    <a href="#contacto"
                        class="text-gray-300 hover:text-purple-500 transition font-semibold">Contacto</a>
                </div>
                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <a href="/login">
                        <button
                            class="px-5 py-2 border border-purple-500 text-purple-500 rounded-lg font-bold hover:bg-purple-500 hover:text-white transition transform hover:scale-105">
                            Iniciar
                            Sesión</button>
                    </a>
                    <a href="/contact-form">
                        <button
                            class="px-6 py-2 purple-gradient text-white rounded-lg font-bold hover:opacity-90 transition transform hover:scale-105">
                            Únete
                            Ahora</button>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg pt-32 pb-20 px-4 relative overflow-hidden">
        <!-- Background Blurs -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-64 h-64 bg-purple-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>
        <!-- Hero Content -->
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Hero Text -->
                <div class="text-white animate-fade-in-up">
                    <!-- Main Heading -->
                    <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">
                        Alcanzá tus <span class="gym-purple">metas</span>
                    </h1>
                    <!-- Subheading -->
                    <p class="text-xl mb-8 text-gray-300 leading-relaxed">
                        Te ofrecemos las mejores instalaciones y entrenadores para lograr tus objetivos fitness.
                    </p>
                    <!-- Join Now Button -->
                    <a href="/contact-form">
                        <button
                            class="px-8 py-4 purple-gradient text-white rounded-xl font-black text-xl hover:opacity-90 transition transform hover:scale-105">
                            Únete
                            Ahora</button>
                    </a>
                    <!-- Stats -->
                    <div class="mt-10 grid grid-cols-3 gap-6">
                        <div class="text-center">
                            <p class="text-4xl font-black gym-purple">500+</p>
                            <p class="text-gray-400 text-sm">Equipos Modernos</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-black gym-purple">15+</p>
                            <p class="text-gray-400 text-sm">Entrenadores Pro</p>
                        </div>
                        <div class="text-center">
                            <p class="text-4xl font-black gym-purple">24/7</p>
                            <p class="text-gray-400 text-sm">Abierto</p>
                        </div>
                    </div>
                </div>
                <!-- Hero Image with Available Schedules -->
                <div class="animate-float">
                    <div
                        class="bg-linear-to-br from-gray-900 to-black rounded-2xl shadow-2xl p-8 border-2 border-purple-500 transform rotate-2">
                        <div class="purple-gradient rounded-xl p-6 text-white">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-black">Horarios Disponibles</h3>
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                            </div>
                            <!-- Schedule List -->
                            <div class="space-y-4">
                                <div
                                    class="bg-black bg-opacity-30 rounded-lg p-4 border border-purple-400 border-opacity-30">
                                    <p class="text-sm text-purple-200 mb-1">Spinning</p>
                                    <p class="text-2xl font-black">6:00 AM - Hoy</p>
                                    <p class="text-xs text-green-400 mt-1">8 cupos disponibles</p>
                                </div>
                                <div
                                    class="bg-black bg-opacity-30 rounded-lg p-4 border border-purple-400 border-opacity-30">
                                    <p class="text-sm text-purple-200 mb-1">CrossFit</p>
                                    <p class="text-2xl font-black">7:30 AM - Hoy</p>
                                    <p class="text-xs text-green-400 mt-1">5 cupos disponibles</p>
                                </div>
                                <div
                                    class="bg-black bg-opacity-30 rounded-lg p-4 border border-purple-400 border-opacity-30">
                                    <p class="text-sm text-purple-200 mb-1">Yoga</p>
                                    <p class="text-2xl font-black">6:00 PM - Hoy</p>
                                    <p class="text-xs text-green-400 mt-1">12 cupos disponibles</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instalaciones Section -->
    <section id="instalaciones" class="py-20 px-4 bg-linear-to-brom-black to-gray-900">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black text-white mb-4">Instalaciones <span class="gym-purple">de Primera</span>
                </h2>
                <p class="text-xl text-gray-400">Equipamiento de última generación para tu entrenamiento</p>
            </div>
            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                @forelse ($facilities as $facility)
                    <div class="feature-card bg-linear-to-br from-gray-900 to-black rounded-xl p-8">
                        {{-- <div class="text-6xl mb-4">🏋️</div> --}}
                        <h3 class="text-2xl font-black text-white mb-3">{{ $facility->name }}</h3>
                        <p class="text-gray-400">{{ $facility->summary }}</p>
                    </div>
                @empty
                    <p class="text-gray-400">No hay instalaciones disponibles en este momento.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Servicios Section -->
    <section id="servicios" class="py-20 px-4 bg-black">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Services -->
                <div>
                    <!-- Section Header -->
                    <h2 class="text-5xl font-black text-white mb-8">Servicios <span class="gym-purple">Destacados</span>
                    </h2>
                    <!-- Services List -->
                    <div class="space-y-6">
                        @forelse ($services as $service)
                            <div class="flex items-start group">
                                <div
                                    class="shrink-0 w-14 h-14 purple-gradient rounded-xl flex items-center justify-center text-white text-2xl font-black group-hover:scale-110 transition">
                                    👤</div>
                                <div class="ml-5">
                                    <h3 class="text-2xl font-black text-white mb-2">{{ $service->name }}</h3>
                                    <p class="text-gray-400">{{ $service->summary }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400">No hay servicios disponibles en este momento.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Testimonials -->
                <div class="bg-linear-to-brrom-gray-900 to-black rounded-2xl p-8 border-2 border-purple-500">
                    <!-- Section Header -->
                    <h3 class="text-3xl font-black text-white mb-6">Testimonios Reales</h3>
                    <!-- Testimonials List -->
                    <div class="space-y-6">
                        @forelse ($testimonies as $testimony)
                            <div
                                class="bg-black bg-opacity-50 rounded-xl p-6 border border-purple-500 border-opacity-30">
                                <div class="flex mb-3">
                                    <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                                </div>
                                <p class="text-gray-300 mb-4">{{ $testimony->content }}</p>
                                <p class="font-bold text-white">{{ $testimony->author_name }}</p>
                                {{-- <p class="text-sm text-purple-400">Miembro desde 2024</p> --}}
                            </div>
                        @empty
                            <p class="text-gray-400">No hay testimonios disponibles en este momento.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membresías Section -->
    <section id="membresias" class="py-20 px-4 bg-linear-to-b from-black to-gray-900">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-black text-white mb-4">Nuestras <span class="gym-purple">Membresías</span>
                </h2>
                <p class="text-xl text-gray-400">Elige el plan perfecto para tu estilo de vida</p>
            </div>

            <!-- Pricing Cards -->
            <div class="grid md:grid-cols-3 gap-8">
                @forelse ($memberships as $membership)
                    <div
                        class="bg-linear-to-brrom-gray-900 to-black border-2 border-gray-800 rounded-2xl p-8 hover:border-purple-500 transition">
                        <h3 class="text-2xl font-black text-white mb-2">{{ $membership->name }}</h3>
                        <p class="text-gray-400 mb-6">{{ $membership->description }}</p>
                        <p class="text-6xl font-black text-white mb-2">{{ $membership->price }}</p>
                        <p class="text-gray-400 mb-8">Gs/mes</p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center text-gray-300"><span
                                    class="text-purple-500 mr-3 text-xl">✓</span> Acceso al área de pesas</li>
                            <li class="flex items-center text-gray-300"><span
                                    class="text-purple-500 mr-3 text-xl">✓</span> Zona cardio completa</li>
                            <li class="flex items-center text-gray-300"><span
                                    class="text-purple-500 mr-3 text-xl">✓</span> Vestuarios y duchas</li>
                            <li class="flex items-center text-gray-300"><span
                                    class="text-purple-500 mr-3 text-xl">✓</span> Horario flexible</li>
                            <li class="flex items-center text-gray-300"><span
                                    class="text-purple-500 mr-3 text-xl">✓</span> Wifi gratis</li>
                        </ul>
                        <button
                            class="w-full py-4 border-2 border-purple-500 text-purple-500 rounded-xl font-bold hover:bg-purple-500 hover:text-white transition">Elegir
                            Plan</button>
                    </div>
                @empty
                    <p class="text-gray-400">No hay membresías disponibles en este momento.</p>
                @endforelse
            </div>

            <!-- Payment Methods Note -->
            <div class="text-center mt-12">
                <p class="text-purple-400 font-bold">💳 Aceptamos efectivo, tarjetas y transferencias bancarias</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contacto" class="py-20 px-4 bg-black relative overflow-hidden">
        <!-- Background Blurs -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>

        <!-- CTA Content -->
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <!-- Section Header -->
            <h2 class="text-5xl md:text-6xl font-black text-white mb-6">
                ¿Listo para <span class="gym-purple">transformarte?</span>
            </h2>
            <!-- Subheading -->
            <p class="text-xl mb-10 text-purple-400 font-bold">📍 Estamos en Itauguá, Paraguay</p>
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <!-- Join Now Button -->
                <a href="/contact-form">
                    <button
                        class="px-8 py-4 purple-gradient text-white rounded-xl font-black text-xl hover:opacity-90 transition transform hover:scale-105">
                        Únete
                        Ahora</button>
                </a>
                <!-- WhatsApp Contact Button -->
                <a href="https://wa.me/595981234567" target="_blank" rel="noopener noreferrer">
                    <button
                        class="px-8 py-4 purple-gradient text-white rounded-xl font-black text-xl hover:opacity-90 transition transform hover:scale-105">
                        Contáctanos por WhatsApp
                    </button>
                </a>
            </div>
            <!-- Contact Info -->
            <div
                class="grid md:grid-cols-3 gap-6 text-left bg-linear-to-br from-gray-900 to-black rounded-2xl p-8 border border-purple-500 border-opacity-30">
                <div>
                    <p class="text-purple-400 font-bold mb-2">📞 Teléfono</p>
                    <p class="text-white text-lg">{{ $settings->contact_phone }}</p>
                </div>
                <div>
                    <p class="text-purple-400 font-bold mb-2">📧 Email</p>
                    <p class="text-white text-lg">{{ $settings->contact_email }}</p>
                </div>
                <div>
                    <p class="text-purple-400 font-bold mb-2">⏰ Horarios</p>
                    <p class="text-white text-lg">Lunes a Domingo 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black border-t border-gray-900 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- About Section -->
                <div>
                    <!-- Logo and Description -->
                    <div class="logo-text mb-4">
                        <span class="smart-white">SMART</span><span class="gym-purple">GYM</span>
                    </div>
                    <p class="text-gray-500 mb-4">El mejor gimnasio de Itauguá con instalaciones modernas y
                        entrenadores profesionales.</p>
                    <!-- Social Media Links -->
                    <div class="flex space-x-4">
                        <a href="{{ $settings->instagram_url }}"
                            class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:text-purple-500 hover:bg-gray-700 transition">IG</a>
                        <a href="{{ $settings->whatsapp_url }}"
                            class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:text-purple-500 hover:bg-gray-700 transition">WA</a>
                    </div>
                </div>
                <!-- Navigation Links -->
                <div>
                    <h4 class="font-black text-white mb-4">Navegación</h4>
                    <ul class="space-y-2 text-gray-500">
                        <li><a href="#instalaciones" class="hover:text-purple-500 transition">Instalaciones</a></li>
                        <li><a href="#servicios" class="hover:text-purple-500 transition">Servicios</a></li>
                        <li><a href="#membresias" class="hover:text-purple-500 transition">Membresías</a></li>
                        <li><a href="#contacto" class="hover:text-purple-500 transition">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <!-- Contact Info -->
                    <h4 class="font-black text-white mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-500">
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">📍</span>
                            <span>{{ $settings->contact_address }} </span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">📞</span>
                            <span>{{ $settings->contact_phone }} </span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">📧</span>
                            <span>{{ $settings->contact_email }} </span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-purple-500 mr-2">⏰</span>
                            <span>Abierto 24/7</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; 2025 Smart Gym - Itauguá, Paraguay. Todos los derechos reservados.</p>
                <p class="mt-2 text-sm">Desarrollado por NextUp</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animate on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card').forEach(card => {
            observer.observe(card);
        });

        // Mobile menu toggle (optional)
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.className = 'md:hidden text-white';
        mobileMenuBtn.innerHTML = '☰';

        // Add click event for mobile menu if needed
        mobileMenuBtn.addEventListener('click', function() {
            // Toggle mobile menu logic here
        });
    </script>
</body>

</html>
