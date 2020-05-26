let loginBtn = document.getElementById("show-login");
let registerBtn = document.getElementById("show-register");
let signUpBtn = document.getElementById("sign-up");
let buttons = [loginBtn, registerBtn, signUpBtn];

var modal = document.getElementById("theModal");

let loginContent = document.getElementById("login-content");
let registerContent = document.getElementById("register-content");

buttons.forEach(button => {
    if (button) {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            if (button === loginBtn) {
                modal.classList.add("display");
                loginContent.classList.add("display");
            } else if (button === registerBtn) {
                modal.classList.add("display");
                registerContent.classList.add("display");
            }
        });
    }
});
var closeBtns = document.getElementsByClassName("closeBtn");
for (let button of closeBtns) {
    button.addEventListener("click", function() {
        modal.classList.remove("display");
        registerContent.classList.remove("display");
        loginContent.classList.remove("display");
    });
}

window.addEventListener("click", function(e) {
    if (e.target === modal) {
        modal.classList.remove("display");
        registerContent.classList.remove("display");
        loginContent.classList.remove("display");
    }
});
