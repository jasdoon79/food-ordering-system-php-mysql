document.addEventListener("DOMContentLoaded", function() {
  // Get form elements
  const loginForm = document.getElementById("login-form");
  const signupForm = document.getElementById("signup-form");
  const errorMessage = document.getElementById("error-message");
  
  // Utility function to validate inputs
  function validateInput(input, errorMsg) {
    // Check if input is empty
    if (!input.value.trim()) {
      // Create error element if doesn't exist
      let errorElement = input.nextElementSibling;
      if (!errorElement || !errorElement.classList.contains('input-error')) {
        errorElement = document.createElement('div');
        errorElement.classList.add('input-error', 'error-message');
        input.parentNode.insertBefore(errorElement, input.nextSibling);
      }
      errorElement.textContent = errorMsg;
      input.classList.add('border-red-500');
      return false;
    } else {
      // Remove error if input is valid
      const errorElement = input.nextElementSibling;
      if (errorElement && errorElement.classList.contains('input-error')) {
        errorElement.remove();
      }
      input.classList.remove('border-red-500');
      return true;
    }
  }
  
  // Validate email format
  function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  
  // Validate username format (alphanumeric, underscore, 3-20 chars)
  function validateUsername(username) {
    const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
    return usernameRegex.test(username);
  }
  
  // Validate password strength
  function validatePassword(password) {
    // At least 8 characters, with at least one letter and one number
    return password.length >= 8 && /[a-zA-Z]/.test(password) && /[0-9]/.test(password);
  }
  
  // Clear all errors from a form
  function clearErrors(form) {
    const errorElements = form.querySelectorAll('.input-error');
    errorElements.forEach(el => el.remove());
    
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => input.classList.remove('border-red-500'));
    
    errorMessage.textContent = '';
    errorMessage.classList.add('hidden');
  }
  
  // Show form submission error
  function showFormError(message) {
    errorMessage.textContent = message;
    errorMessage.classList.remove('hidden');
  }
  
  // Handle login form submission
  loginForm.addEventListener("submit", function(e) {
    e.preventDefault();
    clearErrors(loginForm);
    
    const username = document.getElementById("login-username");
    const password = document.getElementById("login-password");
    
    // Validate inputs
    let isValid = true;
    
    isValid = validateInput(username, "Username is required") && isValid;
    isValid = validateInput(password, "Password is required") && isValid;
    
    if (isValid) {
      // Disable button to prevent multiple submissions
      const submitBtn = loginForm.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.classList.add('button-loading');
      submitBtn.textContent = "Processing...";
      
      // Get form data
      const formData = new FormData();
      formData.append('username', username.value);
      formData.append('password', password.value);
      formData.append('action', 'login');
      
      // Send AJAX request
      fetch('./functions/user_handler.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        // Check if response is ok before trying to parse JSON
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text().then(text => {
          try {
            return JSON.parse(text);
          } catch (e) {
            console.error('Error parsing JSON:', e, 'Response was:', text);
            throw new Error('Invalid JSON response from server');
          }
        });
      })
      .then(data => {
        if (data.success) {
          // Redirect on successful login
          window.location.href = data.redirect || 'index.php';
        } else {
          // Show error message
          showFormError(data.message || "Login failed. Please check your credentials.");
        }
      })
      .catch(error => {
        showFormError("An error occurred. Please try again later.");
        console.error('Error:', error);
      })
      .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.classList.remove('button-loading');
        submitBtn.textContent = "Login";
      });
    }
  });
  
  // Handle signup form submission
  signupForm.addEventListener("submit", function(e) {
    e.preventDefault();
    clearErrors(signupForm);
    
    const name = document.getElementById("signup-name");
    const username = document.getElementById("signup-username");
    const email = document.getElementById("signup-email");
    const password = document.getElementById("signup-password");
    
    // Validate inputs
    let isValid = true;
    
    isValid = validateInput(name, "Full name is required") && isValid;
    
    if (validateInput(username, "Username is required")) {
      if (!validateUsername(username.value)) {
        let errorElement = username.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('input-error')) {
          errorElement = document.createElement('div');
          errorElement.classList.add('input-error', 'error-message');
          username.parentNode.insertBefore(errorElement, username.nextSibling);
        }
        errorElement.textContent = "Username must be 3-20 characters and contain only letters, numbers, and underscores";
        username.classList.add('border-red-500');
        isValid = false;
      }
    } else {
      isValid = false;
    }
    
    if (validateInput(email, "Email is required")) {
      if (!validateEmail(email.value)) {
        let errorElement = email.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('input-error')) {
          errorElement = document.createElement('div');
          errorElement.classList.add('input-error', 'error-message');
          email.parentNode.insertBefore(errorElement, email.nextSibling);
        }
        errorElement.textContent = "Please enter a valid email address";
        email.classList.add('border-red-500');
        isValid = false;
      }
    } else {
      isValid = false;
    }
    
    if (validateInput(password, "Password is required")) {
      if (!validatePassword(password.value)) {
        let errorElement = password.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('input-error')) {
          errorElement = document.createElement('div');
          errorElement.classList.add('input-error', 'error-message');
          password.parentNode.insertBefore(errorElement, password.nextSibling);
        }
        errorElement.textContent = "Password must be at least 8 characters and include both letters and numbers";
        password.classList.add('border-red-500');
        isValid = false;
      }
    } else {
      isValid = false;
    }
    
    if (isValid) {
      // Disable button to prevent multiple submissions
      const submitBtn = signupForm.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.classList.add('button-loading');
      submitBtn.textContent = "Processing...";
      
      // Get form data
      const formData = new FormData();
      formData.append('name', name.value);
      formData.append('username', username.value);
      formData.append('email', email.value);
      formData.append('password', password.value);
      formData.append('action', 'signup');
      
      // Send AJAX request
      fetch('./functions/user_handler.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        // Check if response is ok before trying to parse JSON
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text().then(text => {
          try {
            return JSON.parse(text);
          } catch (e) {
            console.error('Error parsing JSON:', e, 'Response was:', text);
            throw new Error('Invalid JSON response from server');
          }
        });
      })
      .then(data => {
        if (data.success) {
          // Show success message and redirect
          showFormError(data.message || "Registration successful! You can now login.");
          errorMessage.style.color = "#16a34a"; // Green color for success
          
          // Reset form
          signupForm.reset();
          
          // Switch to login tab after a delay
          setTimeout(() => {
            document.getElementById("show-login").click();
          }, 2000);
        } else {
          // Show error message
          showFormError(data.message || "Registration failed. Please try again.");
        }
      })
      .catch(error => {
        showFormError("An error occurred. Please try again later.");
        console.error('Error:', error);
      })
      .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitBtn.classList.remove('button-loading');
        submitBtn.textContent = "Sign Up";
      });
    }
  });
});