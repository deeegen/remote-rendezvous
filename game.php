<?php
function getGameAnalytics($universeId) {
    $url = "https://games.roblox.com/v1/games?universeIds=$universeId";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'RobloxGameAnalyticsTool/1.0');
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return null;

    $data = json_decode($response, true);
    return $data['data'][0] ?? null;
}

function getFavoritesCount($universeId) {
    $url = "https://games.roblox.com/v1/games/$universeId/favorites/count";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'RobloxGameAnalyticsTool/1.0');
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return null;

    $data = json_decode($response, true);
    return $data['favoritesCount'] ?? null;
}

function getLikesCount($universeId) {
    $url = "https://games.roblox.com/v1/games/$universeId/likes/count";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'RobloxGameAnalyticsTool/1.0');
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return null;

    $data = json_decode($response, true);
    return $data['likesCount'] ?? null;
}

$universeId = '7488195669';
$gameData = getGameAnalytics($universeId);
$favoritesCount = getFavoritesCount($universeId);
$likesCount = getLikesCount($universeId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Apartment 11</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --purple-1: #c084fc;
      --purple-2: #9333ea;
      --purple-3: #6b21a8;
      --gold: #fde047;
    }

    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(120deg, var(--purple-3), var(--purple-2), var(--purple-1));
      color: #f5eaff;
      overflow-x: hidden;
      scroll-behavior: smooth;
    }

    .background-flip-overlay {
      position: fixed;
      inset: 0;
      background: radial-gradient(circle at center, #9333ea55, #00000055);
      opacity: 0.3;
      z-index: -1;
      animation: gradientShift 15s ease infinite alternate;
    }

    .container {
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
      position: relative;
    }

    .back-button {
      position: fixed;
      top: 20px;
      left: 20px;
      padding: 12px 24px;
      font-size: 16px;
      font-weight: 600;
      color: #fff;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid var(--gold);
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .back-button:hover {
      background: var(--gold);
      color: var(--purple-3);
      transform: translateX(10px);
      box-shadow: 0 4px 20px rgba(253, 224, 71, 0.3);
    }

    .header {
      text-align: center;
      margin-bottom: 80px;
      position: relative;
    }

    .header h1 {
      font-size: 4.5rem;
      margin: 0;
      background: linear-gradient(45deg, #fff, var(--gold));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      letter-spacing: -2px;
      line-height: 1.1;
      text-shadow: 0 4px 20px rgba(147, 51, 234, 0.2);
      animation: float 3s ease-in-out infinite;
    }

    .header p {
      font-size: 1.4rem;
      max-width: 600px;
      margin: 20px auto 0;
      line-height: 1.6;
      opacity: 0.9;
      animation: fadeInUp 1s ease both;
    }

    .game-stats {
      text-align: center;
      margin-bottom: 40px;
      font-size: 1.1rem;
    }
    .game-stats p {
      margin: 6px 0;
    }

    .section {
      margin-bottom: 60px;
      padding: 40px;
      border-radius: 24px;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      transform: translateY(20px);
      opacity: 0;
      transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .section.visible {
      transform: translateY(0);
      opacity: 1;
    }

    .section h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      position: relative;
      padding-bottom: 10px;
      color: var(--gold);
    }

    .section h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--gold), transparent);
    }

    .section p {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #f5eaff;
      opacity: 0.9;
    }

    .feature-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }

    .feature-item {
      padding: 30px;
      border-radius: 16px;
      background: linear-gradient(145deg, rgba(107, 33, 168, 0.2), rgba(147, 51, 234, 0.1));
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .feature-item::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.05), transparent);
      transform: rotate(45deg);
      transition: all 0.6s ease;
    }

    .feature-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 32px rgba(107, 33, 168, 0.3);
    }

    .feature-item:hover::before {
      animation: shine 1.5s ease;
    }

    .feature-item h3 {
      margin-bottom: 15px;
      font-size: 1.5rem;
      color: var(--gold);
      position: relative;
      z-index: 1;
    }

    .feature-item p {
      font-size: 1rem;
      color: #e9d5ff;
      position: relative;
      z-index: 1;
    }

    .image-preview {
      text-align: center;
      margin: 60px 0;
      perspective: 1000px;
    }

    .image-preview img {
      max-width: 100%;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(107, 33, 168, 0.4);
      transform: rotateY(-5deg) rotateX(2deg);
      transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .image-preview:hover img {
      transform: rotateY(0) rotateX(0);
      box-shadow: 0 30px 60px rgba(107, 33, 168, 0.6);
    }

    .footer {
      text-align: center;
      padding: 40px 20px;
      font-size: 0.9em;
      color: #ddd;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin-top: 80px;
    }

    a.social-link {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      margin-top: 20px;
      padding: 16px 32px;
      background: linear-gradient(45deg, var(--purple-2), var(--purple-1));
      border-radius: 50px;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    a.social-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    a.social-link:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 24px rgba(147, 51, 234, 0.4);
    }

    a.social-link:hover::before {
      left: 100%;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    @keyframes shine {
      0% { left: -100%; }
      100% { left: 100%; }
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .header h1 { font-size: 3rem; }
      .section { padding: 30px; }
      .feature-list { grid-template-columns: 1fr; }
      .credits-list { grid-template-columns: 1fr; }
    }

    .section {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.6s ease;
    }

    .section.visible {
      opacity: 1;
      transform: translateY(0);
    }
    .play-button {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-top: 30px;
        padding: 20px 40px;
        background: linear-gradient(45deg, var(--purple-2), var(--gold));
        border-radius: 50px;
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.4rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
        box-shadow: 0 8px 24px rgba(147, 51, 234, 0.3);
    }

    .play-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.3), 
            transparent);
        transition: 0.5s;
    }

    .play-button:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(147, 51, 234, 0.5);
    }

    .play-button:hover::before {
        left: 100%;
    }

    .play-icon {
        width: 24px;
        height: 24px;
        fill: currentColor;
    }
    .image-carousel {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
        height: 500px;
        overflow: hidden;
    }

    .carousel-image {
        width: 100%;
        height: 100%;
        border-radius: 24px;
        object-fit: cover;
        opacity: 0;
        transition: opacity 0.5s ease;
        position: absolute;
        top: 0;
        left: 0;
    }

    .carousel-image.active {
        opacity: 1;
        position: relative;
    }

    .carousel-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        padding: 0 20px;
        z-index: 2;
        box-sizing: border-box;
    }

    .carousel-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid var(--gold);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .carousel-btn:hover {
        background: var(--gold);
        transform: scale(1.1);
        color: var(--purple-3);
    }

    .carousel-dots {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 2;
    }

    .carousel-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .carousel-dot.active {
        background: var(--gold);
        transform: scale(1.2);
    }

    /* Credits Styles */
    .credits-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }

    .credit-user {
      display: flex;
      align-items: center;
      gap: 15px;
      background: rgba(255, 255, 255, 0.08);
      padding: 20px;
      border-radius: 16px;
      text-decoration: none;
      color: #f5eaff;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.1);
      overflow: hidden;
    }

    .credit-user:hover {
      background: rgba(255, 255, 255, 0.15);
      border-color: var(--gold);
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(107, 33, 168, 0.25);
    }

    .credit-pfp {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--purple-1);
      flex-shrink: 0;
    }

    .credit-info {
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-width: 0;
    }

    .credit-display-name {
      font-weight: 600;
      font-size: 1.15rem;
      color: #fff;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .credit-username {
      font-size: 0.95rem;
      color: #e9d5ff;
      opacity: 0.85;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }


  </style>
