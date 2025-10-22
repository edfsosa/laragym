<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="csrf-token-here">
    <title>Laragym - Sistema de Gestión para Gimnasios</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .scroll-smooth {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="scroll-smooth bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-white">💪 Laragym</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-white hover:text-purple-200 transition">Características</a>
                    <a href="#benefits" class="text-white hover:text-purple-200 transition">Beneficios</a>
                    <a href="#pricing" class="text-white hover:text-purple-200 transition">Precios</a>
                    <a href="#contact" class="text-white hover:text-purple-200 transition">Contacto</a>
                </div>
                <div class="flex space-x-4">
                    <a href="/login">
                        <button
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition">Iniciar
                            Sesión</button>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg pt-32 pb-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white animate-fade-in-up">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Gestiona tu gimnasio con <span class="text-yellow-300">inteligencia</span>
                    </h1>
                    <p class="text-xl mb-8 text-purple-100">
                        Sistema completo para administrar membresías, clases, pagos y más. Todo lo que necesitas en una
                        sola plataforma.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button
                            class="px-8 py-4 bg-yellow-400 text-purple-900 rounded-lg font-bold text-lg hover:bg-yellow-300 transition transform hover:scale-105">
                            Comenzar Ahora
                        </button>
                        <button
                            class="px-8 py-4 bg-white bg-opacity-20 text-white rounded-lg font-bold text-lg hover:bg-opacity-30 transition">
                            Ver Demo
                        </button>
                    </div>
                    <div class="mt-8 flex items-center space-x-6">
                        <div>
                            <p class="text-3xl font-bold">500+</p>
                            <p class="text-purple-200">Gimnasios</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold">50K+</p>
                            <p class="text-purple-200">Miembros</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold">99.9%</p>
                            <p class="text-purple-200">Uptime</p>
                        </div>
                    </div>
                </div>
                <div class="animate-float">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 transform rotate-3">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl p-6 text-white">
                            <h3 class="text-2xl font-bold mb-4">Panel de Control</h3>
                            <div class="space-y-4">
                                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                                    <p class="text-sm opacity-80">Miembros Activos</p>
                                    <p class="text-3xl font-bold">1,247</p>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                                    <p class="text-sm opacity-80">Ingresos del Mes</p>
                                    <p class="text-3xl font-bold">$45,890</p>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                                    <p class="text-sm opacity-80">Clases Hoy</p>
                                    <p class="text-3xl font-bold">18</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Características Principales</h2>
                <p class="text-xl text-gray-600">Todo lo que necesitas para gestionar tu gimnasio eficientemente</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8">
                    <div class="text-5xl mb-4">👥</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Gestión de Miembros</h3>
                    <p class="text-gray-700">Control completo de membresías, planes, renovaciones y estado de cada
                        miembro en tiempo real.</p>
                </div>

                <div class="feature-card bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-8">
                    <div class="text-5xl mb-4">📅</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Calendario de Clases</h3>
                    <p class="text-gray-700">Programa y gestiona clases grupales, reservas en línea y control de
                        capacidad automático.</p>
                </div>

                <div class="feature-card bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8">
                    <div class="text-5xl mb-4">💳</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Pagos Automatizados</h3>
                    <p class="text-gray-700">Cobros automáticos, recordatorios de pago y generación de reportes
                        financieros detallados.</p>
                </div>

                <div class="feature-card bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-8">
                    <div class="text-5xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Reportes y Analytics</h3>
                    <p class="text-gray-700">Métricas en tiempo real, gráficos interactivos y reportes personalizables
                        para tomar mejores decisiones.</p>
                </div>

                <div class="feature-card bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-8">
                    <div class="text-5xl mb-4">📱</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">App para Miembros</h3>
                    <p class="text-gray-700">Portal web intuitivo donde los miembros pueden reservar clases, ver su
                        progreso y gestionar pagos.</p>
                </div>

                <div class="feature-card bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-8">
                    <div class="text-5xl mb-4">🔔</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Notificaciones</h3>
                    <p class="text-gray-700">Envía recordatorios automáticos por email y SMS para clases, pagos y
                        promociones especiales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">¿Por qué elegir Laragym?</h2>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center text-white text-2xl">
                                ✓</div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Fácil de usar</h3>
                                <p class="text-gray-600">Interface intuitiva que no requiere capacitación. Tu equipo
                                    estará listo en minutos.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center text-white text-2xl">
                                ✓</div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Ahorra tiempo</h3>
                                <p class="text-gray-600">Automatiza tareas repetitivas y enfócate en hacer crecer tu
                                    negocio.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center text-white text-2xl">
                                ✓</div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Aumenta ingresos</h3>
                                <p class="text-gray-600">Reduce la morosidad con cobros automáticos y retiene más
                                    miembros con mejor servicio.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center text-white text-2xl">
                                ✓</div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Soporte 24/7</h3>
                                <p class="text-gray-600">Equipo de soporte disponible siempre que lo necesites, en
                                    español.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl p-8 text-white">
                    <h3 class="text-3xl font-bold mb-6">Testimonios</h3>
                    <div class="space-y-6">
                        <div class="bg-white bg-opacity-20 rounded-xl p-6">
                            <p class="mb-4">"Laragym transformó completamente la gestión de nuestro gimnasio.
                                Ahorramos 10 horas semanales en administración."</p>
                            <p class="font-bold">- Carlos Mendoza, FitZone</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-xl p-6">
                            <p class="mb-4">"La mejor inversión que hemos hecho. Los miembros aman poder reservar
                                clases desde su celular."</p>
                            <p class="font-bold">- María González, PowerGym</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Planes para cada tamaño de gimnasio</h2>
                <p class="text-xl text-gray-600">Sin costos ocultos. Cancela cuando quieras.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="border-2 border-gray-200 rounded-xl p-8 hover:border-purple-500 transition">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                    <p class="text-gray-600 mb-6">Para gimnasios pequeños</p>
                    <p class="text-5xl font-bold text-gray-900 mb-6">$49<span
                            class="text-xl text-gray-600">/mes</span></p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Hasta 100 miembros
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Gestión básica</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Portal de miembros
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte email</li>
                    </ul>
                    <button
                        class="w-full py-3 border-2 border-purple-500 text-purple-500 rounded-lg font-bold hover:bg-purple-500 hover:text-white transition">Comenzar</button>
                </div>

                <div class="border-2 border-purple-500 rounded-xl p-8 transform scale-105 shadow-xl relative">
                    <div
                        class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-purple-500 text-white px-4 py-1 rounded-full text-sm font-bold">
                        Popular</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                    <p class="text-gray-600 mb-6">Para gimnasios en crecimiento</p>
                    <p class="text-5xl font-bold text-gray-900 mb-6">$99<span
                            class="text-xl text-gray-600">/mes</span></p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Hasta 500 miembros
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Todo en Starter +
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Reportes avanzados
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Pagos automáticos
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte prioritario
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 bg-purple-500 text-white rounded-lg font-bold hover:bg-purple-600 transition">Comenzar</button>
                </div>

                <div class="border-2 border-gray-200 rounded-xl p-8 hover:border-purple-500 transition">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                    <p class="text-gray-600 mb-6">Para cadenas de gimnasios</p>
                    <p class="text-5xl font-bold text-gray-900 mb-6">$249<span
                            class="text-xl text-gray-600">/mes</span></p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Miembros ilimitados
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Todo en Professional
                            +</li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Múltiples sucursales
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> API personalizada
                        </li>
                        <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte 24/7</li>
                    </ul>
                    <button
                        class="w-full py-3 border-2 border-purple-500 text-purple-500 rounded-lg font-bold hover:bg-purple-500 hover:text-white transition">Contactar</button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="gradient-bg py-20 px-4">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">¿Listo para transformar tu gimnasio?</h2>
            <p class="text-xl mb-8 text-purple-100">Únete a cientos de gimnasios que ya confían en Laragym</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    class="px-8 py-4 bg-yellow-400 text-purple-900 rounded-lg font-bold text-lg hover:bg-yellow-300 transition transform hover:scale-105">
                    Prueba gratis 14 días
                </button>
                <button
                    class="px-8 py-4 bg-white bg-opacity-20 text-white rounded-lg font-bold text-lg hover:bg-opacity-30 transition">
                    Agendar Demo
                </button>
            </div>
            <p class="mt-6 text-purple-200">No se requiere tarjeta de crédito</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">💪 Laragym</h3>
                    <p class="text-gray-400">La solución completa para gestionar tu gimnasio.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Producto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Características</a></li>
                        <li><a href="#" class="hover:text-white transition">Precios</a></li>
                        <li><a href="#" class="hover:text-white transition">Seguridad</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Recursos</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Documentación</a></li>
                        <li><a href="#" class="hover:text-white transition">Soporte</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Empresa</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Acerca de</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Laragym. Construido con Laravel 12. Todos los derechos reservados.</p>
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
    </script>
</body>

</html>
