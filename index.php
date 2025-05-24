<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoreVault - Competition Scoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --gradient-start: #2c3e50;
            --gradient-end: #3498db;
        }
        
        body {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            min-height: 100vh;
            color: white;
        }
        
        .hero-section {
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .floating-circles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            opacity: 0.1;
        }
        
        .circle {
            position: absolute;
            border-radius: 50%;
            background: white;
            animation: float 8s infinite ease-in-out;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.1); }
        }
        
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .card-body {
            color: white;
        }
        
        .btn-glow {
            background: var(--secondary-color);
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .btn-glow::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }
        
        .stats-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 3rem;
        }
        
        .stat-item {
            text-align: center;
            animation: fadeInUp 1s ease;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="floating-circles">
            <div class="circle" style="width: 50px; height: 50px; left: 10%; top: 20%;"></div>
            <div class="circle" style="width: 30px; height: 30px; left: 25%; top: 60%;"></div>
            <div class="circle" style="width: 70px; height: 70px; left: 60%; top: 30%;"></div>
            <div class="circle" style="width: 40px; height: 40px; left: 80%; top: 70%;"></div>
        </div>
        
        <div class="container position-relative">
            <div class="row justify-content-center text-center">
                <div class="col-md-8 animate__animated animate__fadeIn">
                    <h1 class="display-3 mb-4 fw-bold">Welcome to ScoreVault</h1>
                    <p class="lead mb-5">Experience real-time competition scoring with advanced tracking and instant updates</p>
                    
                    <div class="row g-4 py-4">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <div class="card h-100">
                                <div class="card-body">
                                    <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <h5 class="card-title">Live Scoreboard</h5>
                                    <p class="card-text">Watch competition scores update in real-time with dynamic rankings and visual highlights for top performers</p>
                                    <a href="scoreboard/index.php" class="btn btn-glow">View Scores</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <div class="card h-100">
                                <div class="card-body">
                                    <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M12 15l-2 5l9-9l-9-9l2 5l-7 4l7 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <h5 class="card-title">Judge Portal</h5>
                                    <p class="card-text">Efficiently manage and submit participant scores with our intuitive judging interface</p>
                                    <a href="judge/index.php" class="btn btn-glow">Enter Portal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-section animate__animated animate__fadeInUp">
                        <div class="row">
                            <div class="col-md-4 stat-item">
                                <div class="stat-number">100%</div>
                                <div class="stat-label">Real-time Updates</div>
                            </div>
                            <div class="col-md-4 stat-item">
                                <div class="stat-number">10s</div>
                                <div class="stat-label">Refresh Rate</div>
                            </div>
                            <div class="col-md-4 stat-item">
                                <div class="stat-number">1-100</div>
                                <div class="stat-label">Score Range</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Animate floating circles randomly
    document.querySelectorAll('.circle').forEach(circle => {
        circle.style.animationDelay = `${Math.random() * 2}s`;
    });
    </script>
</body>
</html>