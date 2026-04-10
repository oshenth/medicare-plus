const navbarContainer = document.getElementById("navbar-container");

if (navbarContainer) {
    const user = getUser();

    let authSection = `
        <a href="login.html" class="btn login-btn">Login</a>
        <a href="register.html" class="btn register-btn">Register</a>
    `;

    if (user) {
        let dashboardLink = "patient.html";

        if (user.role === "admin") {
            dashboardLink = "admin.html";
        } else if (user.role === "doctor") {
            dashboardLink = "doctor.html";
        }

        authSection = `
            <a href="${dashboardLink}" class="user-name">Hi, ${user.name}</a>
            <button class="btn logout-btn" onclick="logoutUser()">Logout</button>
        `;
    }

    navbarContainer.innerHTML = `
        <header class="navbar sticky-navbar">
            <div class="logo-area">
                <img src="logov2.png" alt="MediCare Plus Logo" class="logo-img">
                <a href="index.html" class="logo-text">MediCare Plus</a>
            </div>

            <nav class="nav-links">
                <a href="index.html">Home</a>
                <a href="doctors.html">Doctors</a>
                <a href="services.html">Services</a>
                <a href="messages.html">Messages</a>
                <a href="appointment.html">Book Appointment</a>
            </nav>

            <div class="auth-area">
                ${authSection}
            </div>
        </header>
    `;
}