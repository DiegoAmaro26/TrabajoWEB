@extends('layouts.app')

@section('content')
<style>
    .slide-container {
        position: relative;
        overflow: hidden;
        background: linear-gradient(to right, #1e40af, #60a5fa);
        color: white;
        height: 600px;
    }

    .curve-divider-top,
    .curve-divider-bottom {
        position: absolute;
        width: 100%;
        height: 100px;
        line-height: 0;
        z-index: 5;
    }

    .curve-divider-top {
        top: 0;
        transform: rotate(180deg);
    }

    .curve-divider-bottom {
        bottom: 0;
    }

    .slide {
        display: none;
        align-items: center;
        justify-content: center;
        gap: 3rem;
        padding: 2rem;
        max-width: 1200px;
        margin: auto;
        height: 100%;
    }

    .slide.active {
        display: flex;
    }

    .slide.reverse {
        flex-direction: row-reverse;
    }

    .slide img {
        width: 400px;
        height: auto;
        border-radius: 45px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .slide-content {
        max-width: 500px;
        text-align: center;
    }

    .slide-content h2 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #fff;
    }

    .slide-content p {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #e5e7eb;
    }

    .btn-link {
    display: inline-block;
    margin-top: 1.5rem;
    background-color: #ffffff;
    color: #000000;
    font-weight: bold;
    padding: 0.6rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transition: background-color 0.3s ease, transform 0.2s;
    }

    .btn-link:hover {
        background-color: #f3f4f6; /* gris muy claro */
        transform: translateY(-2px);
    }


    .navigation {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2rem;
        background-color: rgba(0, 0, 0, 0.3);
        color: white;
        border: none;
        padding: 1rem;
        cursor: pointer;
        z-index: 10;
        border-radius: 50%;
    }

    .nav-left {
        left: 20px;
    }

    .nav-right {
        right: 20px;
    }

    @media (max-width: 768px) {
        .slide {
            flex-direction: column !important;
        }

        .slide img {
            width: 90%;
        }

        .navigation {
            font-size: 1.5rem;
            padding: 0.7rem;
        }
    }
</style>

<div class="slide-container">
    <!-- Curva decorativa superior -->
    <div class="curve-divider-top">
        <svg viewBox="0 0 1440 150" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path fill="#ffffff" d="M0,0 C480,100 960,100 1440,0 L1440,150 L0,150 Z"></path>
        </svg>
    </div>

    <!-- Slide 1 -->
    <div class="slide active">
        <img src="{{ asset('images/veterinary_team.jpg') }}" alt="Equipo veterinario">
        <div class="slide-content">
            <h2>Bienvenido a PetMedicine</h2>
            <p>
                Nos enorgullece presentarte <strong>PetMedicine</strong>, tu plataforma digital para conectar con centros veterinarios de confianza. 
                Nuestro objetivo es unir tecnología y salud animal para ofrecer servicios modernos, seguros y eficientes.
            </p>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="slide reverse">
        <img src="{{ asset('images/veterinary_center.jpg') }}" alt="Centro veterinario">
        <div class="slide-content">
            <h2>Centros veterinarios asociados</h2>
            <p>
                PetMedicine trabaja en colaboración con una red de centros veterinarios. Accede a información de contacto, ubicación y especialidades de cada hospital, para que encuentres la ayuda adecuada cuando más la necesitas.
            </p>
            <a href="{{ route('centros') }}" class="btn-link">Ver centros</a>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="slide">
        <img src="{{ asset('images/veterinary_director.jpg') }}" alt="Director veterinario">
        <div class="slide-content">
            <h2>Trabaja con nosotros</h2>
            <p>
                ¿Buscas una oportunidad profesional en el mundo veterinario? Únete a nuestra bolsa de empleo y accede a vacantes en los centros veterinarios asociados a PetMedicine.
            </p>
            <a href="{{ route('trabaja') }}" class="btn-link">Enviar solicitud</a>
        </div>
    </div>

    <!-- Navegación -->
    <button class="navigation nav-left" onclick="moveSlide(-1)">❮</button>
    <button class="navigation nav-right" onclick="moveSlide(1)">❯</button>

    <!-- Curva decorativa inferior -->
    <div class="curve-divider-bottom">
        <svg viewBox="0 0 1440 150" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path fill="#ffffff" d="M0,0 C480,100 960,100 1440,0 L1440,150 L0,150 Z"></path>
        </svg>
    </div>
</div>

<script>
    /**
     * The function `moveSlide` changes the active slide by removing the 'active' class from the
     * current slide and adding it to the next slide based on the direction parameter.
     */
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');

    function moveSlide(direction) {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
    }
</script>
@endsection
