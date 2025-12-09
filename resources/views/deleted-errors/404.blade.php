<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>404 – Page Not Found</title>
  <style>
    :root {
      --bg-dark: #0f0f0f;
      --text-light: #f2f2f2;
      --accent: #c88cff;
      --accent2: #16b4a4;
    }
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at 50% 40%, #1a1a1a, var(--bg-dark));
      color: var(--text-light);
      font-family: "Poppins", sans-serif;
      overflow: hidden;
    }
    h1 {
      font-size: 6rem;
      line-height: 1;
      background: linear-gradient(90deg, var(--accent), var(--accent2));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin: 0;
    }
    h2 {
      font-size: 1.6rem;
      margin: 10px 0 20px;
      color: #bdbdbd;
    }
    p {
      max-width: 480px;
      text-align: center;
      color: #aaa;
      line-height: 1.6;
      margin-bottom: 40px;
    }
    a {
      text-decoration: none;
      padding: 12px 28px;
      border-radius: 50px;
      background: linear-gradient(90deg, var(--accent), var(--accent2));
      color: #000;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: opacity 0.2s ease-in-out;
    }
    a:hover {
      opacity: 0.8;
    }
    .glow {
      position: absolute;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      filter: blur(180px);
      opacity: 0.3;
      background: var(--accent);
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: -1;
    }
  </style>
</head>
<body>
  <div class="glow"></div>
  <h1>404</h1>
  <h2>Page Not Found</h2>
  <p>Oops! The page you’re looking for doesn’t exist, was moved, or is temporarily unavailable.</p>
  <a href="/">Go Back Home</a>
</body>
</html>
