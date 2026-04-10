const footerContainer = document.getElementById("footer-container");

if (footerContainer) {
    footerContainer.innerHTML = `
        <footer class="main-footer">
            <div class="footer-section">
                <h3>MediCare Plus</h3>
                <p>No. 26/39/5, Anuradhapura, Sri Lanka</p>
                <p>Phone: +94 76 496 8115</p>
                <p>Email: oshenth@gmail.com</p>
            </div>

            <div class="footer-section">
                <h3>Useful Links</h3>
                <a href="about.html">About Us</a>
                <a href="contact.html">Contact Us</a>
                <a href="services.html">Services</a>
                <a href="doctors.html">Doctors</a>
                <a href="health-tips.html">Health Tips</a>
            </div>

            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com/share/16zFYK6D9d/?mibextid=wwXIfr" title="Facebook">f</a>
                    <a href="https://www.instagram.com/0shenth?igsh=bTd0dXl2ZmFjaG5v&utm_source=qr" title="Instagram">IG</a>
                    <a href="https://x.com/oshenth?s=11" title="X Formely knowsn as Twitter">X</a>
                    <a href="https://www.linkedin.com/in/oshenth-jayathilake-006a9a1ba?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" title="LinkedIn">in</a>
                </div>
            </div>
        </footer>
    `;
}