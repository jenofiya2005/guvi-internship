$(document).ready(function () {
    $("#loginForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "php/login.php",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    // Save session info in localStorage (spec requirement, no PHP session)
                    localStorage.setItem("token", res.token);
                    localStorage.setItem("user", JSON.stringify(res.user));

                    alert(res.message);
                    window.location.href = "profile.html";
                } else {
                    alert("Login failed: " + res.message);
                }
            },
            error: function (xhr) {
                alert("Server error: " + xhr.status + " - " + xhr.responseText);
            }
        });
    });
});