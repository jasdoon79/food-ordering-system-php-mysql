// Add a console log to check if event listeners are duplicating
console.log("auth.js loaded");

// Utility: Show error below a field
function showError(input, message) {
  const errorEl = input.parentElement.querySelector(".error-message");
  if (errorEl) {
    errorEl.innerText = message;
  } else {
    const msg = document.createElement("p");
    msg.className = "error-message text-sm text-red-500 mt-1";
    msg.innerText = message;
    input.parentElement.appendChild(msg);
  }
}

// Utility: Clear error message
function clearError(input) {
  const errorEl = input.parentElement.querySelector(".error-message");
  if (errorEl) errorEl.remove();
}

// Attach real-time error clearing
document.querySelectorAll("input").forEach((input) => {
  input.addEventListener("input", () => clearError(input));
});

// Validate email format
function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Initialize tabs with active styling
document.addEventListener("DOMContentLoaded", function() {
  // Add active-tab class to login by default
  document.getElementById("show-login").classList.add("active-tab");
  
  // IMPORTANT: Make sure inline script isn't also setting up the form handlers
  console.log("Initializing form handlers from auth.js");
});

// === FIXED LOGIN FORM HANDLER ===
document.getElementById("login-form").addEventListener("submit", function(e) {
  e.preventDefault(); // Explicitly prevent default form submission
  console.log("Login form submitted via JavaScript handler");

  const username = document.getElementById("login-username");
  const password = document.getElementById("login-password");

  let valid = true;

  if (username.value.trim() === "") {
    showError(username, "Username is required");
    valid = false;
  }

  if (password.value.trim() === "") {
    showError(password, "Password is required");
    valid = false;
  }

  if (!valid) return;

  // Add loading indicator
  const submitBtn = e.target.querySelector('button[type="submit"]');
  const originalBtnText = submitBtn.innerText;
  submitBtn.innerText = "Logging in...";
  submitBtn.disabled = true;

  // Debug log current URL to understand environment
  console.log("Current URL:", window.location.href);
  
  // UPDATED: First try with absolute path from root 
  // If this doesn't work, we'll handle it in the catch block
  const handlerUrl = '/user_handler.php';
  
  console.log(`Sending POST request to: ${handlerUrl}`);
  
  fetch(handlerUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `action=login&username=${encodeURIComponent(username.value)}&password=${encodeURIComponent(password.value)}`
  })
  .then(response => {
    console.log("Response received:", response.status);
    // Check if the response is valid JSON first
    const contentType = response.headers.get('content-type');
    console.log("Response content type:", contentType);
    
    if (contentType && contentType.includes('application/json')) {
      return response.json();
    } else {
      // Not JSON - log the raw response and throw error
      return response.text().then(text => {
        console.error("Non-JSON response:", text);
        throw new Error("Server didn't return JSON");
      });
    }
  })
  .then(data => {
    // Reset button state
    submitBtn.innerText = originalBtnText;
    submitBtn.disabled = false;
    
    console.log("Login response:", data);
    
    if (data.status === 'success') {
      // Store user in localStorage for frontend persistence
      localStorage.setItem("loginUser", JSON.stringify([{
        name: data.user.name,
        username: data.user.username
      }]));
      
      // Show success message and redirect
      alert(data.message);
      window.location.href = "./index.php";
    } else {
      // Show error on the appropriate field or general error
      if (data.field === 'username') {
        showError(username, data.message);
      } else if (data.field === 'password') {
        showError(password, data.message);
      } else {
        showError(password, data.message);
      }
    }
  })
  .catch(error => {
    console.error('Login error:', error);
    submitBtn.innerText = originalBtnText;
    submitBtn.disabled = false;
    
    // If first attempt failed with absolute path, try with relative path
    if (handlerUrl === '/user_handler.php') {
      console.log("Retrying with relative path...");
      const relativeHandlerUrl = 'user_handler.php';
      
      fetch(relativeHandlerUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=login&username=${encodeURIComponent(username.value)}&password=${encodeURIComponent(password.value)}`
      })
      .then(response => {
        console.log("Relative path response received:", response.status);
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('application/json')) {
          return response.json();
        } else {
          return response.text().then(text => {
            console.error("Non-JSON response from relative path:", text);
            throw new Error("Server didn't return JSON");
          });
        }
      })
      .then(data => {
        if (data.status === 'success') {
          localStorage.setItem("loginUser", JSON.stringify([{
            name: data.user.name,
            username: data.user.username
          }]));
          alert(data.message);
          window.location.href = "./index.php";
        } else {
          if (data.field === 'username') {
            showError(username, data.message);
          } else if (data.field === 'password') {
            showError(password, data.message);
          } else {
            showError(password, data.message);
          }
        }
      })
      .catch(innerError => {
        console.error('Error with relative path:', innerError);
        alert('Login failed. Please check the server configuration.');
      });
    } else {
      alert('Login failed. Please try again.');
    }
  });
});

// === FIXED SIGNUP FORM HANDLER ===
document.getElementById("signup-form").addEventListener("submit", (e) => {
  e.preventDefault();
  console.log("Signup form submitted via JavaScript handler");

  const name = document.getElementById("signup-name");
  const username = document.getElementById("signup-username");
  const email = document.getElementById("signup-email");
  const password = document.getElementById("signup-password");

  let valid = true;

  if (name.value.trim() === "") {
    showError(name, "Name is required");
    valid = false;
  }

  if (username.value.trim() === "") {
    showError(username, "Username is required");
    valid = false;
  }

  if (email.value.trim() === "") {
    showError(email, "Email is required");
    valid = false;
  } else if (!isValidEmail(email.value.trim())) {
    showError(email, "Invalid email format");
    valid = false;
  }

  if (password.value.trim() === "") {
    showError(password, "Password is required");
    valid = false;
  } else if (password.value.length < 6) {
    showError(password, "Password must be at least 6 characters");
    valid = false;
  }

  if (!valid) return;

  // Add loading indicator
  const submitBtn = e.target.querySelector('button[type="submit"]');
  const originalBtnText = submitBtn.innerText;
  submitBtn.innerText = "Signing up...";
  submitBtn.disabled = true;

  // Try first with absolute path
  const handlerUrl = '/user_handler.php';
  console.log(`Sending signup POST request to: ${handlerUrl}`);

  fetch(handlerUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `action=register&name=${encodeURIComponent(name.value)}&username=${encodeURIComponent(username.value)}&email=${encodeURIComponent(email.value)}&password=${encodeURIComponent(password.value)}`
  })
  .then(response => {
    console.log("Signup response received:", response.status);
    const contentType = response.headers.get('content-type');
    
    if (contentType && contentType.includes('application/json')) {
      return response.json();
    } else {
      return response.text().then(text => {
        console.error("Non-JSON signup response:", text);
        throw new Error("Server didn't return JSON");
      });
    }
  })
  .then(data => {
    // Reset button state
    submitBtn.innerText = originalBtnText;
    submitBtn.disabled = false;
    
    if (data.status === 'success') {
      // Clear form and show success message
      alert(data.message);
      e.target.reset();
      
      // Switch to login tab
      document.getElementById("show-login").click();
    } else {
      // Show specific field error or general error
      if (data.field === 'username') {
        showError(username, data.message);
      } else if (data.field === 'email') {
        showError(email, data.message);
      } else {
        showError(username, data.message);
      }
    }
  })
  .catch(error => {
    console.error('Signup error:', error);
    submitBtn.innerText = originalBtnText;
    submitBtn.disabled = false;
    
    // If first attempt failed, try with relative path
    if (handlerUrl === '/user_handler.php') {
      console.log("Retrying signup with relative path...");
      const relativeHandlerUrl = 'user_handler.php';
      
      fetch(relativeHandlerUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=register&name=${encodeURIComponent(name.value)}&username=${encodeURIComponent(username.value)}&email=${encodeURIComponent(email.value)}&password=${encodeURIComponent(password.value)}`
      })
      .then(response => {
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('application/json')) {
          return response.json();
        } else {
          return response.text().then(text => {
            console.error("Non-JSON response from relative path:", text);
            throw new Error("Server didn't return JSON");
          });
        }
      })
      .then(data => {
        if (data.status === 'success') {
          alert(data.message);
          e.target.reset();
          document.getElementById("show-login").click();
        } else {
          if (data.field === 'username') {
            showError(username, data.message);
          } else if (data.field === 'email') {
            showError(email, data.message);
          } else {
            showError(username, data.message);
          }
        }
      })
      .catch(innerError => {
        console.error('Error with relative signup path:', innerError);
        alert('Signup failed. Please check the server configuration.');
      });
    } else {
      alert('Signup failed. Please try again.');
    }
  });
});

