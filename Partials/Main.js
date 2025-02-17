console.log("Current Path: ", window.location.pathname);
function AcceptCookies() {
    document.cookie = "cookie_consent=accepted; path=/; max-age=" + (60 * 60 * 24 * 30);
    document.getElementById("cookieBox").style.display = "none";
}

function RejectCookies() {
    window.location.href = "https://www.google.com";
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.cookie.includes("cookie_consent=accepted")) {
        document.getElementById("cookieBox").style.display = "none";
    }
});