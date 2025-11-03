<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CondoImage – Elevating Real Estate with Visual Excellence</title>
	<meta name="description" content="Ideal for real estate professionals, and marketers seeking premium imagery of condominiums, apartment buildings, and residential communities worldwide ">

  <style>
    body {
      margin: 0;
      padding: 20px;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f4f8f9;
      color: #000;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      min-height: 100vh;
    }
    h1 {
      font-size: 3rem;
      margin-bottom: 0.5rem;
    }
    h2 {
      font-size: 1.25rem;
      font-style: italic;
    }
    .form-section {
      width: 100%;
      max-width: 400px;
      margin-top: 30px;
    }
    input[type="text"] {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    button {
      width: 100%;
      padding: 12px;
      font-size: 1rem;
      background-color: #000;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    .error {
      color: red;
      margin-top: 10px;
    }
    footer {
      margin-top: auto;
      font-size: 0.9rem;
      color: #888;
      text-align: center;
      padding: 20px 0;
    }
  </style>
</head>
<body>
  <h1><span style="color: #52a5bf"><strong>CONDO</strong></span><strong>IMAGE</strong></h1>
  <p>High-quality visual media of condominiums, apartment buildings, and residential communities worldwide</p>

  <div class="form-section">
    <h2>Access by Invitation Only</h2>
    <p>Enter your invite code to continue:</p>
    <input type="text" id="inviteCode" placeholder="Invitation Code" />
    <button onclick="checkCode()">Enter</button>
    <div class="error" id="errorMsg"></div>
  </div>

  <footer>
    &copy; 2025 CondoImage.com
  </footer>

  <script>
    function checkCode() {
      const input = document.getElementById("inviteCode").value.trim().toLowerCase();
      const correctCodeBase64 = "Z2FiYXRpbmk=";
      const redirectUrlBase64 = "aHR0cHM6Ly9jb25kb2ltYWdlLmNvbS9zdGFnaW5nLw=="; 


      if (btoa(input) === correctCodeBase64) {
        window.location.href = atob(redirectUrlBase64);
      } else {
        document.getElementById("errorMsg").textContent = "Invalid code. Please try again.";
      }
    }
  </script>
</body>
</html>
