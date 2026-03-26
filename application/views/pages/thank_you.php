<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thank You</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
      text-align: center;
      padding: 20px;
    }

    .thank-you-container {
      background: white;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 100%;
    }

    .thank-you-container h1 {
      font-size: 2.5rem;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    .thank-you-container p {
      font-size: 1.1rem;
      color: #555;
      margin-bottom: 30px;
    }

    .thank-you-container a {
      display: inline-block;
      padding: 12px 25px;
      background-color: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }

    .thank-you-container a:hover {
      background-color: #2980b9;
    }

    @media (max-width: 600px) {
      .thank-you-container h1 {
        font-size: 2rem;
      }

      .thank-you-container p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="thank-you-container">
    <h1>Thank You!</h1>
    <p>Your session has been expired. We appreciate your feedback.</p>
    <a href="">Back to Home</a>
  </div>
</body>
</html>
