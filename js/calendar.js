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
    editable: true,
    lang: 'fr',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay',
    },
    events: '../rdv/load.php',
    selectable: true,
    height: document.getElementById('calendar').offsetHeight,
    selectHelper: true,
    select: function (start, end, allDay) {
      var title = prompt('entrer le nom du patient')
      if (title) {
        var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss')
        var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss')
        $.ajax({
          url: '../rdv/insert.php',
          type: 'POST',
          data: { title: title, start: start, end: end },
          success: function () {
            calendar.fullCalendar('refetchEvents')
          },
        })
      }
    },
    editable: true,
    eventResize: function (event) {
      var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss')
      var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss')
      var title = event.title
      var id = event.id
      if (confirm('voulez vous vraiment modifier ce rendez vous ?')) {
        alert('hahahhah')
        $.ajax({
          url: '../rdv/update.php',
          type: 'POST',
          data: { title: title, start: start, end: end, id: id },
          success: function () {
            calendar.fullCalendar('refetchEvents')
          },
        })
      }
    },

    eventDrop: function (event) {
      var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss')
      var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss')
      var title = event.title
      var id = event.id
      if (confirm('voulez vous vraiment modifier ce rendez vous ? ')) {
        $.ajax({
          url: '../rdv/update.php',
          type: 'POST',
          data: { title: title, start: start, end: end, id: id },
          success: function () {
            calendar.fullCalendar('refetchEvents')
          },
        })
      } else {
        calendar.fullCalendar('refetchEvents')
      }
    },

    eventClick: function (event) {
      if (confirm('Are you sure you want to remove it?')) {
        var id = event.id
        $.ajax({
          url: '../rdv/delete.php',
          type: 'POST',
          data: { id: id },
          success: function () {
            calendar.fullCalendar('refetchEvents')
            
          },
        })
      }
    },
  })
})