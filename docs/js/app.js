const topSpan = document.querySelector('.bg.top');
const middleSpan = document.querySelector('.bg.middle');
const bottomSpan = document.querySelector('.bg.bottom');
const bgContainer = document.querySelector('.bg-container');

// select forms
const loginForm = document.querySelector('#login-form');
const registerForm = document.querySelector('#register-form');

// select links
const registerUrl = document.querySelector('#login-form .link');
const loginUrl = document.querySelector('#register-form .link');

let rotateVal = 1;

const toggleFormAnim = () => {
    topSpan.style.transform = 'rotateX(-180deg)';
    setTimeout(() => {
        bottomSpan.style.transform = 'rotateX(180deg)';  // Corrected typo
        setTimeout(() => {
            bgContainer.style.transform = `rotateY(${rotateVal * 180}deg)`;  // Corrected string interpolation
            setTimeout(() => {
                bottomSpan.style.transform = 'rotateX(0)';
                setTimeout(() => {
                    topSpan.style.transform = 'rotateX(0)';  // Corrected typo
                }, 1000);
            }, 1000);
        }, 1000);
    }, 1000);
}

registerUrl.addEventListener('click', () => {
    loginForm.classList.remove('active');
    rotateVal += 1;  // Toggle the rotation value
    setTimeout(() => {
        toggleFormAnim();
        setTimeout(() => {
            registerForm.classList.add('active');
        }, 5000);
    }, 500);
});

loginUrl.addEventListener('click', () => {
    registerForm.classList.remove('active');
    rotateVal += 1;  // Toggle the rotation value
    setTimeout(() => {
        toggleFormAnim();
        setTimeout(() => {
            loginForm.classList.add('active');
        }, 5000);
    }, 500);
});
