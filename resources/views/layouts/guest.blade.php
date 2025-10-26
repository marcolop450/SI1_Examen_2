<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema Académico FICCT') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-left {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 300px;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        .login-logo {
            width: 150px;
            height: 150px;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: brightness(1.5);
            display: block;
        }

        .login-logo svg {
            width: 100%;
            height: 100%;
        }

        .login-left h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .login-left p {
            font-size: 1rem;
            text-align: center;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .login-right {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-size: 1.75rem;
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
        }

        .form-checkbox input {
            width: 1.125rem;
            height: 1.125rem;
            margin-right: 0.5rem;
            cursor: pointer;
            accent-color: #3b82f6;
        }

        .form-checkbox label {
            color: #6b7280;
            font-size: 0.95rem;
            cursor: pointer;
            user-select: none;
        }

        .forgot-password-link {
            color: #3b82f6;
            font-size: 0.875rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .register-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .register-text {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
        }

        .register-link {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: white;
            color: #3b82f6;
            border: 2px solid #3b82f6;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .register-link:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .alert-error {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .alert-info {
            background-color: #dbeafe;
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }

        .link-primary {
            color: #3b82f6;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }

        .link-primary:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 0;
                align-items: stretch;
            }

            .login-container {
                grid-template-columns: 1fr;
                border-radius: 0;
                min-height: 100vh;
            }

            .login-left {
                padding: 2rem 1.5rem;
                min-height: auto;
            }

            .login-logo {
                width: 120px;
                height: 120px;
                margin-bottom: 1.5rem;
            }

            .login-left h1 {
                font-size: 1.25rem;
                line-height: 1.4;
            }

            .login-left p {
                font-size: 0.875rem;
                line-height: 1.4;
            }

            .login-right {
                padding: 2rem 1.5rem;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }

            .login-header p {
                font-size: 0.875rem;
            }

            .form-checkbox {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .login-logo {
                width: 100px;
                height: 100px;
            }

            .login-left h1 {
                font-size: 1.125rem;
            }

            .login-left p {
                font-size: 0.8rem;
            }

            .login-right {
                padding: 1.5rem 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Lado Izquierdo - Branding -->
        <div class="login-left">
            <div class="login-logo">
                <img src="{{ asset('images/logo-ficct.png') }}" alt="Logo FICCT" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                
                <svg style="display: none;" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="100" cy="100" r="80" fill="rgba(255,255,255,0.2)" stroke="white" stroke-width="3"/>
                    <text x="100" y="125" font-size="90" font-weight="bold" fill="white" text-anchor="middle">F</text>
                </svg>
            </div>
            <h1>Sistema de Gestión de Horarios</h1>
            <p>Facultad de Ingeniería en Ciencias de la Computación y Telecomunicaciones</p>
        </div>

        <!-- Lado Derecho - Contenido Dinámico -->
        <div class="login-right">
            {{ $slot }}
        </div>
    </div>
</body>
</html>