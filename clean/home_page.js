let text = document.querySelector("#rainbow-text");
load_rainbow_text(0.1, text);
let portal_activate = false;

const whiteBox = document.querySelector('.white-box');
const portalImg = document.querySelector('.portal_img');
let last_targets = null;

function toggleAnimation() {
    const current_target = event.target.id;
    if (last_targets === current_target || (!login_box.innerHTML && !signup_box.innerHTML)) {
        togglePortal(current_target);
    } else {
        whiteBox.classList.toggle('animate');
        toggleLoginModal();
        whiteBox.classList.toggle('full');
        toggleSignupModal();
    }
    last_targets = current_target;
}

function togglePortal(current_target) {
    // console.log(current_target);
    if (current_target == 'login_btn') {
        whiteBox.classList.toggle('animate');
        toggleLoginModal();
    } else if (current_target == 'signup_btn') {
        whiteBox.classList.toggle('full');
        toggleSignupModal();
    }
    portalImg.classList.toggle('transparent');
    toggleImageInWhiteBox();
    portal_activate = !portal_activate;
}

const portal_img = document.querySelector('#portal_img');
function toggleImageInWhiteBox() {
    if (whiteBox.contains(portal_img)) {
        whiteBox.removeChild(portal_img);
    } else {
        whiteBox.appendChild(portal_img);
    }
}

whiteBox.addEventListener('transitionend', () => {
    if (whiteBox.classList.contains('full') || whiteBox.classList.contains('animate')) {
      whiteBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

let login_box = document.querySelector('.login');
function toggleLoginModal() {
    if (login_box.innerHTML === '') {
        login_box.innerHTML = generateLoginModal();
        login_box.classList.add('show');
        portal_activate = true;

        // Get the generated form element
        const form = login_box.querySelector('.login_modal');
        var enter_button = form.getElementsByTagName('button')[0];

        // Listen for form submission
        form.addEventListener('submit', event => {
            // Prevent the default form submission
            event.preventDefault();

            // Get the entered username and password
            const username = form.querySelector('input[type="text"]').value;
            const password = form.querySelector('input[type="password"]').value;

            // Send an AJAX request to the login.php script
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'login.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = () => {
                if (xhr.status === 200 && xhr.responseText === 'success') {
                    enter_button.textContent = "Enter STARRY";
                    // Redirect to a protected page
                    window.location.href = 'HomePaged.php?random';
                } else {
                    // Show the error message
                    enter_button.textContent = "Try again...";
                }
            };
            xhr.send(`username=${username}&password=${password}`);
        });

    } else {
        login_box.classList.remove('show');
        login_box.innerHTML = '';
        portal_activate = false;
    }
}

let signup_box = document.querySelector('.signup');
function toggleSignupModal() {
    if (signup_box.innerHTML === '') {
        signup_box.innerHTML = generateSignupModal();
        signup_box.classList.add('show');
        portal_activate = true;

        // Get the generated form element
        const form = signup_box.querySelector('.signup_modal');
        var enter_button = form.getElementsByTagName('button')[0];
        
        // Listen for form submission
        form.addEventListener('submit', event => {
            // Prevent the default form submission
            event.preventDefault();

            // Get the entered email, username, and password
            const email = form.querySelector('input[type="email"]').value;
            const username = form.querySelector('input[type="text"]').value;
            const pw_fields = form.querySelectorAll('input[type="password"]');
            const password = pw_fields[0].value;
            const confirmPassword = pw_fields[1].value;

            // Check if the entered password and confirm password match
            if (password === confirmPassword) {
                // Send an AJAX request to the signup.php script
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'signup.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = () => {
                    if (xhr.status === 200 && xhr.responseText === 'success') {
                        // Redirect to a success page
                        enter_button.textContent = "You can now login!";
                    } else {
                        // Show an error message
                        enter_button.textContent = xhr.responseText;
                    }
                };
                xhr.send(`email=${email}&username=${username}&password=${password}`);
            } else {
                enter_button.textContent = "Confirm no match :'(";
            }
        });

    } else {
        signup_box.classList.remove('show');
        signup_box.innerHTML = '';
        portal_activate = false;
    }
}

function generateLoginModal() {
    return `
            <form method="post" class="login_modal disable-select">
                <label>Username</label>
                <input type="text" required>
                <label>Password</label>
                <input type="password" required>
                <a href="#" class="modal_link">Forgor Password?!</a>
                <button type="submit">Enter STARRY</button>
            </form>`;
}

function generateSignupModal() {
    return `
            <form method="post" class="signup_modal disable-select">
                <label>Email</label>
                <input type="email" required>
                <label>Username</label>
                <input type="text" required>
                <label>Password</label>
                <input type="password" required>
                <label>Confirm</label>
                <input type="password" class="confirm" required>
                <button type="submit">Sign Up Lezgo</button>
            </form>`;
}