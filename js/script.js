// Function to dynamically load the content of given HTML files into the #main-content div
function loadPage(page, callback) {
    fetch(page)
        .then(response => response.text())
        .then(data => {
            document.getElementById('main-content').innerHTML = data;
            if (typeof callback === "function") {
                callback();
            }
        })
        .catch(error => console.error('Error loading the page: ', error));
}

// Function to set up event listeners for the main content
function setupMainContentListeners() {
    // Event listener for the "Login/Register" button in the initial main content
    const loginRegisterBtn = document.querySelector('.button'); // Ensure your button has this class
    if (loginRegisterBtn) {
        loginRegisterBtn.addEventListener('click', () => loadPage('login.html', setupLoginListeners));
    }
}

// Function to set up event listeners specific to the login content
function setupLoginListeners() {
    const goToRegisterBtn = document.getElementById('go-to-register');
    if (goToRegisterBtn) {
        goToRegisterBtn.addEventListener('click', () => loadPage('register.html', setupRegisterListeners));
    }
    // Add any other event listeners related to the login page here
}

// Function to set up event listeners specific to the register content
function setupRegisterListeners() {
    const goToLoginBtn = document.getElementById('go-to-login');
    if (goToLoginBtn) {
        goToLoginBtn.addEventListener('click', () => loadPage('login.html', setupLoginListeners));
    }
    // Add any other event listeners related to the register page here
}

// Initial setup when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    setupMainContentListeners();
});