<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Teste Montink - Login</title>
	<link rel="canonical" href="https://montink.com/">
	<meta property="og:locale" content="pt_BR">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Teste Montink">
	<meta property="og:description" content="Teste Montink">
	<meta property="og:url" content="https://montink.com/">
	<meta property="og:site_name" content="Teste Montink">
	<meta property="article:modified_time" content="2022-09-14T18:28:19+00:00">
	<meta property="og:image" content="https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-192x192.png">
	<meta property="og:image:width" content="192">
	<meta property="og:image:height" content="192">
	<meta property="og:image:type" content="image/png">
	<meta property="description" content="Teste Montink">
    
    @verbatim
	<script type="application/ld+json" class="yoast-schema-graph">
		{
			"@context": "https://schema.org",
			"@graph": [{
				"@type": "WebPage",
				"@id": "https://montink.com/",
				"url": "https://montink.com/",
				"name": "Teste Montink",
				"thumbnailUrl": "https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-192x192.png",
				"datePublished": "2022-10-06T17:30:35+00:00",
				"dateModified": "2022-10-06T13:44:31+00:00",
				"description": "Teste Montink",
				"inLanguage": "pt-BR"
			}]
		}
	</script>
    @endverbatim

	<!-- / Yoast SEO plugin. -->
	<link rel="dns-prefetch" href="//s.w.org">
	<link rel="alternate" type="application/rss+xml" title="Teste Montink" href="https://montink.com/">

	<link rel="shortlink" href="https://montink.com/">

	<link rel="icon" href="https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-192x192.png" sizes="192x192">
	<link rel="apple-touch-icon" href="https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-192x192.png">
	<meta name="msapplication-TileImage" content="https://sou.montink.com/wp-content/uploads/2021/09/cropped-Design-sem-nome-1-192x192.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

	<link rel="stylesheet" href="/styles/bootstrap.min.css">

	<script type="module" src="https://kit.fontawesome.com/11551bd62e.js" crossorigin="anonymous"></script>
	<script src="/scripts/jquery.min.js"></script>
    
    @verbatim
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 500px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }
        
        .login-header {
            background: rgba(0, 0, 0, 0.7);
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M40,100c0-33,33-50,60-50s60,17,60,50s-33,50-60,50S40,133,40,100z" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="4"/></svg>');
            opacity: 0.2;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            color: white;
            margin-bottom: 10px;
        }
        
        .logo-icon {
            font-size: 3.5rem;
            color: #ff8c00;
        }
        
        .logo-text {
            font-weight: 700;
            font-size: 2.5rem;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .tagline {
            color: rgba(255, 255, 255, 0.85);
            font-style: italic;
            font-size: 1.1rem;
        }
        
        .login-body {
            background-color: white;
            padding: 40px 30px;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
        }
        
        .input-group-text {
            background: #e9ecef;
            border: none;
            color: #333;
        }
        
        .form-control {
            border: none;
            border-left: 1px solid #ced4da !important;
            padding: 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(106, 17, 203, 0.4);
        }
        
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: all 0.5s;
        }
        
        .btn-primary:hover::after {
            left: 100%;
        }
                
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-container {
                margin: 20px;
            }
            
            .login-header {
                padding: 20px 15px;
            }
            
            .logo-text {
                font-size: 2rem;
            }
            
            .logo-icon {
                font-size: 2.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .login-body {
                padding: 30px 20px;
            }
            
            .logo {
                flex-direction: column;
                gap: 5px;
            }
            
            .logo-text {
                font-size: 1.8rem;
            }
        }
    </style>
    @endverbatim

</head>
<body>
    <div class="container my-auto">
        <div class="login-container">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-tshirt logo-icon"></i>
                    <span class="logo-text">Teste Montink</span>
                </div>
                <div class="tagline">Teste desafio PHP - Montink</div>
            </div>
            
            <div class="login-body">
                <form method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Digite seu e-mail" required>
                        </div>
                        @error("email")
                        <div class="text-danger">E-mail ou senha inválidos.</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Senha</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Digite sua senha" required>
                        </div>
                        @error("password")
                        <div class="text-danger">Senha inválida.</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </button>
                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
</body>
</html>