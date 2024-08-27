@extends('layouts.add')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/day.css') }}">
@endsection

@section('content')
<div class="container">
    <p class="title">データの閲覧したい日付を選択してください</p>
    <label for="monthSelector" class="label">月を選択:</label>
    <select id="monthSelector">
        @foreach(range(1, 12) as $m)
            <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                {{ $m }}月
            </option>
        @endforeach
    </select>
    <table id="calendar" class="calendar">
        <thead>
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const monthSelector = document.getElementById('monthSelector');

    const year = new Date().getFullYear();
    let currentMonth = parseInt(monthSelector.value, 10);

    function generateCalendar(month, year) {
    const firstDay = new Date(year, month - 1, 1).getDay();
    const daysInMonth = new Date(year, month, 0).getDate();
    let calendarHtml = '';
    let day = 1;

    for (let i = 0; i < 6; i++) {
        calendarHtml += '<tr>';
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay || day > daysInMonth) {
                calendarHtml += '<td></td>';
            } else {
                const dateStr = `${year}-${month}-${day}`;
                calendarHtml += `
                    <td>
                        <form method="GET" action="/day/${dateStr}">
                            @csrf
                            <button type="submit">${day}</button>
                        </form>
                    </td>`;
                day++;
            }
        }
        calendarHtml += '</tr>';
    }
    calendarEl.querySelector('tbody').innerHTML = calendarHtml;
}


    monthSelector.addEventListener('change', function() {
        currentMonth = parseInt(this.value, 10);
        generateCalendar(currentMonth, year);
    });

    generateCalendar(currentMonth, year);
});
</script>
@endsection