// IMPROVED: Check session status when page loads with better error handling
window.addEventListener('load', function() {
  console.log("Checking login status on page load");
  
  // Try first with absolute path
  const handlerUrl = '/user_handler.php';
  
  fetch(handlerUrl, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'action=check_login'
  })
  .then(response => {
    const contentType = response.headers.get('content-type');
    console.log("Login check content type:", contentType);
    
    if (contentType && contentType.includes('application/json')) {
      return response.json();
    } else {
      return response.text().then(text => {
        console.error("Non-JSON login check response:", text);
        throw new Error("Server didn't return JSON");
      });
    }
  })
  .then(data => {
    console.log("Login status check:", data);
    if (data.status === 'success' && data.logged_in) {
      // If user is logged in through PHP session, ensure our localStorage is in sync
      localStorage.setItem("loginUser", JSON.stringify([{
        name: data.user.name,
        username: data.user.username
      }]));
      
      // Redirect to index if already logged in
      console.log("User is logged in, redirecting to index");
      window.location.href = "./index.php";
    }
  })
  .catch(error => {
    console.error('Error checking login status:', error);
    
    // If first attempt failed, try with relative path
    console.log("Retrying login check with relative path...");
    const relativeHandlerUrl = 'user_handler.php';
    
    fetch(relativeHandlerUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'action=check_login'
    })
    .then(response => {
      const contentType = response.headers.get('content-type');
      
      if (contentType && contentType.includes('application/json')) {
        return response.json();
      } else {
        return response.text().then(text => {
          console.log("Non-JSON login check response from relative path:", text.substring(0, 100) + "...");
          throw new Error("Server didn't return JSON");
        });
      }
    })
    .then(data => {
      console.log("Login status check (relative path):", data);
      if (data.status === 'success' && data.logged_in) {
        localStorage.setItem("loginUser", JSON.stringify([{
          name: data.user.name,
          username: data.user.username
        }]));
        console.log("User is logged in, redirecting to index");
        window.location.href = "./index.php";
      }
    })
    .catch(innerError => {
      console.error('Error with relative login check path:', innerError);
      // Don't alert here as it's a background check
    });
  });
});