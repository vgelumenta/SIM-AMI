document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar')
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',

        // customButtons: {
        //     myCustomButton: {
        //       text: 'custom!',
        //       click: function() {
        //         alert('clicked the custom button!');
        //       }
        //     }
        //   },
        //   headerToolbar: {
        //     left: 'prev,next today myCustomButton',
        //     center: 'title',
        //     right: 'dayGridMonth,timeGridWeek,timeGridDay'
        //   },

        events: '/events/list',
        dateClick: function(info) {
            var modalHandler = document.querySelector('[x-data]').__x.$data;
            modalHandler.openModal('Date Clicked', 'You clicked on date: ' + info.dateStr);
            console.log('Tanggal diklik: ' + info.dateStr);
          }
    })
    calendar.render()
})