</head>
<body>
  <div class="background-flip-overlay"></div>
  <button class="back-button" onclick="history.back()">← Back</button>

  <div class="container">
    <div class="header">
      <h1>Apartment 11</h1>
      <p>Where chill isn't just a mood — it's a lifestyle.</p>
      <button class="play-button" onclick="launchClient()">
        <svg class="play-icon" viewBox="0 0 24 24">
            <path d="M8 5v14l11-7z"/>
        </svg>
        Play Now
    </button>
    </div>

    <div class="game-stats">
      <?php if ($gameData): ?>
        <p><strong>Visits:</strong> <?php echo number_format($gameData['visits'] ?? 0); ?> <strong>Playing:</strong> <?php echo $gameData['playing'] ?? 0; ?></p>
      <?php else: ?>
        <p style="color: red;">Oopsies, unable to fetch game data.</p>
      <?php endif; ?>
    </div>

    <div class="section">
      <h2>What is Apartment 11?</h2>
      <p>
        Step into the glow of <strong>Apt. 11</strong> — a vibrant, toned world where time slows down and *you* finally matter. Whether you're catching up with friends, wandering through softly lit hangout zones, or just soaking in the relaxed vibes, this is your digital sanctuary. Are you really going to keep pretending you don't feel left out?
<br><br>

        You could spend another night bouncing between boring games or you could finally chill out and have some quality hangout time. Unlike noisy games full of chaos and pressure, Apt. 11 offers you peace, style, and a place where you can be <strong>whoever you want to be</strong>. And everyone’s already here… aren’t you just a little curious what you’re missing?<br><br>

        Purple skies, glowing rooms, cozy corners, and a quiet buzz of conversation — this isn't just a game. It's a mood. It's <em>your space</em>. The longer you stay, the harder it is to leave. So don’t. Come see what it’s like when a hangout game does everything right.
      </p>
    </div>

    <div class="section">
      <h2>Why You’ll Love It</h2>
      <div class="feature-list">
        <div class="feature-item">
          <h3>Chill Vibes</h3>
          <p>Gentle music. Shifting lights. You didn’t know you needed it until now.</p>
        </div>
        <div class="feature-item">
          <h3>Meet & Relax</h3>
          <p>Whether it's with friends or friendly strangers, every convo feels natural.</p>
        </div>
        <div class="feature-item">
          <h3>Escape Reality</h3>
          <p>When real life feels loud, this place feels like a breath you forgot to take.</p>
        </div>
        <div class="feature-item">
          <h3>It’s Always Changing</h3>
          <p>We add new rooms, new zones, and secret spots constantly.</p>
        </div>
      </div>
    </div>

    <div class="section image-preview">
    <h2>Game Preview</h2>
    <div class="image-carousel">
        <div class="carousel-controls">
            <button class="carousel-btn prev" aria-label="Previous image">←</button>
            <button class="carousel-btn next" aria-label="Next image">→</button>
        </div>
        <div class="carousel-dots"></div>
        <img src="https://cdn.glitch.global/5970b456-17e9-4f56-b0f2-46f0d4636862/New%20Project%20(17).png?v=1744327457626" class="carousel-image active" alt="Game preview 1">
        <img src="https://cdn.glitch.global/5970b456-17e9-4f56-b0f2-46f0d4636862/New%20Project%20(18).png?v=1744327826222" class="carousel-image" alt="Game preview 2">
        <img src="https://cdn.glitch.global/5970b456-17e9-4f56-b0f2-46f0d4636862/New%20Project%20(19).png?v=1744327866381" class="carousel-image" alt="Game preview 3">
    </div>
