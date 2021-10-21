<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Agendar Citas</span>
        </div>
        <!-- <el-button type="primary" icon="el-icon-plus" @click="toggleWeekends">todos los dias</el-button> -->
        <!--el-button type="primary" icon="el-icon-plus" @click="agendamiento">Nueva Cita</el-button-->
        <br>
        <br>
        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" style="min-width:100vh;">
          <el-form ref="dataForm" :rules="rules" :model="temp" style="padding:0px 30px;">
            <el-form-item label="Fecha/Hora de cita" prop="registration_date">
              <el-col :span="11" style="width: 100%;">
                <el-date-picker v-model="temp.registration_date" type="date" placeholder="Seleccione Fecha" style="width: 100%;" disabled/>
              </el-col>
              <el-col :span="11" style="width: 100%;">
                <el-time-picker v-model="temp.hours" type="time" placeholder="Seleccione hora" style="width: 100%;" disabled/>
              </el-col>
            </el-form-item>
            <el-form-item label="Titulo de cita" prop="description">
              <el-select v-model="temp.description" placeholder="Razón de la visita" style="width: 100%;">
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
            <el-button type="primary" :disabled="validacionCita" @click="dialogStatus==='create'?createData():updateData()">
              {{ $t('table.confirm') }}
            </el-button>
          </div>
        </el-dialog>
        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible1" style="min-width:100vh;">
          <el-form ref="dataForm1" :rules="rules" :model="detail" style="padding:0px 30px;">
            <el-form-item label="Fecha/Hora de cita" prop="registration_date">
              <el-col :span="11" style="width: 100%;">
                <el-date-picker v-model="detail.registration_date" type="date" placeholder="Seleccione Fecha" style="width: 100%;" disabled/>
              </el-col>
              <el-col :span="1" style="width: 15%;">
                Desde:
              </el-col>
              <el-col :span="5" style="width: 85%;">
                <el-time-picker v-model="detail.hours" type="time" placeholder="Seleccione hora" style="width: 100%;" disabled/>
              </el-col>
              <el-col :span="1" style="width: 15%;">
                Hasta:
              </el-col>
              <el-col :span="5" style="width: 85%;">
                <el-time-picker v-model="detail.end" type="time" placeholder="Seleccione hora" style="width: 100%;" disabled/>
              </el-col>
            </el-form-item>
            <el-form-item label="Titulo de cita" prop="description">
              <el-select v-model="detail.description" placeholder="Razón de la visita" style="width: 100%;" disabled>
                <el-option
                  v-for="item in razon"
                  :key="'1'+item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Veterinario" prop="personal_id">
              <el-select v-model="detail.personal_id" placeholder="Veterinario" style="width: 100%;" disabled>
                <el-option
                  v-for="item in optionsPersonal"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Cliente" prop="client_id">
              <el-select v-model="detail.client_id" placeholder="Seleccione un cliente" style="width: 100%;" @input="getListPet" disabled>
                <el-option
                  v-for="item in optionsClient"
                  :key="'ll'+item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Mascota" prop="pet_id">
              <el-select v-model="detail.pet_id" placeholder="Seleccione un mascota" style="width: 100%;" disabled>
                <el-option
                  v-for="item in optionListPet"
                  :key="'kk'+item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

          </el-form>
          <div slot="footer" class="dialog-footer">
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
import { fetchList, createCita, ListPersonal, ListClient, ListPet, fetchListPet } from '@/api/appointment';
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
        //-------------------------------validaciones actuales
        const dateStringArray = this.temp.registration_date.toLocaleDateString().split('/');
        const inicioHora = new Date(this.temp.registration_date);
        const obtenerSegundos = inicioHora.getSeconds() + this.temp.end;
        inicioHora.setSeconds(obtenerSegundos);
        const fechaVal = dateStringArray[2] + '-' + this.fechaMes(dateStringArray[1]) + '-' + this.fechaMes(dateStringArray[0]);
        const timeString = this.temp.hours.toLocaleTimeString();
        const objDate = new Date(fechaVal +' '+ timeString);
        //----------------------------------------------------
        //console.log(value);
        // let formatomes = this.fechaMes(dateStringArray[1]);
        // console.log('formato mes', formatomes);
        //console.log('dateString', fechaVal);
        //console.log('timeString', timeString);
        //console.log('segundos al terminar la cita de temp',inicioHora);
        //console.log('segundos al comenzar la cita de temp',objDate);
        let valida = false;
        if (value >= 1 && fechaVal != '' && timeString != '') {
          Object.entries(this.list).forEach(([key, valor]) => {
            const initSession = new Date(valor.registration_date +' '+ valor.hours);
            const fechaFin = new Date (valor.end);
            //console.log(valor.end);
            //console.log('----------------------------------------------------------------');
            //console.log(objDate.getTime() > initSession.getTime(), 'fecha a registrar ' + objDate.getTime(), ' fecha registrada ' + initSession.getTime());
            //console.log(objDate.getTime() < valor.end.getTime(), ' fecha a registrar ' + objDate.getTime(), ' fecha registrada ' + valor.end.getTime());
            //console.log('----------------------------------------------------------------');
            if (
              value == valor.personal_id &&
              (fechaVal == valor.registration_date &&
              timeString == valor.hours)
            )
             {
               //console.log('No se puede registrar la cita Ya existe una cita con los mismos datos ');
              this.$notify({
                title: 'No se puede registrar la cita',
                message: 'Ya existe una cita con los mismos datos',
                type: 'error',
                duration: 3000,
              });
              valida = true;
            }else if (value == valor.personal_id && (objDate.getTime() > initSession.getTime() && objDate.getTime() < fechaFin.getTime())){
              //console.log('No se puede registrar la cita El horario no esta disponible ');
              this.$notify({
                title: 'No se puede registrar la cita',
                message: 'El horario no esta disponible',
                type: 'error',
                duration: 3000,
              });
              valida = true;
            }else{
              callback();
            }
          });
        } else {
          //console.log('es valido');
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
        initialView: 'timeGridWeek',
        dateClick: this.handleDateClick,
        editable: true,
        weekends: false, // initial value
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
        slotMinTime: '09:00:00',
        slotMaxTime: '19:00:00',
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
      dialogFormVisible1: false,
      dialogStatus: '',
      optionsPersonal: [],
      optionsClient: [],
      optionsPet: [],
      optionListPet: [],
      presentarMensaje : false,
      validacionCita: false,
      textMap: {
        update: 'Editar',
        create: 'Crear',
        visualizar: 'Detalles Cita'
      },
      rules: {
        title: [{ required: true, message: 'type is required', trigger: 'change' }],
        registration_date: [{ required: true, message: 'type is required', trigger: 'change' }],
        hours: [{ required: true, message: 'type is required', trigger: 'change' }],
        client_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        pet_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        description: [{ required: true, message: 'type is required', trigger: 'change' }],
        personal_id: [{ required: true, message: 'type is required', trigger: 'change' },
         {validator: validateCita, trigger:['blur', 'change'] }],
      },
      temp: {
        id: undefined,
        description: '',
        personal_id: '',
        pet_id: '',
        client_id: '',
        registration_date: '',
        hours: '',
        horaInicio: '',
        horaFin: '',
        fechaEntera: '',
        end: '',
      },
      detail: {
        id: undefined,
        description: '',
        personal_id: '',
        pet_id: '',
        client_id: '',
        registration_date: '',
        hours: '',
        horaInicio: '',
        horaFin: '',
        fechaEntera: '',
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
    this.getListAllPet();
  },
  mounted() {
    
  },
  methods: {
    handleDateClick: function(arg) {
      //console.log('desde el evento click',arg.date.toLocaleTimeString());
      //console.log(arg);
      let today = new Date().getTime();
      if (arg.date.toLocaleTimeString() === "0:00:00"){
        this.$notify({
              title: 'No puede elegir la hora que esta seleccionando',
              message: 'Elegir un horario correspondiente de 09:00 a 19:00',
              type: 'error',
              duration: 8000,
            });
            this.presentarMensaje = true;
      }else if(arg.date.getTime() < today){
        this.$notify({
              title: 'No puede elegir la fecha que esta seleccionando',
              message: 'Elegir una fecha válida',
              type: 'error',
              duration: 8000,
            });
            this.presentarMensaje = true;
      }else {
        this.handleCreate();
        this.temp.registration_date = arg.date;
        this.temp.hours = arg.date;
        this.temp.fechaEntera = arg.dateStr;
      }
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    toggleWeekends: function() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
    },
    /*tiempoAproximado(){
      this.temp.reason = this.temp.description; 
      if (this.dialogStatus === 'create'){
        if (this.temp.reason === "Consulta"){
          this.temp.end = 1800;
        }

      }
      console.log(this.temp.reason);
    },*/
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
    handleEventClick(clickInfo) {
      /*if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
        clickInfo.event.remove();
      }*/
      this.handleView(clickInfo.event.extendedProps);
    },
    /* handleEvents(events) {
      this.currentEvents = events;
    },*/ // metodo de listar agendamiento de citas
    async getList() {
      const { limit, page } = this.listQuery;
      this.listLoading = true;
      const { data } = await fetchList(this.listQuery);
      const calendarApi = this.$refs.fullCalendar.getApi();
      const calendario = this.$refs.fullCalendar;
      this.list = data.items;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      // Just to simulate the time of the request
      this.listLoading = false;
      Object.entries(this.list).forEach(([key, value]) => {
        if (value.description) {
          //const hora = value.hours.split(':');
          //const fecha = value.registration_date.split('-');
          const fechafinn = value.end.split(' ');
          //this.list.fechaEntera = value.registration_date + 'T' + value.hours +'-05:00';
          //this.list.horafin = fechafinn[0]+'T'+fechafinn[1]+'-05:00';
          //console.log(value.fechaEntera);
          //console.log(value.horafin);
          //console.log(value.personal_id);
          let background = this.colorCitas(value.personal_id);
          // ya estaban comentadas----------------------
          calendarApi.addEvent({
            id: value.id,
            backgroundColor: background,
            borderColor: background,
            title: value.description,
            start: value.fechaEntera,
            end: value.horafin,
            allDay: false,
            extendedProps: {
              registration_date: value.registration_date,
              hours: value.hours,
              end: value.end,
              pet_id: value.pet_id,
              client_id: value.client_id,
              personal_id: value.personal_id,
              description: value.description,
            }
          });
        }
      });
      //this.getEvents();
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
    async getListAllPet() {
      this.listLoading = true;
      const { data } = await fetchListPet();
      this.optionListPet = [];
      for (var i in data.items) {
        this.optionListPet.push({ value: data.items[i].id, label: data.items[i].name });
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
        horaInicio: '',
        horaFin: '',
        fechaEntera: '',
        end: '',
      };
    },
    resetTemp1() {
      this.detail = {
        id: undefined,
        personal_id: '',
        pet_id: '',
        client_id: '',
        description: '',
        registration_date: '',
        hours: '',
        horaInicio: '',
        horaFin: '',
        fechaEntera: '',
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
    handleView(row) {
      this.resetTemp1();
      this.detail = Object.assign({}, row); // copy obj
      this.detail.timestamp = new Date(this.detail.timestamp);
      this.detail.fechaEntera = new Date(this.detail.registration_date+' '+this.detail.hours);
      this.detail.hours = this.detail.fechaEntera;
      this.detail.registration_date = this.detail.fechaEntera;
      this.dialogStatus = 'visualizar';
      this.dialogFormVisible1 = true;
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          // esto añadí----------------
          const initSession = new Date(this.temp.registration_date);
          const getSecondSession = initSession.getSeconds() + this.temp.end;
          initSession.setSeconds(getSecondSession);
          this.temp.horaFin = initSession;
          const arrayFechaInicio = this.temp.fechaEntera.split('T');
          const arrayFechaFin = new Date(this.temp.horaFin).toLocaleDateString().split('/');
          this.temp.horaInicio = this.temp.registration_date;
          this.temp.fechaFin = `${arrayFechaFin[2]}-${arrayFechaFin[1]}-${arrayFechaFin[0]} ${this.temp.horaFin.toLocaleTimeString()}`;
          // fin de lo que añadi-------------
          this.temp.id = this.list[this.list.length - 1].id + 1;
          this.temp.status = 1;
          this.temp.status_button = 0;
          this.temp.hours = this.temp.registration_date.toLocaleTimeString();
          this.temp.registration_date = arrayFechaInicio[0];
          createCita(this.temp).then((response) => {
            this.dialogFormVisible = false;
            this.$router.go(0);
            this.getList();
            this.$message({
              message: 'Se agendo la cita' + this.temp.description + '(' + this.temp.registration_date + ' ' + this.temp.hours + ') correctamento.',
              type: 'success',
              duration: 5 * 1000,
            });
            //this.handleFilter();
          });
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
    colorCitas(personal_id){
        switch(personal_id){
            case 1: return '#008B8B'; break;
            case 2: return '#CD5C5C'; break;
            case 3: return '#F4A460'; break;
            case 4: return '#9370D8'; break; 
            case 5: return '#F5DEB3'; break; 
        }
    }
  },
};
</script>