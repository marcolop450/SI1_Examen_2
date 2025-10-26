<x-guest-layout>
    <div class="login-header">
        <h2>Crear Cuenta</h2>
        <p>Regístrate para acceder al sistema</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div class="form-group">
            <label for="nombre" class="form-label">Nombre</label>
            <input 
                id="nombre" 
                class="form-input" 
                type="text" 
                name="nombre" 
                value="{{ old('nombre') }}" 
                required 
                autofocus 
                autocomplete="given-name"
                placeholder="Juan">
            @error('nombre')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Apellido -->
        <div class="form-group">
            <label for="apellido" class="form-label">Apellido</label>
            <input 
                id="apellido" 
                class="form-input" 
                type="text" 
                name="apellido" 
                value="{{ old('apellido') }}" 
                required 
                autocomplete="family-name"
                placeholder="Pérez">
            @error('apellido')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- CI -->
        <div class="form-group">
            <label for="ci" class="form-label">Cédula de Identidad</label>
            <input 
                id="ci" 
                class="form-input" 
                type="number" 
                name="ci" 
                value="{{ old('ci') }}" 
                required 
                placeholder="12345678">
            @error('ci')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Usuario -->
        <div class="form-group">
            <label for="username" class="form-label">Nombre de Usuario</label>
            <input 
                id="username" 
                class="form-input" 
                type="text" 
                name="username" 
                value="{{ old('username') }}" 
                required 
                autocomplete="username"
                placeholder="juan.perez">
            @error('username')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

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
                autocomplete="username"
                placeholder="tu-correo@ejemplo.com">
            @error('correo')
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
                autocomplete="new-password"
                placeholder="••••••••">
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input 
                id="password_confirmation" 
                class="form-input" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="••••••••">
            @error('password_confirmation')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón y Link -->
        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn-primary">
                Registrarse
            </button>
        </div>

        <div style="text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 0.95rem;">
                ¿Ya tienes cuenta? 
                <a href="{{ route('login') }}" class="link-primary">
                    Iniciar Sesión
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>