</div>


    <div class="section">
      <h2>How to Hang Out</h2>
      <p>
        The longer you think about it, the more you're missing. Go ahead — jump in! There’s no pressure, no competition — just you and your mood. Invite a friend or meet someone new. Lounge, vibe, or say nothing at all. It's your space, your pace.
      </p>
    </div>

    <div class="section">
      <h2>Join Our Community</h2>
      <p>
        Don’t just visit. Belong. Our Discord is where fans of APT. 11 come together to share their vibes, photos, custom looks, and spontaneous in-game hangouts.
      </p>
      <a class="social-link" href="127472540819385" target="_blank" rel="noopener noreferrer">Join Us on Discord</a>
    </div>

    <div class="section" id="credits">
      <h2>Credits</h2>
      <div class="credits-list">
        
        <a href="https://www.roblox.com/users/142989378/profile" target="_blank" rel="noopener noreferrer" class="credit-user">
          <img src="https://tr.rbxcdn.com/30DAY-AvatarHeadshot-68DD8556C839EE41D3DE74DC1637FEB4-Png/150/150/AvatarHeadshot/Webp/noFilter" class="credit-pfp">
          <div class="credit-info">
            <span class="credit-display-name">Jordan</span>
            <span class="credit-username">@epicepicsause</span>
          </div>
        </a>

        <a href="https://www.roblox.com/users/3217061857/profile" target="_blank" rel="noopener noreferrer" class="credit-user">
          <img src="https://tr.rbxcdn.com/30DAY-AvatarHeadshot-B65E5574E3EB6C134D00ABB9F989E67D-Png/150/150/AvatarHeadshot/Webp/noFilter" class="credit-pfp">
          <div class="credit-info">
            <span class="credit-display-name">TotoDev</span>
            <span class="credit-username">@TotoDevIsBack</span>
          </div>
        </a>
      </div>
      <p style="margin-top: 20px; text-align: right;">Game Updated: <?php echo isset($gameData['updated']) ? date('F j, Y g:i A', strtotime($gameData['updated'])) : 'N/A'; ?></p>
    </div>

    <div class="footer">
      &copy; 2025 Remote Rendezvous - All Rights Reserved.
    </div>
  </div>
  <script>
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.section').forEach((section) => {
      observer.observe(section);
    });
