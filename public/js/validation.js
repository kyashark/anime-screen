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


  // MOVIE FORM VALIDATIONS
  const movieForm = document.getElementById("movie-form");
    if (movieForm) {
      const movieName = document.getElementById("movie-name");
      const movieType = document.getElementById("movie-type");
      const releaseDate = document.getElementById("release-date");
      const movieDetails = document.getElementById("movie-details");
      const imageCover = document.getElementById("image-cover");
      const author = document.getElementById("author");
      const bgImage = document.getElementById("image-background");

      const movieNameError = document.getElementById("movie-name-error");
      const movieTypeError = document.getElementById("movie-type-error");
      const releaseDateError = document.getElementById("release-date-error");
      const movieDetailsError = document.getElementById("movie-details-error");
      const imageError = document.getElementById("image-error");
      const authorError = document.getElementById("author-error");
      const bgImageError = document.getElementById("bg-image-error");

      function wordCount(text) {
        return text.trim().split(/\s+/).filter(Boolean).length;
      }

      function validateMovieName() {
        if (movieName.value.trim() === "") {
          movieNameError.textContent = "Movie name is required";
          return false;
        }
        movieNameError.textContent = "";
        return true;
      }

      function validateAuthor() {
        if (author.value.trim() === "") {
          authorError.textContent = "Author name is required";
          return false;
        }
        authorError.textContent = "";
        return true;
      }

      function validateMovieType() {
        if (movieType.value === "") {
          movieTypeError.textContent = "Movie type is required";
          return false;
        }
        movieTypeError.textContent = "";
        return true;
      }

      function validateReleaseDate() {
        const dateVal = releaseDate.value;
        if (dateVal === "") {
          releaseDateError.textContent = "Release date is required";
          return false;
        } else if (!/^\d{4}-\d{2}-\d{2}$/.test(dateVal)) {
          releaseDateError.textContent = "Invalid date format (YYYY-MM-DD).";
          return false;
        }
        releaseDateError.textContent = "";
        return true;
      }

      function validateMovieDetails() {
        const words = wordCount(movieDetails.value);
        if (movieDetails.value.trim() === "") {
          movieDetailsError.textContent = "Movie description is required";
          return false;
        } else if (words > 100) {
          movieDetailsError.textContent = `Description must not exceed 100 words. (${words} words entered)`;
          return false;
        }
        movieDetailsError.textContent = "";
        return true;
      }
    
      
      function validateImageCover() {
          // If updating (movie_id exists), don't require image
          const isUpdate = !!document.querySelector('input[name="movie_id"]');
          if (isUpdate && imageCover.files.length === 0) {
            // Optional on update: no error if no new file uploaded
            imageError.textContent = "";
            return true;
          }

          if (imageCover.files.length === 0) {
            imageError.textContent = "Image upload is required";
            return false;
          }

          const file = imageCover.files[0];
          const allowedTypes = ["image/jpeg", "image/png"];
          if (!allowedTypes.includes(file.type)) {
            imageError.textContent = "Only JPG and PNG images are allowed";
            return false;
          } else if (file.size > 2 * 1024 * 1024) {
            imageError.textContent = "Image size must be less than 2MB";
            return false;
          }

          imageError.textContent = "";
          return true;
        }


        function validateBgImage() {
          // If updating (movie_id exists), don't require image
          const isUpdate = !!document.querySelector('input[name="movie_id"]');
          if (isUpdate && bgImage.files.length === 0) {
            // Optional on update: no error if no new file uploaded
            bgImageError.textContent = "";
            return true;
          }

          if (bgImage.files.length === 0) {
            bgImageError.textContent = "Background image is required";
            return false;
          }

          const file = bgImage.files[0];
          const allowedTypes = ["image/jpeg", "image/png"];
          if (!allowedTypes.includes(file.type)) {
            bgImageError.textContent = "Only JPG and PNG images are allowed";
            return false;
          } else if (file.size > 2 * 1024 * 1024) {
            bgImageError.textContent = "Image size must be less than 2MB";
            return false;
          }

          bgImageError.textContent = "";
          return true;
        }




      // Clear error on focus
    [movieName, movieType, releaseDate, movieDetails, imageCover, author, bgImage].forEach(input => {
      input.addEventListener("focus", () => {
        const errorSpan = document.getElementById(input.id + "-error");
        if (errorSpan) errorSpan.textContent = "";
      });
    });

      // Validate on blur
      movieName.addEventListener("blur", validateMovieName);
      movieType.addEventListener("blur", validateMovieType);
      releaseDate.addEventListener("blur", validateReleaseDate);
      movieDetails.addEventListener("blur", validateMovieDetails);
      imageCover.addEventListener("change", validateImageCover);
      author.addEventListener("blur", validateAuthor);
      bgImage.addEventListener("change", validateBgImage);  

      // Real-time typing validation
      movieName.addEventListener("input", validateMovieName);
      movieType.addEventListener("input", validateMovieType);
      releaseDate.addEventListener("input", validateReleaseDate);
      movieDetails.addEventListener("input", validateMovieDetails);
      author.addEventListener("input", validateAuthor);

      // Final submit validation
      movieForm.addEventListener("submit", function (e) {
        const isValid =
          validateMovieName() &&
          validateMovieType() &&
          validateReleaseDate() &&
          validateMovieDetails() &&
          validateImageCover() &&
          validateAuthor() &&
          validateBgImage();

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
