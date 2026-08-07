$(document).ready(function () {

    // Check login session (localStorage based, no PHP session)
    const user = JSON.parse(localStorage.getItem("user"));
    const token = localStorage.getItem("token");

    if (!user || !token) {
        alert("Please login first!");
        window.location.href = "login.html";
        return;
    }

    // Load existing profile data if available
    $.ajax({
        url: "profile.php",
        method: "POST",
        data: {
            action: "get",
            email: user.email
        },
        dataType: "json",
        success: function (res) {
            if (res.success && res.data) {
                $("#name").val(res.data.name || user.name);
                $("#age").val(res.data.age || "");
                $("#dob").val(res.data.dob || "");
                $("#phone").val(res.data.phone || "");
            } else {
                $("#name").val(user.name);
            }
        },
        error: function () {
            $("#name").val(user.name);
        }
    });

    // Save profile
    $("#profileForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "php/profile.php",
            method: "POST",
            data: {
                action: "save",
                email: user.email,
                name: $("#name").val(),
                age: $("#age").val(),
                dob: $("#dob").val(),
                phone: $("#phone").val()
            },
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    alert(res.message);
                } else {
                    alert("Save failed: " + res.message);
                }
            },
            error: function (xhr) {
                alert("Server error: " + xhr.status + " - " + xhr.responseText);
            }
        });
    });

    // Optional: Logout button functionality (add a logout button in HTML if needed)
    window.logout = function () {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
        window.location.href = "login.html";
    };

});
