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
import {
  fetchList,
  createCita,
  ListPersonal,
  ListClient,
  ListPet,
} from '@/api/appointment';
// import Pagination from '@/components/Pagination';
// import { sliceEvents, createPlugin } from '@fullcalendar/core';

export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
    // Pagination,
  },
  directives: { waves },
  data() {
    var validateCita = (rule, value, callback) => {
      const dateStringArray = this.temp.registration_date.toLocaleDateString().split('/');
      const fechaVal = dateStringArray[2] + '-' + this.fechaMes(dateStringArray[1]) + '-' + this.fechaMes(dateStringArray[0]);
      const timeString = this.temp.hours.toLocaleTimeString();
      // let formatomes = this.fechaMes(dateStringArray[1]);
      // console.log('formato mes', formatomes);
      console.log('dateString', fechaVal);
      console.log('timeString', timeString);

      console.log(value);
      let valida = false;
      if (value >= 1 && fechaVal != '' && timeString != '') {
        Object.entries(this.list).forEach(([key, valor]) => {
          if (
            value == valor.personal_id &&
            fechaVal == valor.registration_date &&
            timeString == valor.hours
          ) {
            console.log(
              'No se puede registrar la cita',
              valor.registration_date
            );

            this.$notify({
              title: 'No se puede registrar la cita',
              message: 'Ya existe una cita con los mismos datos',
              type: 'error',
              duration: 3000,
            });
            valida = true;
          }
        });
      } else {
        console.log('es valido');
      }
      if (valida) {
        this.validacionCita = true;
      } else {
        this.validacionCita = false;
      }
    };
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
        initialView: 'dayGridMonth',
        dateClick: this.handleDateClick,
        editable: true,
        weekends: true, // initial value
        selectable: true,
        // initialEvents: INITIAL_EVENTS,
        selectMirror: true,
        dayMaxEvents: true,
        select: this.handleDateSelect,
        eventClick: this.handleEventClick,
        eventsSet: this.handleEvents,
        /* headerToolbar: {
          left: 'prev,next today',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },*/
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
        currentEvents: [],
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
        title: [
          { required: true, message: 'type is required', trigger: 'change' },
        ],
        registration_date: [
          { required: true, message: 'type is required', trigger: 'change' },
        ],
        hours: [
          { required: true, message: 'type is required', trigger: 'change' },
        ],
        client_id: [
          { required: true, message: 'type is required', trigger: 'change' },
        ],
        pet_id: [
          { required: true, message: 'type is required', trigger: 'change' },
        ],
        description: [
          { required: true, message: 'type is required', trigger: 'change' },
        ],
        personal_id: [
          { required: true, message: 'type is required', trigger: 'change' },
          { validator: validateCita, trigger: ['blur', 'change'] },
        ],
      },
      temp: {
        id: undefined,
        description: '',
        personal_id: '',
        pet_id: '',
        client_id: '',
        registration_date: '',
        hours: '',
      },
      validacionCita: false,
    };
  },
  created() {
    this.getList();
    this.getListPersonal();
    this.getListClient();
    // this.getListPet();
  },
  methods: {
    handleDateClick: function (arg) {
      /* console.log(arg);
      console.log(arg.date);*/
      // alert('date click! ' + arg.dateStr);
    },
    toggleWeekends: function () {
      this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
    },
    agendamiento: function () {},
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
    },*/
    handleEvents(events) {
      this.currentEvents = events;
    }, // metodo de listar agendamiento de citas
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
          // `${fecha[0]}-${fecha[1]}-${fecha[2]}T${hora[0]}:${hora[1]}:${hora[2]}-05:00`;
          // momentTz.tz("2018-06-14 13:51:00", "UTC").format();
          // new Date(fecha[0], fecha[1], fecha[2], hora[0], hora[1], hora[2]);
          const fechaAgenda = `${fecha[0]}-${fecha[1]}-${fecha[2]}T${hora[0]}:${hora[1]}:${hora[2]}-05:00`;
          const fechaAgenda1 = `${fecha[0]}-${fecha[1]}-${fecha[2]}T${hora[0]}:30:${hora[2]}-05:00`;
          calendarApi.addEvent({
            title: value.description,
            start: fechaAgenda,
            end: fechaAgenda1,
            allDay: true,
          });
        }
      });
    },
    async getListPersonal() {
      this.listLoading = true;
      const { data } = await ListPersonal();

      for (var i in data.items) {
        this.optionsPersonal.push({
          value: data.items[i].id,
          label: data.items[i].first_name + ' ' + data.items[i].last_name,
        });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('medicos', this.optionsPersonal);
    },
    async getListClient() {
      this.listLoading = true;
      const { data } = await ListClient();

      for (var i in data.items) {
        this.optionsClient.push({
          value: data.items[i].id,
          label: data.items[i].first_name + ' ' + data.items[i].last_name,
        });
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
        this.optionsPet.push({
          value: data.items[i].id,
          label: data.items[i].name,
        });
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
          const splitHoras = this.temp;
          const arrayHoras = splitHoras.registration_date
            .toLocaleDateString()
            .split('/');
          this.temp.id = this.list[this.list.length - 1].id + 1;
          this.temp.status = 1;
          this.temp.hours = splitHoras.hours.toLocaleTimeString();
          this.temp.registration_date = `${arrayHoras[2]}-${arrayHoras[1]}-${arrayHoras[0]}`;
          createCita(this.temp).then((response) => {
            this.dialogFormVisible = false;
            this.$router.go(0);
            this.getList();
            this.$message({
              message:
                'Se agendo la cita' +
                this.temp.description +
                '(' +
                this.temp.registration_date +
                ' ' +
                this.temp.hours +
                ') correctamento.',
              type: 'success',
              duration: 5 * 1000,
            });
          });
        }
      });
    },
    fechaMes(mes) {
      if (mes <= 9 && mes >= 1) {
        return '0' + mes;
      } else {
        return mes;
      }
    },
  },
};
</script>
<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Agendar Citas</span>
        </div>
        <!-- <el-button type="primary" icon="el-icon-plus" @click="toggleWeekends">todos los dias</el-button> -->
        <el-button type="primary" icon="el-icon-plus" @click="handleCreate"
          >Nueva Cita</el-button
        >
        <br />
        <br />
        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
        <el-dialog
          :title="textMap[dialogStatus]"
          :visible.sync="dialogFormVisible"
          style="min-width: 100vh"
        >
          <el-form
            ref="dataForm"
            :rules="rules"
            :model="temp"
            style="padding: 0px 30px"
          >
            <el-form-item label="Fecha/Hora de cita" prop="registration_date">
              <el-col :span="11" style="width: 100%">
                <el-date-picker
                  v-model="temp.registration_date"
                  type="date"
                  placeholder="Seleccione Fecha"
                  style="width: 100%"
                />
              </el-col>
              <el-col :span="11" style="width: 100%">
                <el-time-picker
                  v-model="temp.hours"
                  type="fixed-time"
                  placeholder="Seleccione hora"
                  style="width: 100%"
                />
              </el-col>
            </el-form-item>
            <el-form-item label="Titulo de cita" prop="description">
              <el-input v-model="temp.description" style="width: 100%" />
            </el-form-item>
            <el-form-item label="Veterinario" prop="personal_id">
              <el-select
                v-model="temp.personal_id"
                placeholder="Veterinario"
                style="width: 100%"
              >
                <el-option
                  v-for="item in optionsPersonal"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Cliente" prop="client_id">
              <el-select
                v-model="temp.client_id"
                placeholder="Seleccione un cliente"
                @input="getListPet"
                style="width: 100%"
              >
                <el-option
                  v-for="item in optionsClient"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Mascota" prop="pet_id">
              <el-select
                v-model="temp.pet_id"
                placeholder="Seleccione un mascota"
                style="width: 100%"
              >
                <el-option
                  v-for="item in optionsPet"
                  :key="item.value"
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
            <el-button
              type="primary"
              :disabled="validacionCita"
              @click="dialogStatus === 'create' ? createData() : updateData()"
            >
              {{ $t('table.confirm') }}
            </el-button>
          </div>
        </el-dialog>
      </el-card>
    </el-row>
  </div>
</template>
