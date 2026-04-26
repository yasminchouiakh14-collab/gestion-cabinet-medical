<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cabinet Médical — Portail</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --surface-bg: #F8FAFC;
            --surface-card: #FFFFFF;
            --brand-navy: #0F172A;
            --brand-teal: #0D9488;
            --brand-teal-light: #CCFBF1;
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --border-light: #E2E8F0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface-bg);
            color: var(--text-primary);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Split Screen Container */
        .split-layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }

        .split-left {
            flex: 1;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: var(--surface-bg);
            position: relative;
        }

        .split-right {
            flex: 1;
            background: var(--brand-navy);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Abstract Graphic on Right Side */
        .abstract-graphic {
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle at 10% 20%, rgba(13, 148, 136, 0.15) 0%, transparent 40%),
                        radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 40%);
            z-index: 1;
        }

        .brand-message {
            position: relative;
            z-index: 2;
            color: white;
            max-width: 400px;
            padding: 3rem;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand-message h2 {
            font-size: 2.5rem;
            font-weight: 300;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .brand-message h2 span {
            font-weight: 600;
            color: var(--brand-teal);
        }

        .left-header {
            margin-bottom: 4rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-mark {
            width: 38px;
            height: 38px;
            background: var(--brand-navy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -1px;
            border-radius: 8px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--brand-navy);
            letter-spacing: -0.01em;
        }

        .intro-text h1 {
            font-size: 2.75rem;
            font-weight: 600;
            letter-spacing: -0.03em;
            color: var(--brand-navy);
            margin-bottom: 1rem;
        }

        .intro-text p {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 450px;
            line-height: 1.6;
            margin-bottom: 3rem;
        }

        /* Action Cards */
        .portal-grid {
            display: grid;
            gap: 1.5rem;
            max-width: 500px;
        }

        .portal-link {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            background: var(--surface-card);
            border: 1px solid var(--border-light);
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .portal-link:hover {
            border-color: var(--brand-teal);
            box-shadow: 0 10px 30px -10px rgba(13, 148, 136, 0.15);
            transform: translateY(-2px);
        }

        .portal-icon {
            width: 48px;
            height: 48px;
            background: var(--surface-bg);
            color: var(--brand-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 1.25rem;
            margin-right: 1.5rem;
            transition: all 0.2s ease;
        }

        .portal-link:hover .portal-icon {
            background: var(--brand-teal-light);
            color: var(--brand-teal);
        }

        .portal-content {
            flex: 1;
        }

        .portal-content h3 {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .portal-content p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.5;
        }

        .portal-arrow {
            margin-left: auto;
            color: var(--border-light);
            transition: all 0.2s ease;
            font-size: 1.2rem;
        }

        .portal-link:hover .portal-arrow {
            color: var(--brand-teal);
            transform: translateX(4px);
        }

        @media (max-width: 992px) {
            .split-layout { flex-direction: column; }
            .split-right { display: none; }
            .split-left { padding: 2rem; align-items: center; text-align: center; }
            .intro-text p { margin-left: auto; margin-right: auto; }
            .left-header { justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="split-layout">
        
        <!-- Left Side: Interactive Area -->
        <div class="split-left">
            <div style="max-width: 500px; margin: 0 auto; width: 100%;">
                
                <div class="left-header">
                    <div class="logo-mark">C</div>
                    <span class="logo-text">Cabinet Médical</span>
                </div>

                <div class="intro-text">
                    <h1>Accès au Portail</h1>
                    <p>Veuillez sélectionner l'espace correspondant à votre profil pour accéder à vos services et données sécurisées.</p>
                </div>

                <div class="portal-grid">
                    <!-- Patient -->
                    <a href="{{ route('login', ['type' => 'patient']) }}" class="portal-link">
                        <div class="portal-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="portal-content text-start">
                            <h3>Espace Patient</h3>
                            <p>Prendre un rendez-vous ou accéder à votre dossier.</p>
                        </div>
                        <i class="bi bi-arrow-right portal-arrow"></i>
                    </a>

                    <!-- Admin -->
                    <a href="{{ route('login', ['type' => 'admin']) }}" class="portal-link">
                        <div class="portal-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="portal-content text-start">
                            <h3>Espace Professionnel</h3>
                            <p>Gestion médicale et administration du cabinet.</p>
                        </div>
                        <i class="bi bi-arrow-right portal-arrow"></i>
                    </a>
                </div>

            </div>
        </div>

        <!-- Right Side: Branded Visual -->
        <div class="split-right">
            <div class="abstract-graphic"></div>
            <div class="brand-message">
                <h2>Excellence<br><span>médicale</span>,<br>gestion simplifiée.</h2>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
