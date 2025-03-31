// Hamburger Menu

const menuItem = document.getElementById("menu-item");
if(menuItem){
    menuItem.addEventListener('click',()=>{
        document.getElementById("nav-bar").classList.toggle("show");
        document.querySelectorAll("span").forEach((bar)=>{
            bar.classList.toggle("change");
        });
    });
}


function removeErrorMessages() {
    const errorMessages = document.querySelectorAll('.error-text');
    setTimeout(() => {
        errorMessages.forEach((msg) => {
            msg.style.opacity = '0'; // Fade out
            setTimeout(() => {
                msg.textContent = ''; // Clear the message after fading out
            }, 500); // Delay to match the fade-out duration
        });
    }, 3000);
}

removeErrorMessages();


function clearErrorMessageOnInput() {
    const inputs = document.querySelectorAll('input'); // Select all input fields
    inputs.forEach((input) => {
        input.addEventListener('input', () => {
            const errorMessage = input.nextElementSibling; // Assuming the error message is next to the input
            if (errorMessage && errorMessage.classList.contains('error-msg')) {
                errorMessage.textContent = ''; // Clear the error message text
            }
        });
    });
}

// Call the function after the inputs are loaded
clearErrorMessageOnInput();


document.addEventListener("DOMContentLoaded", function () {
    const genresToggleBtn = document.getElementById('toggle-genres');
    const genresWrapper = document.getElementById('genres-wrapper');
    
    genresToggleBtn.addEventListener('click',()=>{
            console.log("Click toggle btn");
            genresWrapper.style.display = genresWrapper.style.display === "block" ? "none" : "block";
    })
});

document.addEventListener("click", function (event) {
    const container = document.getElementById('genre-selector');
    const genreWrapper = document.getElementById('genres-wrapper');
    if (!container.contains(event.target)) {
        genreWrapper.style.display = "none";
    }
});