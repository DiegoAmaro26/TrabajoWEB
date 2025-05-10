<footer class="bg-gradient-to-r from-blue-700 to-blue-400 text-white mt-auto">
    <div class="max-w-6xl mx-auto py-6 px-4 grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
        <div>
            <h3 class="font-semibold mb-2">Contacto</h3>
            <p>Email: contacto@veterinariaweb.com</p>
            <p>Teléfono: +34 900 123 456</p>
        </div>

        <div>
            <h3 class="font-semibold mb-2">Legales</h3>
            <ul class="space-y-1">
                <li><a href="{{ route('privacy') }}" class="hover:underline">Política de privacidad</a></li>
                <li><a href="{{ route('terms') }}" class="hover:underline">Términos y condiciones</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold mb-2">Síguenos</h3>
            <p>Próximamente en redes sociales</p>
        </div>
    </div>

    <div class="text-center text-xs bg-blue-800 py-2">
        &copy; {{ date('Y') }} VeterinariaWeb. Todos los derechos reservados.
    </div>
</footer>
