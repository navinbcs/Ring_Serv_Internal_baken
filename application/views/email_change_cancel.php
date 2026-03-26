<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ring Email Change Cancelled</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: rgba(0, 0, 0, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .popup-container {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      max-width: 400px;
      width: 90%;
      text-align: center;
      padding: 30px 20px;
      position: relative;
    }

    .logo {
      width: 80px;
      height: auto;
      margin-bottom: 15px;
    }

    .title {
      color: #dc3545;
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .message {
      color: #333;
      font-size: 16px;
      margin-bottom: 20px;
    }

    .cancel-info {
      background-color: #dc3545;
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      font-size: 15px;
      margin-bottom: 10px;
      display: inline-block;
    }

    .button {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 15px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <div class="popup-container">
    <!-- Logo -->
    <img src="https://apimobile.ring.healthcare/assets/logo/logo.png" class="logo">
    
    <div class="title">Email Change Request Cancelled</div>
    
    <div class="message">
      Your request to change the email address has been <strong>cancelled</strong> and no changes were made to your account.
    </div>

    <div class="cancel-info">If this was not you, please contact support immediately.</div>
  </div>

</body>
</html>