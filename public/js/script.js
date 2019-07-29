let loginBtn = document.getElementById("show-login");
let registerBtn = document.getElementById("show-register");
let buttons = [loginBtn, registerBtn];
var modal = document.getElementById("loginModal");
let registerModal = document.getElementById("register-modal");
var modalContent = document.getElementsByClassName("modal-content")[0];

buttons.forEach(button => {
    if (button) {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            if (button === loginBtn) modal.classList.add("display");
            else {
                registerModal.classList.add("display");
            }
        });
    }
});
var closeBtns = document.getElementsByClassName("closeBtn");
for (let button of closeBtns) {
    button.addEventListener("click", function() {
        modal.classList.remove("display");
        registerModal.classList.remove("display");
    });
}

window.addEventListener("click", function(e) {
    if (e.target === modal) modal.classList.remove("display");
});
