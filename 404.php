<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - PhiCCS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #112203;
            --secondary-color: #788851;
            --accent-color: #9EB23B;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--primary-color);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .background-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 80% 20%, rgba(158, 178, 59, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(158, 178, 59, 0.1) 0%, transparent 40%);
            z-index: -1;
        }
        
        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 700px;
            z-index: 1;
        }
        
        .error-code {
            font-size: 10rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            text-shadow: 0 5px 30px rgba(158, 178, 59, 0.3);
        }
        
        .error-message {
            font-size: 2rem;
            margin-bottom: 2rem;
            font-weight: 600;
        }
        
        .error-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.8;
        }
        
        .home-btn {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            border: none;
            font-size: 1.1rem;
        }
        
        .home-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            color: white;
        }
        
        .logo-container {
            margin-bottom: 1rem;
        }
        
        .logo-container img {
            width: 150px;
            height: auto;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }
            
            .error-message {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="background-pattern"></div>
    
    <div class="error-container">
        <div class="logo-container">
            <img src="/PhiCCSV1/assets/images/OfficialLogoVer2.png" alt="PhiCCS Logo">
        </div>
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Page Not Found</h2>
        <p class="error-description">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="/PhiCCSV1" class="home-btn">
            <i class="fas fa-home me-2"></i>Go to Homepage
        </a>
    </div>
</body>
</html> 