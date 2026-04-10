function getUser() {
    const raw = localStorage.getItem("user");
    return raw ? JSON.parse(raw) : null;
}

function requireLogin() {
    const user = getUser();
    if (!user) {
        window.location.href = "login.html";
    }
    return user;
}

function requireRole(role) {
    const user = requireLogin();
    if (user.role !== role) {
        window.location.href = "index.html";
    }
    return user;
}

function logoutUser() {
    localStorage.removeItem("user");
    window.location.href = "index.html";
}

function postForm(url, formDataObject) {
    const formData = new URLSearchParams();
    Object.keys(formDataObject).forEach(key => {
        formData.append(key, formDataObject[key]);
    });

    return fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: formData.toString()
    }).then(res => res.text());
}