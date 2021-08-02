<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
//import { formatDate } from '@fullcalendar/vue';
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import listPlugin from '@fullcalendar/list'
import interactionPlugin from '@fullcalendar/interaction'

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data() {
    return {
      calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin, listPlugin],
        initialView: 'dayGridMonth',
        dateClick: this.handleDateClick,
        weekends: false, // initial value
        listWeek: false,
        events: [
          { title: 'event 1', date: '2019-04-01' },
          { title: 'event 2', date: '2019-04-02' },
          {
            title: 'Meeting',
            start: '2019-08-12T14:30:00',
            extendedProps: {
              status: 'done'
            }
          },
          {
            title: 'Birthday Party',
            start: '2019-08-13T07:00:00',
            backgroundColor: 'green',
            borderColor: 'green'
          }
        ],
        /*titleFormat: { // will produce something like "Tuesday, September 18, 2018"
          month: 'long',
          year: 'numeric',
          day: 'numeric',
          weekday: 'long'
        }, */
        timeZone: 'local',
        locale: 'es'
        
      }
    }
  },
  methods: {
    handleDateClick: function(arg) {
      console.log(arg);
      console.log(arg.date);
      alert('date click! ' + arg.dateStr);
    },
    toggleWeekends: function() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends // toggle the boolean!
    },
    listar: function() {
      this.calendarOptions.listWeek = !this.calendarOptions.listWeek // toggle the boolean!
    },
    agendamiento:function(){

    }
  }
}
</script>
<template>
  <div class="app-container"> 
    <button @click="toggleWeekends">todos los dias</button>
    <button @click="listar">Listar</button>
    <FullCalendar :options="calendarOptions" />
  </div>
</template>