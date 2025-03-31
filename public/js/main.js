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