document.addEventListener("DOMContentLoaded", function () {
    console.log("Calendar script loaded successfully!");

    const calendarGrid = document.querySelector(".calendar-grid");
    const currentMonthYear = document.getElementById("currentMonthYear");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");

    let currentDate = new Date();

    function loadCalendar() {
        console.log("Loading calendar for:", currentDate);

        calendarGrid.innerHTML = "";
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        currentMonthYear.textContent = currentDate.toLocaleString("default", { month: "long", year: "numeric" });

        for (let i = 0; i < firstDay; i++) {
            let emptyDiv = document.createElement("div");
            emptyDiv.classList.add("calendar-day", "empty");
            calendarGrid.appendChild(emptyDiv);
        }

        for (let day = 1; day <= lastDate; day++) {
            let dateDiv = document.createElement("div");
            dateDiv.classList.add("calendar-day");
            dateDiv.textContent = day;

            let eventDateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
            if (events && events.some(event => {
                const startDate = new Date(event.event_start_date).toISOString().split('T')[0];
                const endDate = new Date(event.event_end_date).toISOString().split('T')[0];
                return startDate === eventDateStr || endDate === eventDateStr;
            })) {
                dateDiv.classList.add("event-day");
                console.log("Event found on:", eventDateStr);
            }

            calendarGrid.appendChild(dateDiv);
        }
    }

    prevMonthBtn.addEventListener("click", function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        loadCalendar();
    });

    nextMonthBtn.addEventListener("click", function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        loadCalendar();
    });

    loadCalendar();
});