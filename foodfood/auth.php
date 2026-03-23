<?php
ini_set('session.use_only_cookies', 1);
session_name("UserSession");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login / Signup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .form-container {
      max-width: 400px;
    }
    .active-tab {
      border-bottom: 2px solid #f97316;
      color: #f97316;
    }
    .error-message {
      color: #dc2626;
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    .button-loading {
      opacity: 0.7;
      cursor: not-allowed;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

  <div class="bg-white shadow-lg rounded-lg p-8 form-container w-full">
    <div class="flex justify-between mb-6">
      <button id="show-login" class="text-lg font-semibold text-gray-700 border-b-2 border-transparent hover:text-orange-500">Login</button>
      <button id="show-signup" class="text-lg font-semibold text-gray-700 border-b-2 border-transparent hover:text-orange-500">Sign Up</button>
    </div>

    <form id="login-form" class="space-y-4">
      <div>
        <label for="login-username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="login-username" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
      </div>
      <div>
        <label for="login-password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="login-password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
      </div>
      <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Login</button>
    </form>

    <form id="signup-form" class="space-y-4 hidden">
      <div>
        <label for="signup-name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" id="signup-name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
      </div>
      <div>
        <label for="signup-username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="signup-username" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
      </div>
      <div>
        <label for="signup-email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="signup-email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
      </div>
      <div>
        <label for="signup-password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="signup-password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
      </div>
      <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Sign Up</button>
    </form>
    
    <div id="debug-info" class="mt-4 p-2 border border-gray-300 rounded text-xs hidden">
      <div>Current path: <span id="debug-path"></span></div>
      <div>Full URL: <span id="debug-url"></span></div>
      <button id="show-debug" class="mt-2 px-2 py-1 bg-gray-200 rounded text-xs">Show Details</button>
      <div id="debug-details" class="mt-2 hidden"></div>
    </div>
    <div id="error-message" class="error-message"></div>
  </div>

  <script>
    // This code runs first - handles tab switching
    document.addEventListener("DOMContentLoaded", function() {
      const loginBtn = document.getElementById("show-login");
      const signupBtn = document.getElementById("show-signup");
      const loginForm = document.getElementById("login-form");
      const signupForm = document.getElementById("signup-form");

      // Setup debugging tools (only for development)
      const isDebug = window.location.search.includes('debug=true');
      if (isDebug) {
        document.getElementById("debug-info").classList.remove("hidden");
        document.getElementById("debug-path").textContent = window.location.pathname;
        document.getElementById("debug-url").textContent = window.location.href;
        
        document.getElementById("show-debug").addEventListener("click", function() {
          const details = document.getElementById("debug-details");
          details.classList.toggle("hidden");
          
          if (!details.classList.contains("hidden")) {
            details.innerHTML = `
              <div>Protocol: ${window.location.protocol}</div>
              <div>Host: ${window.location.host}</div>
              <div>Origin: ${window.location.origin}</div>
              <div>Document Dir: ${document.documentURI}</div>
            `;
          }
        });
      }

      loginBtn.addEventListener("click", () => {
        loginForm.classList.remove("hidden");
        signupForm.classList.add("hidden");
        loginBtn.classList.add("active-tab");
        signupBtn.classList.remove("active-tab");
      });

      signupBtn.addEventListener("click", () => {
        signupForm.classList.remove("hidden");
        loginForm.classList.add("hidden");
        signupBtn.classList.add("active-tab");
        loginBtn.classList.remove("active-tab");
      });
      
      // Default to login tab active
      loginBtn.click();
      
    });
  </script>
  
  <script src="./Design/js/auth.js"></script>
</body>
</html>

