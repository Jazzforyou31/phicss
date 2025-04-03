$(document).ready(function () {
    function loadContent(target) {
        var contentArea = $("#content-area");
        var url = target === "announcement" ? "../admin/admin_announcement.php" : target;

        $(".nav-btn").removeClass("active");
        $(".nav-btn[data-target='" + target + "']").addClass("active");

        $.ajax({
            url: url,
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

    // Load announcement by default
    loadContent("announcement");

    // Click event for navigation buttons
    $(".nav-btn").click(function () {
        var target = $(this).data("target");
        loadContent(target);
    });
});