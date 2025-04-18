$(document).ready(function () {
    function loadContent(target) {
        var contentArea = $("#content-area");

        $(".nav-btn").removeClass("active");
        $(".nav-btn[data-target='" + target + "']").addClass("active");

        $.ajax({
            url: target,
            type: "GET",
            dataType: "html",
            beforeSend: function () {
                contentArea.html("<p>Loading...</p>");
            },
            success: function (response) {
                contentArea.html(response);
            },
            error: function () {
                contentArea.html("<p style='color: red;'>Failed to load content. Please try again.</p>");
            }
        });
    }

    // Load "About PhiCSS" by default
    loadContent("admin_about_phicss.php");

    // Click event for navigation buttons
    $(".nav-btn").click(function () {
        var target = $(this).data("target");
        loadContent(target);
    });
});