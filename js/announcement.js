$(document).ready(function () {
    // Prevent sidebar and navbar from shifting
    $(".nav-menu").css("width", "100%"); 
    $("#content-area").css("min-height", "400px");

    // Search Functionality
    $("#searchBar").on("input", function () {
        var searchText = $(this).val().toLowerCase();
        $("#announcementList .list-group-item").each(function () {
            var title = $(this).find(".announcement-title").text().toLowerCase();
            $(this).toggle(title.includes(searchText));
        });
    });

    // Filter Functionality
    $("#filterSelect").on("change", function () {
        var filter = $(this).val();
        var items = $("#announcementList .list-group-item").toArray();

        items.sort(function (a, b) {
            var aText = $(a).find(".announcement-title").text();
            var bText = $(b).find(".announcement-title").text();
            return filter === "latest" ? bText.localeCompare(aText) : aText.localeCompare(bText);
        });

        $("#announcementList").empty().append(items);
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const navArrows = document.querySelectorAll('.nav-arrow');
    let announcements = JSON.parse(document.getElementById("announcement-data").textContent);
    let currentAnnouncementIndex = 0;

    function updateAnnouncementText(index) {
        const announcementText = document.querySelector('.announcement-text a');
        if (announcementText && announcements.length > 0) {
            announcementText.textContent = announcements[index];
        }
    }

    if (navArrows.length >= 2 && announcements.length > 1) {
        navArrows[0].addEventListener('click', function () {
            currentAnnouncementIndex = (currentAnnouncementIndex - 1 + announcements.length) % announcements.length;
            updateAnnouncementText(currentAnnouncementIndex);
        });

        navArrows[1].addEventListener('click', function () {
            currentAnnouncementIndex = (currentAnnouncementIndex + 1) % announcements.length;
            updateAnnouncementText(currentAnnouncementIndex);
        });
    }
});
