<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kinéthérapeute - Accueil</title>

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/Welcome.css') }}">
</head>
<body>
<header class="header">
    <div class="container">
        <h1 class="logo">Kinéthérapeute Bien-être</h1>
        <nav>
            <ul>
                <li><a href="#about">À propos</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
                @if (Route::has('login'))
                    @auth
                        @if (Auth::user()->isAdmin())
                            <li><a href="{{ url('/admin') }}" class="btn">Espace Admin</a></li>
                        @else
                            <li><a href="{{ url('/schedules') }}" class="btn">Mes Rendez-vous</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="btn">Se connecter</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn btn-primary">Créer un compte</a></li>
                        @endif
                    @endauth
                @endif

            </ul>
        </nav>
    </div>
</header>

<section class="hero">
    <div class="container">
        <h2>Votre bien-être entre de bonnes mains</h2>
        <p>Découvrez nos soins et thérapies adaptés à vos besoins</p>
        <a href="#services" class="btn btn-primary">Nos Services</a>
    </div>
</section>

<section id="about" class="about">
    <div class="container">
        <img src="/images/kinetherapist.jpg" alt="Kinésithérapeute en action">

        <div>
            <h2>À propos</h2>
            <p>Nous offrons des soins spécialisés en kinésithérapie pour soulager vos douleurs et améliorer votre bien-être.</p>
        </div>
    </div>
</section>

<section id="services" class="services">
    <div class="container">
        <h2>Nos Services</h2>
        <div class="service-list">
            <div class="service-item">
                <img src="/images/massotherapie-05.png" alt="Massage thérapeutique">
                <h3>Massages thérapeutiques</h3>
                <p>Techniques adaptées pour détendre vos muscles et soulager les tensions.</p>
            </div>
            <div class="service-item">
                <img src="/images/reeducation.jpg" alt="Rééducation fonctionnelle">
                <h3>Rééducation fonctionnelle</h3>
                <p>Accompagnement pour retrouver mobilité et autonomie après une blessure.</p>
            </div>
            <div class="service-item">
                <img src="/images/sport.jpg" alt="Kinésithérapie du sport">
                <h3>Kinésithérapie du sport</h3>
                <p>Préparation et récupération musculaire pour sportifs amateurs et professionnels.</p>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="contact">
    <div class="container">
        <h2>Contactez-nous</h2>
        <p>Besoin d'une consultation ? Prenez rendez-vous dès aujourd'hui.</p>
        <a href="mailto:contact@kinetherapie.com" class="btn btn-primary">Nous Contacter</a>
    </div>
</section>

<footer>
    <div class="container">
        <p>&copy; 2025 Kinéthérapeute Bien-être - Tous droits réservés</p>
    </div>
</footer>
</body>
</html>
