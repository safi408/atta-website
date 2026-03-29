<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Barakah Atta | 100% Gluten-Free Multigrain Flour</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fefaf5;
            overflow-x: hidden;
        }

        :root {
            --brand-green: #2b6e3c;
            --brand-gold: #c9a03d;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Top Scroll Progress Bar */
        .scroll-progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(203, 160, 61, 0.2);
            z-index: 1050;
        }
        
        .scroll-progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #c9a03d, #2b6e3c, #f5b042);
            border-radius: 0 4px 4px 0;
            transition: width 0.08s linear;
        }

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1040;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
            text-decoration: none;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 15px 30px rgba(37, 211, 102, 0.4);
        }
        
        .whatsapp-float i {
            font-size: 2.5rem;
            color: white;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.5);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        
        /* WhatsApp Tooltip */
        .whatsapp-tooltip {
            position: absolute;
            right: 75px;
            background: #1e2a1c;
            color: white;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .whatsapp-tooltip::after {
            content: '';
            position: absolute;
            right: -8px;
            top: 50%;
            transform: translateY(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent transparent #1e2a1c;
        }
        
        .whatsapp-float:hover .whatsapp-tooltip {
            opacity: 1;
            visibility: visible;
            right: 85px;
        }
        
        @media (max-width: 768px) {
            .whatsapp-float {
                width: 55px;
                height: 55px;
                bottom: 20px;
                right: 20px;
            }
            .whatsapp-float i {
                font-size: 2rem;
            }
            .whatsapp-tooltip {
                display: none;
            }
        }

        .navbar-modern {
            background: rgba(255, 255, 245, 0.96);
            backdrop-filter: blur(8px);
            padding: 0.8rem 0;
            margin-top: 4px;
        }

        body {
            padding-top: 76px;
        }
        
        @media (max-width: 768px) {
            body {
                padding-top: 68px;
            }
        }

        /* Logo Styling */
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .logo-img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }
        
        .logo-img:hover {
            transform: scale(1.05);
        }
        
        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2b6e3c 0%, #c9a03d 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            background: linear-gradient(135deg, #c9a03d 0%, #2b6e3c 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        @media (max-width: 768px) {
            .logo-img {
                width: 35px;
                height: 35px;
            }
            .logo-text {
                font-size: 1.3rem;
            }
        }

        .nav-link {
            font-weight: 500;
            color: #2d3e2b !important;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: #2b6e3c !important;
            transform: translateY(-2px);
        }

        .btn-success-custom {
            background: linear-gradient(105deg, #2b6e3c, #1f8a3e);
            border: none;
            border-radius: 40px;
            padding: 10px 28px;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(43, 110, 60, 0.25);
            transition: all 0.3s ease;
            color: white;
        }

        .btn-success-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(43, 110, 60, 0.35);
        }

        .hero-section {
            padding: 2rem 0 4rem 0;
            background: linear-gradient(120deg, #fffaf2 0%, #fef5e9 100%);
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 3.3rem;
            line-height: 1.2;
            color: #1f2e1c;
            animation: fadeSlideUp 0.8s ease-out;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 500;
            color: #5b6e47;
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .floating-img {
            animation: floatSoft 4s ease-in-out infinite;
            filter: drop-shadow(0 20px 18px rgba(0,0,0,0.1));
            border-radius: 32px;
        }

        @keyframes floatSoft {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        /* ========== TIMELINE SECTION WITH SMOOTH ANIMATIONS ========== */
        .timeline-section {
            background: linear-gradient(135deg, #fef9f0 0%, #fffaf5 100%);
            padding: 80px 0;
            position: relative;
        }

        .timeline-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .timeline-header h2 {
            font-size: 2.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #2b6e3c, #c9a03d);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Timeline Container */
        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Center Line */
        .timeline::after {
            content: '';
            position: absolute;
            width: 4px;
            background: linear-gradient(180deg, #c9a03d, #2b6e3c, #c9a03d);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2px;
            border-radius: 4px;
            box-shadow: 0 0 8px rgba(43, 110, 60, 0.3);
        }

        /* Timeline Items */
        .timeline-item {
            padding: 10px 40px;
            position: relative;
            width: 50%;
            opacity: 0;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Left side animation - from left */
        .timeline-left {
            left: 0;
            transform: translateX(-60px);
        }

        /* Right side animation - from right */
        .timeline-right {
            left: 50%;
            transform: translateX(60px);
        }

        /* When visible - both come to center */
        .timeline-item.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Circle on Line */
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            right: -12px;
            background: white;
            border: 4px solid #2b6e3c;
            top: 30px;
            border-radius: 50%;
            z-index: 10;
            transition: all 0.3s ease;
            box-shadow: 0 0 0 4px rgba(43, 110, 60, 0.2);
        }

        .timeline-right::after {
            left: -12px;
            right: auto;
        }

        .timeline-item.visible::after {
            background: #c9a03d;
            border-color: #c9a03d;
            box-shadow: 0 0 0 4px rgba(201, 160, 61, 0.3);
        }

        .timeline-item:hover::after {
            transform: scale(1.2);
        }

        /* Content Cards */
        .timeline-content {
            padding: 28px 30px;
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            border: 1px solid rgba(203, 183, 137, 0.3);
        }

        .timeline-content:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 45px -15px rgba(43, 110, 60, 0.2);
            border-color: #c9e0b2;
        }

        .timeline-icon {
            font-size: 3.2rem;
            margin-bottom: 15px;
            display: inline-block;
        }

        .timeline-content h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2b6e3c;
            margin-bottom: 12px;
        }

        .timeline-content p {
            color: #5a6452;
            line-height: 1.6;
            font-size: 1rem;
        }

        .timeline-badge {
            display: inline-block;
            background: #eef5e6;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #2b6e3c;
            margin-bottom: 12px;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .timeline::after {
                left: 31px;
            }
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            .timeline-right {
                left: 0%;
            }
            .timeline-left {
                transform: translateX(-40px);
            }
            .timeline-right {
                transform: translateX(-40px);
            }
            .timeline-item.visible {
                transform: translateX(0);
            }
            .timeline-item::after {
                left: 19px;
                right: auto;
            }
            .timeline-header h2 {
                font-size: 2rem;
            }
        }

        /* Other Sections */
        .feature-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-list li i {
            color: #2b6e3c;
            font-size: 1.5rem;
            background: #eef5e6;
            padding: 6px;
            border-radius: 50%;
        }

        .review-card {
            background: white;
            border-radius: 1.8rem;
            padding: 1.5rem;
            transition: all 0.3s;
            border: 1px solid #f0e5d6;
        }

        .review-card:hover {
            transform: translateY(-6px);
        }

        .stars {
            color: #f5b342;
        }

        .form-modern {
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .form-control-custom {
            border-radius: 60px;
            padding: 12px 20px;
            border: 1.5px solid #ece3d8;
        }

        .form-control-custom:focus {
            border-color: #2b6e3c;
            box-shadow: 0 0 0 4px rgba(43, 110, 60, 0.2);
        }

        .footer-modern {
            background: #1e2a1c;
            border-top: 5px solid #c9a03d;
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s ease;
        }

        .reveal-on-scroll.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .nav-link.active {
            color: #2b6e3c !important;
            font-weight: 700;
            border-bottom: 2px solid #c9a03d;
        }

        .badge-cert {
            background: #e7f0e2;
            color: #1f5430;
            border-radius: 50px;
            padding: 0.3rem 1rem;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.3rem;
            }
        }
    </style>
</head>
<body>

<!-- Top Scroll Progress Bar -->
<div class="scroll-progress-container">
    <div class="scroll-progress-bar" id="scrollProgressBar"></div>
</div>

<!-- WhatsApp Floating Button with your number -->
<a href="https://wa.me/923704587980?text=Assalamu%20Alaikum!%20I%20want%20to%20order%20Barakah%20Atta%20(100%25%20Gluten-Free%20Multigrain%20Flour)" 
   class="whatsapp-float" 
   target="_blank"
   rel="noopener noreferrer">
    <i class="bi bi-whatsapp"></i>
    <span class="whatsapp-tooltip">Order on WhatsApp</span>
</a>

<!-- Navbar with Logo Image -->
<nav class="navbar navbar-expand-lg navbar-modern fixed-top">
    <div class="container">
        <a class="navbar-logo" href="#">
            <img src="https://placehold.co/200x200/2b6e3c/white?text=B" 
                 alt="Barakah Atta Logo" 
                 class="logo-img"
                 onerror="this.src='https://via.placeholder.com/45x45/2b6e3c/white?text=B'">
            <span class="logo-text">Barakah<span> Atta</span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline-benefits">Benefits</a></li>
                <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
                <li class="nav-item">
                    <a class="btn btn-success-custom ms-lg-2" href="#order">Order Now <i class="bi bi-cart-check"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-1 order-2">
                <span class="badge-cert mb-3 d-inline-block"><i class="bi bi-check-circle-fill"></i> 100% Natural & Organic</span>
                <h1 class="hero-title">
                    100% Gluten-Free <br>
                    <span style="color: #2b6e3c; border-bottom: 3px solid #c9a03d;">Multigrain Atta</span>
                </h1>
                <p class="hero-subtitle mt-3"><i class="bi bi-flower1"></i> Soft Roti, Healthy Life — Crafted for Wellness</p>
                <p class="mt-2 text-secondary">Perfect for Celiac, gluten sensitivity, and health-conscious families. Wholesome grains, no compromises.</p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="#order" class="btn btn-success-custom btn-lg px-5 py-3">📦 Order Now </a>
                    <a href="#timeline-benefits" class="btn btn-outline-success btn-lg px-4 py-3" style="border-radius: 40px;">✨ Explore Benefits</a>
                </div>
                <div class="mt-4 d-flex gap-4">
                    <div><i class="bi bi-truck text-success"></i> <span class="fw-semibold">Free Delivery</span> <span class="text-muted">on orders 2kg+</span></div>
                    <div><i class="bi bi-shield-check text-success"></i> <span class="fw-semibold">Certified Gluten-Free</span></div>
                </div>
            </div>
            <div class="col-lg-6 order-lg-2 order-1 text-center">
                <img src="https://images.pexels.com/photos/6207474/pexels-photo-6207474.jpeg?auto=compress&cs=tinysrgb&w=600&h=600&fit=crop" 
                     class="img-fluid floating-img" 
                     style="max-width: 90%; border-radius: 48px;"
                     alt="Premium Multigrain Atta">
            </div>
        </div>
    </div>
</section>

<!-- TIMELINE BENEFITS SECTION WITH LEFT/RIGHT ANIMATIONS -->
<section id="timeline-benefits" class="timeline-section">
    <div class="container">
        <div class="timeline-header reveal-on-scroll">
            <h2>✨ Premium Benefits ✨</h2>
            <p class="fs-5 text-muted">Discover why Barakah Atta is the choice of health-conscious families</p>
        </div>
        
        <div class="timeline">
            <!-- Benefit 1 - Left -->
            <div class="timeline-item timeline-left">
                <div class="timeline-content">
                    <div class="timeline-icon">🌾</div>
                    <span class="timeline-badge">✨ Premium Quality</span>
                    <h3>100% Gluten Free</h3>
                    <p>Lab-tested and certified gluten-free flour, safe for celiac disease and gluten intolerance. No cross-contamination guaranteed.</p>
                    <div class="mt-2"><i class="bi bi-check-circle-fill text-success"></i> Certified by international standards</div>
                </div>
            </div>
            
            <!-- Benefit 2 - Right -->
            <div class="timeline-item timeline-right">
                <div class="timeline-content">
                    <div class="timeline-icon">💧</div>
                    <span class="timeline-badge">🌟 Gut Friendly</span>
                    <h3>Easy to Digest</h3>
                    <p>Light on stomach with zero bloating. Perfect for all age groups including elderly and children.</p>
                    <div class="mt-2"><i class="bi bi-emoji-smile text-success"></i> 98% customers report better digestion</div>
                </div>
            </div>
            
            <!-- Benefit 3 - Left -->
            <div class="timeline-item timeline-left">
                <div class="timeline-content">
                    <div class="timeline-icon">🌿</div>
                    <span class="timeline-badge">💪 Health Boost</span>
                    <h3>High in Fiber</h3>
                    <p>Rich in dietary fiber from multigrains like jowar, ragi, and amaranth. Supports gut health and sustained energy.</p>
                    <div class="mt-2"><i class="bi bi-graph-up text-success"></i> 40% more fiber than regular flour</div>
                </div>
            </div>
            
            <!-- Benefit 4 - Right -->
            <div class="timeline-item timeline-right">
                <div class="timeline-content">
                    <div class="timeline-icon">🍞</div>
                    <span class="timeline-badge">👨‍🍳 Perfect Texture</span>
                    <h3>Perfect for Roti & Paratha</h3>
                    <p>Specially crafted blend that gives soft, flexible rotis that stay fresh for hours. No cracking or hardness.</p>
                    <div class="mt-2"><i class="bi bi-star-fill text-warning"></i> "Softest gluten-free roti ever!"</div>
                </div>
            </div>
            
            <!-- Benefit 5 - Left -->
            <div class="timeline-item timeline-left">
                <div class="timeline-content">
                    <div class="timeline-icon">🌱</div>
                    <span class="timeline-badge">🌍 Pure & Natural</span>
                    <h3>No Preservatives • No Chemicals</h3>
                    <p>Made with traditional stone-milling technique preserving all nutrients. No additives, no artificial colors.</p>
                    <div class="mt-2"><i class="bi bi-flower1 text-success"></i> Sourced from organic local farms</div>
                </div>
            </div>
            
            <!-- Benefit 6 - Right -->
            <div class="timeline-item timeline-right">
                <div class="timeline-content">
                    <div class="timeline-icon">❤️</div>
                    <span class="timeline-badge">🩺 Health First</span>
                    <h3>Diabetic Friendly</h3>
                    <p>Low glycemic index blend helps maintain stable blood sugar levels. Ideal for diabetic individuals.</p>
                    <div class="mt-2"><i class="bi bi-heart-pulse text-success"></i> Recommended by nutritionists</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Barakah Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-md-6 reveal-on-scroll">
                <h2 class="fw-bold" style="font-size: 2.2rem;">Why <span class="text-success">Barakah Atta</span> stands out?</h2>
                <ul class="feature-list mt-4 list-unstyled">
                    <li><i class="bi bi-check-lg"></i> <strong>Hygienically Processed</strong> – state-of-the-art facility</li>
                    <li><i class="bi bi-flask"></i> <strong>No Preservatives & No Chemicals</strong> – pure ancient grains</li>
                    <li><i class="bi bi-heart-pulse"></i> <strong>Ideal for Gluten Sensitivity & Diabetic friendly</strong></li>
                    <li><i class="bi bi-tree"></i> <strong>Sourced from local organic farms</strong></li>
                    <li><i class="bi bi-star-fill text-warning"></i> <strong>Soft Roti Guarantee</strong> – stays soft for hours</li>
                </ul>
                <div class="mt-4">
                    <a href="#order" class="btn btn-success-custom">Get Your Pack Today →</a>
                </div>
            </div>
            <div class="col-md-6 text-center reveal-on-scroll">
                <img src="https://images.pexels.com/photos/5709216/pexels-photo-5709216.jpeg?auto=compress&cs=tinysrgb&w=600&h=450&fit=crop" 
                     class="img-fluid" style="border-radius: 40px; box-shadow: 0 25px 35px -15px rgba(0,0,0,0.2); width: 100%;"
                     alt="Organic grains selection">
            </div>
        </div>
    </div>
</section>

<!-- Order + Reviews Section -->
<section id="order" class="py-5" style="background: linear-gradient(145deg, #faf7f0 0%, #fef9ef 100%);">
    <div class="container">
        <div class="text-center mb-5 reveal-on-scroll">
            <h2 class="fw-bold display-6">📦 Place Your <span class="text-success">Order Now!</span></h2>
            <p class="fs-5 text-secondary">Cash on Delivery available all across Pakistan.</p>
            <p class="text-muted">Or <strong>Order via WhatsApp</strong> by clicking the green button on bottom right</p>
        </div>
        <div class="row g-5">
            <div class="col-md-6 reveal-on-scroll">
                <div class="form-modern">
                    <h4 class="fw-bold mb-3"><i class="bi bi-envelope-paper"></i> Quick Order Form</h4>
                    <form onsubmit="alert('✅ Thank you! Your order has been placed. Our representative will call you shortly for confirmation.'); return false;">
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-custom" placeholder="Full Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="tel" class="form-control form-control-custom" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-custom" placeholder="Complete Address" required>
                        </div>
                        <div class="mb-4">
                            <select class="form-select form-control-custom" required>
                                <option value="" disabled selected>Select Quantity</option>
                                <option>1 KG - ₨ 450</option>
                                <option>2 KG - ₨ 850 (Save ₨ 50)</option>
                                <option>5 KG Family Pack - ₨ 2000 (Best Value)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success-custom w-100 py-3 fw-bold">
                            <i class="bi bi-cart-fill"></i> Place Order
                        </button>
                    </form>
                    {{-- <div class="text-center mt-3">
                        <p class="text-muted small">or</p>
                        <a href="https://wa.me/923704587980?text=Assalamu%20Alaikum!%20I%20want%20to%20order%20Barakah%20Atta" 
                           class="btn btn-outline-success w-100 py-2" 
                           target="_blank"
                           style="border-radius: 40px;">
                            <i class="bi bi-whatsapp"></i> Order via WhatsApp
                        </a>
                    </div> --}}
                </div>
            </div>
            <div class="col-md-6" id="reviews">
                <div class="reveal-on-scroll">
                    <div class="review-card mb-4">
                        <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="mt-2 fst-italic">"Finally a gluten-free atta that actually makes soft roti! My whole family loves it."</p>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle" width="40" height="40">
                            <strong>— Ayesha Khan</strong> <span class="text-muted">Lahore</span>
                        </div>
                    </div>
                    <div class="review-card mb-4">
                        <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p class="mt-2 fst-italic">"Excellent flour for roti & parathas. My husband has celiac disease, this is a lifesaver!"</p>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <img src="https://randomuser.me/api/portraits/women/45.jpg" class="rounded-circle" width="40" height="40">
                            <strong>— Fatima Rizvi</strong> <span class="text-muted">Karachi</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <i class="bi bi-chat-quote-fill text-success"></i> <span class="fw-semibold">4.9/5 based on 1200+ happy customers</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Badge -->
<section class="py-4" style="background: #eef3e6;">
    <div class="container text-center">
        <h4 class="fw-bold">🌟 100% Satisfaction Guaranteed 🌟</h4>
        <p>If you don't love the taste and softness, we'll refund your first order. No questions asked.</p>
        <a href="#order" class="btn btn-outline-success btn-lg rounded-pill px-5">Order Now →</a>
    </div>
</section>

<!-- Footer -->
<footer class="footer-modern text-white py-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h4 class="fw-bold"><span class="text-warning">Barakah</span> Atta</h4>
                <p class="text-white-50">Pure, gluten-free multigrain flour made with love and tradition.</p>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <p><i class="bi bi-telephone-fill"></i> 0370 4587980<br>
                <i class="bi bi-whatsapp"></i> 0370 4587980<br>
                <i class="bi bi-envelope"></i> hello@barakahatta.pk</p>
            </div>
            <div class="col-md-4">
                <h5>Follow Us</h5>
                <div class="d-flex gap-3 fs-4">
                    <a href="#" class="text-white-50"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-instagram"></i></a>
                    <a href="https://wa.me/923704587980" target="_blank" class="text-white-50"><i class="bi bi-whatsapp"></i></a>
                </div>
                <p class="mt-3 small">Made in Pakistan | Cash on Delivery</p>
            </div>
        </div>
        <hr class="mt-4">
        <div class="text-center text-white-50 small">© 2025 Barakah Atta — 100% Gluten-Free Multigrain</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    (function() {
        // Top Scroll Progress Bar
        const topProgressBar = document.getElementById('scrollProgressBar');
        function updateTopProgress() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / scrollHeight) * 100;
            if (topProgressBar) topProgressBar.style.width = scrollPercent + '%';
        }
        window.addEventListener('scroll', updateTopProgress);
        window.addEventListener('resize', updateTopProgress);
        updateTopProgress();
        
        // Timeline Items Animation
        const timelineItems = document.querySelectorAll('.timeline-item');
        
        function checkTimelineVisibility() {
            const windowHeight = window.innerHeight;
            
            timelineItems.forEach(item => {
                const rect = item.getBoundingClientRect();
                const itemTop = rect.top;
                const itemBottom = rect.bottom;
                
                if (itemTop < windowHeight - 80 && itemBottom > 80) {
                    item.classList.add('visible');
                }
            });
        }
        
        checkTimelineVisibility();
        
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    checkTimelineVisibility();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        window.addEventListener('resize', checkTimelineVisibility);
        
        // Regular scroll reveal for other sections
        const revealElements = document.querySelectorAll('.reveal-on-scroll');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        
        revealElements.forEach(el => observer.observe(el));
        
        // Navbar active state
        const sections = document.querySelectorAll('section, #home');
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 130;
                const sectionBottom = sectionTop + section.offsetHeight;
                if (pageYOffset >= sectionTop && pageYOffset < sectionBottom) {
                    current = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                } else if (current === null && link.getAttribute('href') === '#home') {
                    link.classList.add('active');
                }
            });
        });
    })();
</script>

<style>
    .btn-outline-success {
        border-color: #2b6e3c;
        color: #2b6e3c;
    }
    .btn-outline-success:hover {
        background: #2b6e3c;
        color: white;
    }
    .img-fluid {
        max-width: 100%;
        height: auto;
    }
    
    .timeline-item {
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .timeline-content {
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    
    .timeline-item::after {
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
</style>
</body>
</html>