<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Agendar Citas</span>
        </div>
        <!-- <el-button type="primary" icon="el-icon-plus" @click="toggleWeekends">todos los dias</el-button> -->
        <el-button type="primary" icon="el-icon-plus" @click="agendamiento">Nueva Cita</el-button>
        <br>
        <br>
        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" style="min-width:100vh;">
          <el-form ref="dataForm" :rules="rules" :model="temp" style="padding:0px 30px;">
            <el-form-item label="Fecha/Hora de cita" prop="registration_date">
              <el-col :span="11" style="width: 100%;">
                <el-date-picker v-model="temp.registration_date" type="date" placeholder="Seleccione Fecha" style="width: 100%;" />
              </el-col>
              <el-col :span="11" style="width: 100%;">
                <el-time-picker v-model="temp.hours" type="time" placeholder="Seleccione hora" style="width: 100%;" min="08:00:00" max="18:00:00" />
              </el-col>
            </el-form-item>
            <el-form-item label="Titulo de cita" prop="description">
              <el-select v-model="temp.description" placeholder="Veterinario" style="width: 100%;">
                <el-option
                  v-for="item in razon"
                  :key="'1'+item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Duración de cita" prop="end">
              <el-select v-model="temp.end" placeholder="Duración" style="width: 100%;">
                <el-option
                  v-for="(item, index) in duracion"
                  :key="'ffff'+index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Veterinario" prop="personal_id">
              <el-select v-model="temp.personal_id" placeholder="Veterinario" style="width: 100%;">
                <el-option
                  v-for="item in optionsPersonal"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Cliente" prop="client_id">
              <el-select v-model="temp.client_id" placeholder="Seleccione un cliente" style="width: 100%;" @input="getListPet">
                <el-option
                  v-for="item in optionsClient"
                  :key="'ll'+item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Mascota" prop="pet_id">
              <el-select v-model="temp.pet_id" placeholder="Seleccione un mascota" style="width: 100%;">
                <el-option
                  v-for="item in optionsPet"
                  :key="'kk'+item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">
              {{ $t('table.cancel') }}
            </el-button>
            <el-button type="primary" @click="dialogStatus==='create'?createData():updateData()">
              {{ $t('table.confirm') }}
            </el-button>
          </div>
        </el-dialog>
      </el-card>
    </el-row>
  </div>
</template>
<script>
import '@fullcalendar/core/vdom'; // solves problem with Vite
// import { formatDate } from '@fullcalendar/vue';
// import { Calendar } from '@fullcalendar/core'
import FullCalendar from '@fullcalendar/vue';
import dayGridPlugin from '@fullcalendar/daygrid';
import listPlugin from '@fullcalendar/list';
import timeGridPlugin from '@fullcalendar/timegrid';
import waves from '@/directive/waves'; // Waves directive
import interactionPlugin from '@fullcalendar/interaction';
import { fetchList, createCita, ListPersonal, ListClient, ListPet } from '@/api/appointment';
// import Pagination from '@/components/Pagination';
// import { sliceEvents, createPlugin } from '@fullcalendar/core';

