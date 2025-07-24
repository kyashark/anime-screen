document.addEventListener("DOMContentLoaded", function () {
  
  
    // LOGIN VALIDATION

  const loginForm = document.getElementById("login-form");
  if (loginForm) {
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const usernameError = document.getElementById("username-error");
    const passwordError = document.getElementById("password-error");
    const credentialsError = document.getElementById("credentials-error");

    username.addEventListener("focus", () => (usernameError.textContent = ""));
    password.addEventListener("focus", () => (passwordError.textContent = ""));

    username.addEventListener("blur", function () {
      if (username.value.trim() === "") {
        usernameError.textContent = "Username is required.";
      }
    });

    password.addEventListener("blur", function () {
      if (password.value.trim() === "") {
        passwordError.textContent = "Password is required.";
      }
    });

    loginForm.addEventListener("submit", function (e) {
      let isValid = true;
      credentialsError.textContent = "";

      if (username.value.trim() === "") {
        usernameError.textContent = "Username is required.";
        isValid = false;
      }

      if (password.value.trim() === "") {
        passwordError.textContent = "Password is required.";
        isValid = false;
      }

      if (!isValid) {
        e.preventDefault();
      }
    });
  }

  
  // REGISTER VALIDATION

  const registerForm = document.getElementById("register-form");
  if (registerForm) {
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");

    const usernameError = document.getElementById("username-error");
    const emailError = document.getElementById("email-error");
    const passwordError = document.getElementById("password-error");
    const confirmPasswordError = document.getElementById(
      "confirm-password-error"
    );

    function validateUsername() {
      if (username.value.trim() === "") {
        usernameError.textContent = "Username is required";
        return false;
      } else if (username.value.trim().length < 3) {
        usernameError.textContent = "Username must be at least 3 characters.";
        return false;
      }
      return true;
    }

    function validateEmail() {
      if (email.value.trim() === "") {
        emailError.textContent = "Email is required";
        return false;
      }
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email.value.trim())) {
        emailError.textContent = "Invalid email format";
        return false;
      }
      return true;
    }

    function validatePassword() {
      const value = password.value.trim();
      if (value === "") {
        passwordError.textContent = "Password is required";
        return false;
      } else if (value.length < 8) {
        passwordError.textContent = "Password must be at least 8 characters";
        return false;
      } else if (!/[A-Z]/.test(value)) {
        passwordError.textContent = "Include at least one uppercase letter";
        return false;
      } else if (!/[a-z]/.test(value)) {
        passwordError.textContent = "Include at least one lowercase letter";
        return false;
      } else if (!/[0-9]/.test(value)) {
        passwordError.textContent = "Include at least one number";
        return false;
      } else if (!/[!@#$%^&*(),.?\":{}|<>]/.test(value)) {
        passwordError.textContent = "Include at least one special character";
        return false;
      }
      return true;
    }

    function validateConfirmPassword() {
      if (confirmPassword.value.trim() === "") {
        confirmPasswordError.textContent = "Confirm password is required";
        return false;
      } else if (confirmPassword.value !== password.value) {
        confirmPasswordError.textContent = "Passwords do not match";
        return false;
      }
      return true;
    }

    [username, email, password, confirmPassword].forEach((input) => {
      input.addEventListener("focus", () => {
        document.getElementById(`${input.id}-error`).textContent = "";
      });
    });

    username.addEventListener("blur", validateUsername);
    email.addEventListener("blur", validateEmail);
    password.addEventListener("blur", validatePassword);
    confirmPassword.addEventListener("blur", validateConfirmPassword);

    registerForm.addEventListener("submit", function (e) {
      let isValid =
        validateUsername() &
        validateEmail() &
        validatePassword() &
        validateConfirmPassword();

      if (!isValid) {
        e.preventDefault();
      }
    });
  }


  // AUTO HIDE ERRORS

  const errorMessages = document.querySelectorAll(".error-msg");
  errorMessages.forEach(function (errorMsg) {
    if (errorMsg.textContent.trim() !== "") {
      setTimeout(function () {
        errorMsg.classList.add("fade-out");
        setTimeout(function () {
          errorMsg.textContent = "";
          errorMsg.classList.remove("fade-out");
        }, 500);
      }, 5000);
    }
  });
});
