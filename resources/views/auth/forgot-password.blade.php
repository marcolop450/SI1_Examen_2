<x-guest-layout>
    <div class="login-header">
        <h2>¿Olvidaste tu contraseña?</h2>
        <p>Te enviaremos un enlace para restablecerla</p>
    </div>

    <!-- Mensaje informativo -->
    <div class="alert alert-info">
        <p style="font-size: 0.9rem;">
            Ingresa tu correo electrónico y te enviaremos un enlace para que puedas crear una nueva contraseña.
        </p>
    </div>

    <!-- Estado de sesión -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Correo -->
        <div class="form-group">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input 
                id="correo" 
                class="form-input" 
                type="email" 
                name="correo" 
                value="{{ old('correo') }}" 
                required 
                autofocus
                placeholder="tu-correo@ejemplo.com">
            @error('correo')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botones -->
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">
                Enviar Enlace de Recuperación
            </button>
        </div>

        <div style="text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <a href="{{ route('login') }}" class="link-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al inicio de sesión
            </a>
        </div>
    </form>
</x-guest-layout>