</script>
  <script>
function launchClient() {
        const clientUrl = 'roblox://placeID=128615894620559';
        
        // Try to launch the client
        window.location.href = clientUrl;
        
        // Fallback if protocol handler fails
        setTimeout(() => {
            // Redirect to game page on Roblox website if client doesn't launch
            window.location.href = 'https://www.roblox.com/games/12861589462/Apartment-11';
        }, 3000); // Reduced timeout for quicker fallback if needed
    }
</script>
  <script>
    const images = document.querySelectorAll('.carousel-image');
    const dotsContainer = document.querySelector('.carousel-dots');
    let currentIndex = 0;

    if (images.length > 0 && dotsContainer) {
        images.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add('carousel-dot');
            if(index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => {
              clearInterval(autoSlide);
              showImage(index);
              autoSlide = setInterval(() => showImage(currentIndex + 1), 5000);
            });
            dotsContainer.appendChild(dot);
        });

        function showImage(index) {
            const newIndex = (index + images.length) % images.length;

            images[currentIndex].classList.remove('active');
            if (dotsContainer.children[currentIndex]) {
              dotsContainer.children[currentIndex].classList.remove('active');
            }
            
            currentIndex = newIndex;
            
            images[currentIndex].classList.add('active');
             if (dotsContainer.children[currentIndex]) {
              dotsContainer.children[currentIndex].classList.add('active');
            }
        }

        const prevButton = document.querySelector('.prev');
        const nextButton = document.querySelector('.next');

        if (prevButton && nextButton) {
            prevButton.addEventListener('click', () => {
              clearInterval(autoSlide);
              showImage(currentIndex - 1);
              autoSlide = setInterval(() => showImage(currentIndex + 1), 5000);
            });
            nextButton.addEventListener('click', () => {
              clearInterval(autoSlide);
              showImage(currentIndex + 1);
              autoSlide = setInterval(() => showImage(currentIndex + 1), 5000);
            });
        }

        // Auto-advance every 3 seconds
        let autoSlide = setInterval(() => showImage(currentIndex + 1), 3000);

        // Pause on hover
        const carousel = document.querySelector('.image-carousel');
        if (carousel) {
            carousel.addEventListener('mouseenter', () => clearInterval(autoSlide));
            carousel.addEventListener('mouseleave', () => {
                autoSlide = setInterval(() => showImage(currentIndex + 1), 5000);
            });
        }
        
        showImage(0); 

    } else {
        console.log("Carousel elements not found or no images available.");
        const controls = document.querySelector('.carousel-controls');
        const dots = document.querySelector('.carousel-dots');
        if(controls) controls.style.display = 'none';
        if(dots) dots.style.display = 'none';
    }
</script>
</body>
</html>
