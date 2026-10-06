<?php

// Get today's date
$today = new DateTime();

// Get current month and year
$currentMonth = (int)$today->format('n');
$currentYear = (int)$today->format('Y');


// Get month and year from URL
// If there is no value, use the current month and year

$month = isset($_GET['month'])
    ? (int)$_GET['month']
    : $currentMonth;

$year = isset($_GET['year'])
    ? (int)$_GET['year']
    : $currentYear;


// Make sure the month stays between 1 and 12

if ($month < 1) {
    $month = 12;
    $year--;
}

if ($month > 12) {
    $month = 1;
    $year++;
}


// Create the selected month

$calendarDate = new DateTime(
    $year . '-' . $month . '-01'
);


// Month name

$monthName = $calendarDate->format('F');


// Number of days in the month

$numberOfDays = (int)$calendarDate->format('t');


// First day of the month

// 0 = Sunday
// 1 = Monday
// ...
// 6 = Saturday

$startingDay = (int)$calendarDate->format('w');


// Today's date information

$todayDay = (int)$today->format('j');
$todayMonth = (int)$today->format('n');
$todayYear = (int)$today->format('Y');


// Selected date

$selectedDate = isset($_GET['selected'])
    ? $_GET['selected']
    : null;


// Display text under Calendar

$selectedDateText = "Select a date";


if ($selectedDate !== null) {

    $selectedDateObject = DateTime::createFromFormat(
        'Y-m-d',
        $selectedDate
    );


    if (
        $selectedDateObject !== false &&
        $selectedDateObject->format('Y-m-d') === $selectedDate
    ) {

        $selectedDateText =
            $selectedDateObject->format('F j, Y');

    }

}


// Previous month

$previousMonth = $month - 1;
$previousYear = $year;

if ($previousMonth < 1) {

    $previousMonth = 12;
    $previousYear--;

}


// Next month

$nextMonth = $month + 1;
$nextYear = $year;

if ($nextMonth > 12) {

    $nextMonth = 1;
    $nextYear++;

}


// Today URL

$todayUrl =
    "index.php?month=" .
    $todayMonth .
    "&year=" .
    $todayYear .
    "&selected=" .
    $today->format('Y-m-d');

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Calendar App</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>


<div class="calendar-app">


    <!-- Header -->

    <header class="calendar-header">


        <div class="title-section">

            <h1>Calendar</h1>

            <p>

                <?php

                echo htmlspecialchars(
                    $selectedDateText
                );

                ?>

            </p>

        </div>


        <!-- Today Button -->

        <a
            href="<?php echo htmlspecialchars($todayUrl); ?>"
            class="today-button"
        >
            Today
        </a>


    </header>



    <!-- Month Navigation -->

    <div class="month-navigation">


        <!-- Previous Month -->

        <a
            href="index.php?month=<?php echo $previousMonth; ?>&year=<?php echo $previousYear; ?>"
            class="nav-button"
        >
            &#10094;
        </a>


        <!-- Month and Year -->

        <h2>

            <?php

            echo htmlspecialchars(
                $monthName . " " . $year
            );

            ?>

        </h2>


        <!-- Next Month -->

        <a
            href="index.php?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>"
            class="nav-button"
        >
            &#10095;
        </a>


    </div>



    <!-- Calendar -->

    <div class="calendar">


        <!-- Days of the Week -->

        <div class="weekdays">

            <div>Sun</div>

            <div>Mon</div>

            <div>Tue</div>

            <div>Wed</div>

            <div>Thu</div>

            <div>Fri</div>

            <div>Sat</div>

        </div>



        <!-- Calendar Dates -->

        <div class="calendar-days">


            <?php


            // Empty spaces before the first day

            for (
                $i = 0;
                $i < $startingDay;
                $i++
            ) {

                echo '<div class="empty-day"></div>';

            }



            // Display all days

            for (
                $day = 1;
                $day <= $numberOfDays;
                $day++
            ) {


                // Check if this is today's date

                $isToday =
                    $day === $todayDay &&
                    $month === $todayMonth &&
                    $year === $todayYear;


                // Create date value

                $dateValue = sprintf(
                    '%04d-%02d-%02d',
                    $year,
                    $month,
                    $day
                );


                // Check if selected

                $isSelected =
                    $selectedDate === $dateValue;


                // Default class

                $classes = "calendar-day";


                if ($isToday) {

                    $classes .= " today";

                }


                if ($isSelected) {

                    $classes .= " selected";

                }


                ?>


                <a
                    href="index.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>&selected=<?php echo $dateValue; ?>"
                    class="<?php echo $classes; ?>"
                >

                    <?php echo $day; ?>

                </a>


                <?php

            }

            ?>


        </div>

    </div>


</div>


</body>

</html>