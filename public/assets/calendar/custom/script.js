 var calendar = $.calendars.instance('ethiopian', 'am');
$('[type="date"]').calendarsPicker({
    calendar: calendar,
    dateFormat: 'Y-mm-d'
});
$('[type="date"]').addClass('ethio-date');
$('[type="date"]').attr('type','text');