export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
    // Pagination,
  },
  directives: { waves },
  data() {
    /* var validateCita = (rule, value, callback) => {
      let dateStringArray = this.temp.registration_date.toLocaleDateString().split('/');
      let fechaVal = dateStringArray[2]+'-'+this.fechaMes(dateStringArray[1])+'-'+this.fechaMes(dateStringArray[0]);
      let timeString = this.temp.hours.toLocaleTimeString();
      //let formatomes = this.fechaMes(dateStringArray[1]);
      //console.log('formato mes', formatomes);
      console.log('dateString', fechaVal);
      console.log('timeString', timeString);

      console.log(value);
      if (value >= 1 && fechaVal != '' && timeString != ''){
          Object.entries(this.list).forEach(([key, valor]) => {
              if (value == valor.personal_id && fechaVal == valor.registration_date && timeString == valor.hours ){
                  console.log('No se puede registrar la cita', valor.registration_date);
                  callback(new Error('No se puede registrar la cita'));
              }else{
                callback();
              }
            });
      }else{
        callback();
      }

    };*/
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
        initialView: 'dayGridMonth',
        dateClick: this.handleDateClick,
        editable: true,
        weekends: true, // initial value
        // timeGridWeek: true, // initial value
        selectable: true,
        // initialEvents: INITIAL_EVENTS,
        selectMirror: true,
        dayMaxEvents: true,
        select: this.handleDateSelect,
        eventClick: this.handleEventClick,
        eventsSet: this.handleEvents,
        headerToolbar: {
          left: 'prev,next today',
          right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        // dayHeaderFormat: { weekday: 'narrow', day: 'numeric' },
        slotMinTime: '08:00:00',
        slotMaxTime: '18:00:00',
        height: 'auto',
        /* customButtons: {
          addEventButton: {
            text: 'add event...',
            click: function() {
              var dateStr = prompt('Enter a date in YYYY-MM-DD format');
              var date = new Date(dateStr + 'T00:00:00'); // will be in local time

              if (!isNaN(date.valueOf())) { // valid?
                Calendar.addEvent({
                  title: 'dynamic event',
                  start: date,
                  allDay: true
                });
                alert('Great. Now, update your database...');
              } else {
                alert('Invalid date.');
              }
            }
          }
        },*/
        events: [],
        /* titleFormat: { // will produce something like "Tuesday, September 18, 2018"
          month: 'long',
          year: 'numeric',
          day: 'numeric',
          weekday: 'long'
        }, */
        timeZone: 'local',
        locale: 'es',

      },
      listLoading: false,
      listQuery: {
        page: 1,
        limit: 20,
        importance: undefined,
        name: undefined,
        type: undefined,
        sort: '+id',
      },
      list: null,
      listPersonal: null,
      showReviewer: false,
      dialogFormVisible: false,
      dialogStatus: '',
      optionsPersonal: [],
      optionsClient: [],
      optionsPet: [],
      textMap: {
        update: 'Editar',
        create: 'Crear',
      },
      rules: {
        title: [{ required: true, message: 'type is required', trigger: 'change' }],
        registration_date: [{ required: true, message: 'type is required', trigger: 'change' }],
        hours: [{ required: true, message: 'type is required', trigger: 'change' }],
        client_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        pet_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        description: [{ required: true, message: 'type is required', trigger: 'change' }],
        personal_id: [{ required: true, message: 'type is required', trigger: 'change' },
        /* {validator: validateCita, trigger:['blur', 'change'] }*/],
      },
      temp: {
        id: undefined,
        description: '',
        personal_id: '',
        pet_id: '',
        client_id: '',
        registration_date: '',
        hours: '',
        horaFin: '',
        end: '',
      },
      razon: [
        {
          value: 'Consulta',
          label: 'Consulta',
        },
        {
          value: 'Peluqueria',
          label: 'Peluquería',
        },
        {
          value: 'Cirugia',
          label: 'Cirugía',
        },
        {
          value: 'Vacunacion',
          label: 'Vacunación',
        },
        {
          value: 'Examenes',
          label: 'Examenes',
        },
        {
          value: 'Desparasitacion',
          label: 'Desparasitación',
        },
      ],
      duracion: [
        {
          value: '900',
          label: '15 minutos',
        },
        {
          value: '1800',
          label: '30 minutos',
        },
        {
          value: '3600',
          label: '1 hora',
        },
        {
          value: '5400',
          label: '1 hora y 30 minutos',
        },
        {
          value: '7200',
          label: '2 horas',
        },
        {
          value: '10800',
          label: '3 horas',
        },
      ],
    };
  },
  created() {
    this.getList();
    this.getListPersonal();
    this.getListClient();
    this.getListPet();
  },
  /* mounted() {
    this.getEvents();
  },*/
  methods: {
    handleDateClick: function(arg) {
      this.handleCreate();
      // let dateAndTime = arg.dateStr.split('T');
      this.temp.registration_date = arg.date;
      this.temp.hours = arg.date;
      this.temp.fechaEntera = arg.dateStr;
      // this.getEvents();
      // alert('date click! ' + arg.dateStr);
    },
    getEvents(){
      console.log('en el evento');
      console.log(this.list);
      this.calendarOptions.events = [{ title: this.list.description, start: this.list.fechaEntera, end: this.list.horafin }];
      // this.calendarOptions.remove();
    },
    toggleWeekends: function() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
    },
    agendamiento: function(){
      console.log(this.calendarOptions.headerToolbar);
      console.log(this.calendarOptions.initialView);
      // console.log(this.$refs.fullCalendar.$el);
      // this.$refs.fullCalendar.initialView = "timeGridWeek";
      // $('.fc-timeGridWeek-button').click();
      // $(".fc-timeGridWeek-button").get(0).click();
      // document.querySelectorAll(".fc-timeGridWeek-button").click();
    },
    /* handleDateSelect(selectInfo) {
      const title = prompt('Please enter a new title for your event');
      const calendarApi = this.$refs.fullCalendar.getApi();
      calendarApi.remove(); // clear date selection
      if (title) {
        calendarApi.addEvent({
          title,
          start: selectInfo.startStr,
          end: selectInfo.endStr,
          allDay: selectInfo.allDay,
        });
      }
    },*/
    /* handleEventClick(clickInfo) {
      if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
        clickInfo.event.remove();
      }
      console.log(clickInfo);
    },*/
    /* handleEvents(events) {
      this.currentEvents = events;
    },*/ // metodo de listar agendamiento de citas
    async getList() {
      this.listLoading = true;
      const { data } = await fetchList();
      const calendarApi = this.$refs.fullCalendar.getApi();
      this.list = data.items;
      // Just to simulate the time of the request
      this.listLoading = false;
      Object.entries(this.list).forEach(([key, value]) => {
        if (value.description) {
          const hora = value.hours.split(':');
          const fecha = value.registration_date.split('-');
          this.list.fechaEntera = new Date(value.registration_date + ' ' + value.hours);
          this.list.horafin = new Date(value.end);
          console.log(this.list.fechaEntera);
          console.log(this.list.horafin);
          // ya estaban comentadas----------------------
          // `${fecha[0]}-${fecha[1]}-${fecha[2]}T${hora[0]}:${hora[1]}:${hora[2]}-05:00`;
          // new Date(fecha[0], fecha[1], fecha[2], hora[0], hora[1], hora[2]);
          // termina aqui las lineas que ya estaban comentadas
          /* const fechaAgenda = `${fecha[0]}-${fecha[1]}-${fecha[2]}T${hora[0]}:${hora[1]}:${hora[2]}-05:00`;
          const fechaAgenda1 = `${fecha[0]}-${fecha[1]}-${fecha[2]}T${hora[0]}:30:${hora[2]}-05:00`;
          calendarApi.addEvent({
            title: value.description,
            start: fechaAgenda,
            end: fechaAgenda1,
            allDay: true,
          });*/
          this.getEvents();
        }
      });
    },
    async getListPersonal() {
      this.listLoading = true;
      const { data } = await ListPersonal();

      for (var i in data.items) {
        this.optionsPersonal.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('medicos', this.optionsPersonal);
    },
    async getListClient() {
      this.listLoading = true;
      const { data } = await ListClient();

      for (var i in data.items) {
        this.optionsClient.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('cliente', this.optionsClient);
    },
    async getListPet() {
      this.listLoading = true;
      const { data } = await ListPet(this.temp);
      this.optionsPet = [];
      for (var i in data.items) {
        this.optionsPet.push({ value: data.items[i].id, label: data.items[i].name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('pet', this.optionsPet);
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        personal_id: '',
        pet_id: '',
        client_id: '',
        description: '',
        registration_date: '',
        hours: '',
        horaFin: '',
        end: '',
      };
    },
    handleCreate() {
      this.resetTemp();
      this.dialogStatus = 'create';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          // esto añadí----------------
          const initSession = this.temp.registration_date;
          const getSecondSession = initSession.getSeconds() + this.temp.end;
          initSession.setSeconds(getSecondSession);
          this.temp.horafin = initSession;
          console.log('hora fin', this.temp.horafin);
          // fin de lo que añadi-------------
          const splitHoras = this.temp;
          const arrayHoras = splitHoras.registration_date.toLocaleDateString().split('/');
          // this.temp.id = this.list[this.list.length - 1].id + 1;
          this.temp.status = 1;
          this.temp.hours = splitHoras.hours.toLocaleTimeString();
          this.temp.registration_date = `${arrayHoras[2]}-${arrayHoras[1]}-${arrayHoras[0]}`;
          /* createCita(this.temp).then((response) => {
            this.dialogFormVisible = false;
            this.$router.go(0);
            this.getList();
            this.$message({
              message: 'Se agendo la cita' + this.temp.description + '(' + this.temp.registration_date + ' ' + this.temp.hours + ') correctamento.',
              type: 'success',
              duration: 5 * 1000,
            });
          });*/
        }
      });
    },
    fechaMes(mes){
      if (mes <= 9 && mes >= 1){
        return '0' + mes;
      } else {
        return mes;
      }
    },
  },
};
</script>

