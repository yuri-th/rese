// 入力ボックスの値を自動入力
const dateBox = document.getElementById('reservation_date');
const dateInput = document.getElementById('confirm__date');
const timeBox = document.getElementById('reservation_time');
const timeInput = document.getElementById('confirm__time');
const numberBox = document.getElementById('reservation_number');
const numberInput = document.getElementById('confirm__number');

dateBox.addEventListener('change', function () {
    dateInput.value = dateBox.value;
});

timeBox.addEventListener('change', function () {
    timeInput.value = timeBox.value;
});

numberBox.addEventListener('change', function () {
    numberInput.value = numberBox.value;
});