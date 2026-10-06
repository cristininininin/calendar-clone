// Get the calendar elements from HTML

const monthYear = document.getElementById("monthYear");
const calendarDays = document.getElementById("calendarDays");

const previousButton = document.getElementById("previousButton");
const nextButton = document.getElementById("nextButton");
const todayButton = document.getElementById("todayButton");

const selectedDateText = document.getElementById("selectedDate");


// Get today's date

const today = new Date();


// Store the month currently being displayed

let currentMonth = today.getMonth();
let currentYear = today.getFullYear();


// Store the selected date

let selectedDate = null;


// Month names

const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
];


// Display the calendar

function displayCalendar() {

    // Clear the previous calendar dates

    calendarDays.innerHTML = "";


    // Get the first day of the current month

    const firstDay = new Date(
        currentYear,
        currentMonth,
        1
    );


    // Get the last day of the current month

    const lastDay = new Date(
        currentYear,
        currentMonth + 1,
        0
    );


    // Get the number of days in the month

    const numberOfDays = lastDay.getDate();


    // Get the day of the week of the first day

    // Sunday = 0
    // Monday = 1
    // Tuesday = 2
    // ...
    // Saturday = 6

    const startingDay = firstDay.getDay();


    // Display Month and Year

    monthYear.textContent =
        monthNames[currentMonth] + " " + currentYear;


    // Create empty spaces before the first day

    for (let i = 0; i < startingDay; i++) {

        const emptyDay = document.createElement("div");

        emptyDay.classList.add("empty-day");

        calendarDays.appendChild(emptyDay);
    }


    // Create the calendar dates

    for (let day = 1; day <= numberOfDays; day++) {

        const dayButton = document.createElement("button");

        dayButton.textContent = day;

        dayButton.classList.add("calendar-day");


        // Check if this date is TODAY

        const isToday =
            day === today.getDate() &&
            currentMonth === today.getMonth() &&
            currentYear === today.getFullYear();


        if (isToday) {

            dayButton.classList.add("today");

        }


        // Check if this date is SELECTED

        if (
            selectedDate &&
            day === selectedDate.getDate() &&
            currentMonth === selectedDate.getMonth() &&
            currentYear === selectedDate.getFullYear()
        ) {

            dayButton.classList.add("selected");

        }


        // When the user clicks a date

        dayButton.addEventListener("click", function () {

            selectedDate = new Date(
                currentYear,
                currentMonth,
                day
            );


            // Display selected date

            displaySelectedDate();


            // Refresh calendar

            displayCalendar();

        });


        calendarDays.appendChild(dayButton);
    }
}


// Display the selected date

function displaySelectedDate() {

    if (selectedDate === null) {

        selectedDateText.textContent = "Select a date";

        return;
    }


    const formattedDate =
        monthNames[selectedDate.getMonth()] +
        " " +
        selectedDate.getDate() +
        ", " +
        selectedDate.getFullYear();


    selectedDateText.textContent = formattedDate;
}


// Previous Month Button

previousButton.addEventListener("click", function () {

    currentMonth--;


    // If we go before January

    if (currentMonth < 0) {

        currentMonth = 11;

        currentYear--;

    }


    displayCalendar();

});


// Next Month Button

nextButton.addEventListener("click", function () {

    currentMonth++;


    // If we go after December

    if (currentMonth > 11) {

        currentMonth = 0;

        currentYear++;

    }


    displayCalendar();

});


// Today Button

todayButton.addEventListener("click", function () {

    currentMonth = today.getMonth();

    currentYear = today.getFullYear();

    selectedDate = today;

    displaySelectedDate();

    displayCalendar();

});


// Display the calendar when the page opens

displayCalendar();