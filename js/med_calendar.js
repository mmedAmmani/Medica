$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
      monthNames: [
        'janvier',
        'Fevrier',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Aout',
        'Septembre',
        'Octobre',
        'Novembre',
        'Decembre',
      ],
      monthNamesShort: [
        'Jan',
        'Fev',
        'Mar',
        'Avr',
        'May',
        'Juin',
        'Juil',
        'Aout',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
      ],
      dayNames: [
        'dimanche',
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
      ],
      dayNamesShort: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
      editable: false,
      lang: 'fr',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay',
      },
      events: '../rdv/load.php',
      height: document.getElementById('calendar').offsetHeight,
       function () {
        calendar.fullCalendar('refetchEvents')
      },
    })
  })
  