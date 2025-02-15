function acceptCookies() {
    document.cookie = "cookie_consent=accepted; path=/; max-age=" + (60 * 60 * 24 * 30);
    document.getElementById("cookieBox").style.display = "none";
    location.reload();
}

function rejectCookies() {
    window.location.href = "https://www.google.com";
}

window.onload = function() {
    let cookieBox = document.getElementById("cookieBox");
    if (cookieBox) {
        cookieBox.style.display = "block";
        document.cookie = "cookie_consent=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
};

function toggleTerms() {
    let termsBox = document.getElementById("termsBox");
    if (termsBox.style.display === "none" || termsBox.style.display === "") {
        termsBox.style.display = "block";
    } else {
        termsBox.style.display = "none";
    }
}