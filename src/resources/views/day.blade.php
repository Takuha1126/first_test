@extends('layouts.add')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/day.css') }}">
@endsection

@section('content')

<?php
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
    $month = isset($_GET['month']) ? $_GET['month'] : date('n');

    $prevMonth = ($month == 1) ? 12 : $month - 1;
    $prevYear = ($month == 1) ? $year - 1 : $year;

    $nextMonth = ($month == 12) ? 1 : $month + 1;
    $nextYear = ($month == 12) ? $year + 1 : $year;
?>

<style>
    .calendar-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 200px;
        margin:0 auto;
    }

    .pagination a {
        text-decoration: none;
        color: black;
        font-size: 24px;
        cursor: pointer;

    }
    a{
        text-decoration: none;
        color:#000;
    }

</style>
        <div class="title">
            <p>日付を選択してください</p>
        </div>

        <div class="pagination">
            <a href="?year=<?= $prevYear ?>&month=<?= $prevMonth ?>"><<</a>
            <div class='current-month'><?= $year ?>年<?= $month ?>月</div>
            <a href="?year=<?=$nextYear ?>&month=<?= $nextMonth ?>">>></a>
        </div>
        <div class="calendar-container">
        <?php
        $firstDayOfMonth = strtotime("$year-$month-01");
        $daysInMonth = date('t', $firstDayOfMonth);
        $startingDayOfWeek = date('N', $firstDayOfMonth);
        

        $prevMonthLastDay = date('t', strtotime('last day of previous month', $firstDayOfMonth));

        echo "<table>";
        echo "<tr>";
        echo "<th>月</th>";
        echo "<th>火</th>";
        echo "<th>水</th>";
        echo "<th>木</th>";
        echo "<th>金</th>";
        echo "<th>土</th>";
        echo "<th>日</th>";
        echo "</th>";

        echo "<tr>";
        for ($i = $startingDayOfWeek - 1; $i > 0; $i--) {
            echo "<td class='other-month'></td>";
        }
        

        $dayCounter = $startingDayOfWeek;
        for ($day = 1;$day <= $daysInMonth; $day++) {
            if($dayCounter == 8) {
                echo "</tr><tr>";
                $dayCounter = 1;
            }
            echo "<td><a href='" . route('attendance', ['year' => $year, 'month' => $month, 'day' => $day]) . "'>$day</a></td>";

            $dayCounter++;

        }

        $lastDayOfWeek = date('N', strtotime("$year-$month-$daysInMonth"));
        if($lastDayOfWeek < 7) {
            for($i = 1; $i <= 7 - $lastDayOfWeek; $i++) {
                echo "<td class='other-month'></td>";
            }
        }
        echo "</tr>";
        echo "</table>";

    
        ?>
        </div>
        <footer class="footer">
            <div class="footer_title">
                <small class="footer__small">Atte,inc.</small>
            </div>
        </footer>
@endsection
