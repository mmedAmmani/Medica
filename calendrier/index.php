
<?php
//index.php
session_start();
if(!isset($_SESSION["loggedin"])){
  header("location: ../log/index.php");
  exit;
}



?>
<!DOCTYPE html>
<html>
 <head>
 <title>Medica</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  <script>
   
  $(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
    },
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Ajouter un rendez-vous");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Le rendez-vous est ajouté avec succès");
       }
      })
     }
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Event Update');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Rendez-vous modifié");
      }
     });
    },

    eventClick:function(event)
    {
     if(confirm("Voulez-vous vraiment supprimer ce rendez-vous?"))
     {
      var id = event.id;
      $.ajax({
       url:"delete.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Event Removed");
       }
      })
     }
    },

   });
  });
   
  </script>
 </head>
 <style>
   @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200&family=Roboto+Mono:ital,wght@1,100&display=swap');

     #titre {
         color: #6A5ACD;
         font-family: cursive;
    
    }
    h2{font-family: Arial
    }
    #calendar {
        background-color: #E0FFFF;
    }
    .fc-month-button { }
    .fc-state-active {
  background-color: #000;
  color: #F0F8FF;
}
.fc-content{
  background-color: #7FFFD4;
}
.login h1 {
  font-family: 'Roboto Mono', monospace;
  font-size: 2.9rem;
  margin-bottom: 0.5rem;
  text-align: center;
}

.login h1 span {
  height: 40px;
  width: 50px;
}
.login h1 span img {
  height: 100%;
  width: 50px;
  transform: translateX(5px) translateY(10px);
}
 </style>
 <body>
  <br />

  <h1 align="center">Med <span><img src="logo.svg" alt=" "></span>ica</h1>

  <form action="../log/logout.php">
    <button type="submit" style="float:right">logout</button>
  </form>
  
  <br /> 
  <br>
  <br><br>
  <div class="container">
   <div id="calendar"></div>
  </div>
 </body>
</html>

