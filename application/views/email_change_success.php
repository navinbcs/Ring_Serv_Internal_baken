<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ring Email Change Confirmation</title>
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
      color: #1b6ca8;
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .message {
      color: #333;
      font-size: 16px;
      margin-bottom: 20px;
    }

    .thank-you {
      background-color: #28a745;
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
    <!-- Replace with your logo -->
    <img src="https://apimobile.ring.healthcare/assets/logo/logo.png"> <span style="font-family:Avenir;font-size: 35px; font-weight: 500; font-style: normal; letter-spacing: normal; color: #fff; margin-top: 6px;
                            margin-left: 6px;"></span>
    <div class="title">Email Updated Successfully!</div>
    <div class="message">
      Great! Your email change request has been accepted, and we’ve successfully updated your email ID in our records.
    </div>

    <div style="color:green">Thank you for staying connected with us!</div>
  </div>

</body>
</html>