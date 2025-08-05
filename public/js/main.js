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


// Show Toast

function showToast(message) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show");
  }, 3000); // visible for 3 seconds
}
