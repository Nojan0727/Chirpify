function acceptCookies() {
    document.cookie = "cookie_consent=accepted; path=/; max-age=" + (60 * 60 * 24 * 30);
    document.getElementById("cookieBox").style.display = "none";
    location.reload();
}

function rejectCookies() {
    window.location.href = "https://www.google.com";
}

window.onload = function() {
    if (document.cookie.includes("cookie_consent=accepted")) {
        let cookieBox = document.getElementById("cookieBox");
        if (cookieBox) {
            cookieBox.style.display = "none";
        }
    }
};