$(document).ready(function () {
    $("#registerForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "register.php",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    alert(res.message);
                    window.location.href = "login.html";
                } else {
                    alert("Registration failed: " + res.message);
                }
            },
            error: function (xhr) {
                alert("Server error: " + xhr.status + " - " + xhr.responseText);
            }
        });
    });
});
