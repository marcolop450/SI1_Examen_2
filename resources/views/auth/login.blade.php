<x-guest-layout>
    <div class="login-header">
        <h2>Bienvenido</h2>
        <p>Ingresa tus credenciales para acceder al sistema</p>
    </div>

    <!-- Mensajes de estado -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Error:</strong> Credenciales incorrectas
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Usuario -->
        <div class="form-group">
            <label for="username" class="form-label">Usuario</label>
            <input 
                id="username" 
                class="form-input" 
                type="text" 
                name="username" 
                value="{{ old('username') }}" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Ingresa tu usuario">
            @error('username')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="form-group">
            <label for="password" class="form-label">Contraseña</label>
            <input 
                id="password" 
                class="form-input" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                placeholder="Ingresa tu contraseña">
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Recordarme y Olvidaste Contraseña -->
        <div class="form-checkbox" style="gap: 13rem;">
            <div class="checkbox-wrapper">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Recordarme</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password-link">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Botón de Login -->
        <button type="submit" class="btn-primary">
            Iniciar Sesión
        </button>
    </form>

    <!-- Sección de Registro -->
    @if (Route::has('register'))
        <div class="register-section">
            <p class="register-text">¿No tienes una cuenta?</p>
            <a href="{{ route('register') }}" class="register-link">
                Crear Cuenta Nueva
            </a>
        </div>
    @endif
</x-guest-layout>