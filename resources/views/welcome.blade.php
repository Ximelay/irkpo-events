<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Система управления мероприятиями - ИРКПО</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="min-h-screen flex flex-col">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">ИРКПО События</h1>
                                <p class="text-xs text-gray-600">Система управления мероприятиями</p>
                            </div>
                        </div>

                        @if (Route::has('login'))
                            <nav class="flex items-center gap-3">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium text-sm">
                                        Панель управления
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 transition-colors font-medium text-sm">
                                        Вход
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium text-sm">
                                            Регистрация
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Hero Section -->
            <main class="flex-grow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <!-- Hero Content -->
                    <div class="text-center mb-16">
                        <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                            Управляйте мероприятиями <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">легко и эффективно</span>
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                            Полноценная система для организации и учёта мероприятий учебного заведения.
                            Регистрация участников, управление группами, инвентарём и формирование отчётов.
                        </p>
                        @guest
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('login') }}" class="px-8 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all font-semibold text-lg shadow-lg hover:shadow-xl">
                                    Войти в систему
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-indigo-600 border-2 border-indigo-600 rounded-xl hover:bg-indigo-50 transition-all font-semibold text-lg">
                                        Регистрация
                                    </a>
                                @endif
                            </div>
                        @else
                            <a href="{{ url('/dashboard') }}" class="inline-block px-8 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all font-semibold text-lg shadow-lg hover:shadow-xl">
                                Перейти к панели управления
                            </a>
                        @endguest
                    </div>

                    <!-- Features Grid -->
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        <!-- Feature 1 -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Управление мероприятиями</h3>
                            <p class="text-gray-600">Создавайте и редактируйте мероприятия, назначайте организаторов и отслеживайте статус проведения.</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Регистрация участников</h3>
                            <p class="text-gray-600">Регистрируйте студентов и группы на мероприятия, ведите учёт посещаемости.</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Факультеты и группы</h3>
                            <p class="text-gray-600">Структурированное управление факультетами, специальностями и учебными группами.</p>
                        </div>

                        <!-- Feature 4 -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Учёт инвентаря</h3>
                            <p class="text-gray-600">Контролируйте использование оборудования и инвентаря на мероприятиях.</p>
                        </div>

                        <!-- Feature 5 -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Отчёты и статистика</h3>
                            <p class="text-gray-600">Формируйте отчёты по участию групп, студентов и эффективности мероприятий.</p>
                        </div>

                        <!-- Feature 6 -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow border border-gray-100">
                            <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Кураторы и организаторы</h3>
                            <p class="text-gray-600">Назначайте ответственных за группы и мероприятия для эффективной координации.</p>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white/80 backdrop-blur-md border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-gray-600 text-sm">
                            © {{ date('Y') }} ИРКПО. Система управления мероприятиями.
                        </p>
                        <p class="text-gray-500 text-xs">
                            Разработано для Иркутского регионального колледжа педагогического образования
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
