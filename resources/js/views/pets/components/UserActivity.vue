<template>
  <el-card v-if="user.nombre_cliente">
    <router-link class="el-button el-button--primary el-button--small" to="/mascotas/list">
      <i class="el-icon-back" />
    </router-link>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Datos del paciente" name="first">
        <div class="user-activity">
          <div class="dndList" style="padding:20px;">
            <div style="width:50%;" class="dndList-list">
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">Historial Clínico</span>
                <span style="padding-left:10px;display:block; color:#566573;">#000{{ user.id }}</span>
              </div>
              <br><br>
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">Especie</span>
                <span style="padding-left:10px;display:block; color:#566573;">{{ user.specie }}</span>
              </div>
              <br><br>
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">Raza</span>
                <span style="padding-left:10px;display:block; color:#566573;">{{ user.breed }}</span>
              </div>
              <br><br>
              <div style="border-left:4px solid #42b983;">
                <span style="padding-left:10px;">¿Está castrado?</span>
                <span style="padding-left:10px;display:block; color:#566573;">{{ user.castrated }}</span>
              </div>
            </div>
            <div style="width:40%;" class="dndList-list">

              <div class="dndList-list">
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Edad</span>
                  <span style="padding-left:10px;display:block;color:#566573;">{{ user.age }}</span>
                </div>
                <br><br>
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Peso</span>
                  <span style="padding-left:10px;display:block;color:#566573;">{{ user.weight }} Kg</span>
                </div>
                <br><br>
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Color</span>
                  <span style="padding-left:10px;display:block;color:#566573;">{{ user.color }}</span>
                </div>
                <br><br>
                <div style="border-left:4px solid #42b983;">
                  <span style="padding-left:10px;">Nivel de agresividad (0 a 5)</span>
                  <span style="padding-left:10px;display:block;color:#566573;">{{ user.aggressiveness }}</span>
                </div>
              </div>
              <br><br>

            </div>
          </div>

        </div>
      </el-tab-pane>
      <el-tab-pane label="Historial Clínico" name="second">
        <div class="user-activity">
          <div slot="header" class="clearfix">

            <span>Resultados</span>

            <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" :to="'/mascotas/visit/new/'+ user.id"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>
          </div>
          <br>
          <el-table
            :key="0"
            v-loading="listLoading"
            :data="historial"
            border
            fit
            highlight-current-row
            style="width: 100%"
            @sort-change="sortChange"
          >

            <el-table-column
              label="Fecha"
              prop="fecha"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.date | parseTime('{y}-{m}-{d}') }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Motivo"
              prop="reason"
              align="center"
              min-width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.reason }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Veterinario"
              prop="nombre_veterinario"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.nombre_veterinario }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Acciones" align="center" width="250" class-name="small-padding fixed-width">
              <template slot-scope="{row}">
                <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
                <el-button type="danger" icon="el-icon-delete-solid" size="small" @click="handleModifyStatus(row, 0)" />
              </template>
            </el-table-column>

          </el-table>
          <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
            <el-form ref="dataForm1" :rules="rules1" :model="form" label-position="left" label-width="180px" style="width: 500px; margin-left:50px;">
              <el-form-item label="Fecha">
                <el-date-picker v-model="form.date" type="datetime" placeholder="ingrese fecha" disabled />
              </el-form-item>
              <el-form-item label="Nombre Cliente" prop="client_id">
                <el-select v-model="form.client_id" placeholder="Seleccione cliente..." disabled @input="getListClient">
                  <el-option
                    v-for="(item, index) in optionsClient"
                    :key="'B'+index"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Nombre mascota" prop="name">
                <el-input v-model="form.name" type="text" style="width: 100%;" disabled />
              </el-form-item>
              <el-form-item label="Motivo de visita" prop="reason">
                <el-input v-model="form.reason" type="textarea" style="width: 100%;" />
              </el-form-item>
              <el-form-item label="Anamnesis" prop="anamnesis">
                <el-input v-model="form.anamnesis" type="textarea" />
              </el-form-item>
              <el-form-item label="Diagnostivo" prop="diagnostic">
                <el-input v-model="form.diagnostic" type="textarea" />
              </el-form-item>
              <el-form-item label="Patologia" prop="pathology">
                <el-input v-model="form.pathology" type="textarea" />
              </el-form-item>
              <el-form-item label="Tratamiento" prop="treatment">
                <el-input v-model="form.treatment" type="textarea" />
              </el-form-item>
              <el-form-item label="Prescripcion" prop="prescription">
                <el-input v-model="form.prescription" type="textarea" />
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
        </div>
      </el-tab-pane>
      <el-tab-pane label="Vacunas" name="third">
        <div class="block">
          <div slot="header" class="clearfix">

            <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" :to="'/servicio/vaccine/create/'+user.id"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>

          </div>
          <el-timeline>
            <el-timeline-item v-for="(item, index) in vaccine" :key="'D'+index" :timestamp="item.date" placement="top">
              <el-card>
                <h4>Nombre vacuna: {{ item.name_vaccines }}</h4>
                <p>{{ item.weight }} Kg - {{ item.vaccine_observation }}</p>
                <el-button type="danger" icon="el-icon-delete" size="small" @click="handleModifyStatus2(item, 0)" />
              </el-card>
              <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible2">
                <el-form ref="dataForm2" :rules="rules2" :model="form1" label-position="left" label-width="180px" style="width: 500px; margin-left:50px;">
                  <el-form-item label="Fecha">
                    <el-date-picker v-model="form1.date" type="datetime" placeholder="ingrese fecha" disabled />
                  </el-form-item>
                  <el-form-item label="Nombre Cliente" prop="client_id">
                    <el-select v-model="form1.client_id" placeholder="Seleccione cliente..." disabled @input="getListClient">
                      <el-option
                        v-for="(item, index) in optionsClient"
                        :key="'B'+index"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-form-item>
                  <el-form-item label="Nombre mascota" prop="name">
                    <el-input v-model="form1.name" type="text" style="width: 100%;" disabled />
                  </el-form-item>
                  <el-form-item label="Tipo Vacuna" prop="vaccines_id">
                    <el-select v-model="form1.vaccines_id" placeholder="Seleccione tipo..." style="width: 100%;">
                      <el-option
                        v-for="(item, index) in optionsVaccine"
                        :key="'cl'+index"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-form-item>

                  <el-form-item label="Detalles">
                    <el-input v-model="form1.vaccine_observation" type="textarea" style="width: 100%;" />
                  </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                  <el-button @click="dialogFormVisible2 = false">
                    {{ $t('table.cancel') }}
                  </el-button>
                  <el-button type="primary" @click="dialogStatus==='create'?createData():updateData2()">
                    {{ $t('table.confirm') }}
                  </el-button>
                </div>
              </el-dialog>
            </el-timeline-item>
          </el-timeline>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Antiparasitarios" name="fourth">
        <div class="block">
          <div slot="header" class="clearfix">

            <router-link type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" :to="'/servicio/antiparasitic/create/'+ user.id"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>

          </div>
          <el-timeline>
            <el-timeline-item v-for="(item, index) in antiparasitic" :key="'E'+index" :timestamp="item.date" placement="top">
              <el-card>
                <h4>Nombre Desparacitante: {{ item.name_antiparasitic }}</h4>
                <p>{{ item.weight }} Kg - {{ item.antiparasitic_observation }}</p>
                <el-button type="danger" icon="el-icon-delete" size="small" @click="handleModifyStatus3(item, 0)" />
              </el-card>
              <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible3">
                <el-form ref="dataForm3" :rules="rules3" :model="form2" label-position="left" label-width="180px" style="width: 500px; margin-left:50px;">
                  <el-form-item label="Fecha">
                    <el-date-picker v-model="form2.date" type="datetime" placeholder="ingrese fecha" disabled />
                  </el-form-item>
                  <el-form-item label="Nombre Cliente" prop="client_id">
                    <el-select v-model="form2.client_id" placeholder="Seleccione cliente..." disabled @input="getListClient">
                      <el-option
                        v-for="(item, index) in optionsClient"
                        :key="'B'+index"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-form-item>
                  <el-form-item label="Nombre mascota" prop="name">
                    <el-input v-model="form2.name" type="text" style="width: 100%;" disabled />
                  </el-form-item>
                  <el-form-item label="Tipo Vacuna" prop="antiparasitic_id">
                    <el-select v-model="form2.antiparasitic_id" placeholder="Seleccione tipo..." style="width: 100%;">
                      <el-option
                        v-for="(item, index) in optionsAntiparasitic"
                        :key="'ckl'+index"
                        :label="item.label"
                        :value="item.value"
                      />
                    </el-select>
                  </el-form-item>

                  <el-form-item label="Detalles">
                    <el-input v-model="form2.antiparasitic_observation" type="textarea" style="width: 100%;" />
                  </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                  <el-button @click="dialogFormVisible3 = false">
                    {{ $t('table.cancel') }}
                  </el-button>
                  <el-button type="primary" @click="dialogStatus==='create'?createData():updateData3()">
                    {{ $t('table.confirm') }}
                  </el-button>
                </div>
              </el-dialog>
            </el-timeline-item>
          </el-timeline>
        </div>
      </el-tab-pane>
      <el-tab-pane label="Estética y baños" name="sixth">
        <div class="user-activity">
          <div slot="header" class="clearfix">
            <span>Resultados</span>
            <router-link type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" :to="'/servicio/peluqueria/create/'+ user.id"><!----><i class="el-icon-plus" /><span>
              Nuevo
            </span></router-link>

          </div>
          <br>
          <el-table
            :key="1"
            v-loading="listLoading"
            :data="peluqueria"
            border
            fit
            highlight-current-row
            style="width: 100%"
            @sort-change="sortChange"
          >

            <el-table-column
              label="Paciente"
              prop="diagnostic"
              align="center"
              width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.diagnostic }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Tipo"
              prop="reason"
              align="center"
              min-width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.reason }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Fecha"
              prop="date"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.date | parseTime('{y}-{m}-{d}') }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Acciones" align="center" width="250" class-name="small-padding fixed-width">
              <template slot-scope="{row}">
                <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate1(row)" />
                <el-button type="danger" icon="el-icon-delete-solid" size="small" @click="handleModifyStatus1(row, 0)" />
              </template>
            </el-table-column>

          </el-table>
          <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible1" style="min-width:100vh;">
            <el-form ref="dataForm" :rules="rules" :model="temp" style="padding:0px 30px;">
              <el-form-item label="Fecha">
                <el-date-picker v-model="temp.date" type="datetime" placeholder="ingrese fecha" disabled style="width: 100%;" />
              </el-form-item>
              <el-form-item label="Nombre Cliente" prop="client_id">
                <el-select v-model="temp.client_id" placeholder="Seleccione cliente..." style="width: 100%;" disabled @input="getListClient">
                  <el-option
                    v-for="(item, index) in optionsClient"
                    :key="'Z'+index"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Nombre mascota" prop="name">
                <el-input v-model="temp.name" type="text" style="width: 100%;" disabled />
              </el-form-item>
              <el-form-item label="Tipo" prop="reason">
                <el-select v-model="temp.reason" placeholder="Seleccione tipo..." style="width: 100%;">
                  <el-option
                    v-for="(item, index) in options"
                    :key="'c'+index"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Diagnostivo" prop="diagnostic">
                <el-input v-model="temp.diagnostic" type="textarea" style="width: 100%;" />
              </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
              <el-button @click="dialogFormVisible1 = false">
                {{ $t('table.cancel') }}
              </el-button>
              <el-button type="primary" @click="dialogStatus==='create'?createData():updateData1()">
                {{ $t('table.confirm') }}
              </el-button>
            </div>
          </el-dialog>
        </div>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import { ListClient, ListVaccine, ListAntiparasitic } from '@/api/appointment';
import { updateHistory } from '@/api/clinic_history';
// import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive
// const userResource = new Resource('users');

export default {
  directives: { waves },
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
    historial: {
      type: Array,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
    vaccine: {
      type: Array,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
    antiparasitic: {
      type: Array,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
    peluqueria: {
      type: Array,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      listLoading: false,
      listLoading1: false,
      dialogFormVisible: false,
      dialogFormVisible1: false,
      dialogFormVisible2: false,
      dialogFormVisible3: false,
      dialogStatus: '',
      carVaccine: '',
      carAntiparasitic: '',
      optionsClient: [],
      optionsPet: [],
      optionsVaccine: [],
      optionsAntiparasitic: [],
      options: [
        {
          value: 'Baño',
          label: 'Baño',
        },
        {
          value: 'Corte',
          label: 'Corte',
        },
        {
          value: 'Limpieza dental',
          label: 'Limpieza dental',
        },
        {
          value: 'Baño Medicado',
          label: 'Baño medicado',
        },
        {
          value: 'Baño y corte',
          label: 'Baño y corte',
        },
        {
          value: 'Baño medicado y corte',
          label: 'Baño medicado y corte',
        }],

      rules: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      rules1: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      rules2: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      rules3: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      textMap: {
        update: 'Editar',
        create: 'Crear',
      },
      form: {
        id: undefined,
        date: '',
        personal_id: '',
        client_id: '',
        pet_id: '',
        reason: '',
        anamnesis: '',
        vaccine_id: '',
        vaccine_observation: '',
        antiparasitic_id: '',
        antiparasitic_observation: '',
        diagnostic: '',
        pathology: '',
        treatment: '',
        prescription: '',

      },
      temp: {
        id: undefined,
        date: '',
        personal_id: '',
        client_id: '',
        pet_id: '',
        reason: '',
        anamnesis: '',
        vaccine_id: '',
        vaccine_observation: '',
        antiparasitic_id: '',
        antiparasitic_observation: '',
        diagnostic: '',
        pathology: '',
        treatment: '',
        prescription: '',

      },
      form1: {},
      form2: {},
      activeActivity: 'first',
      carouselImages: [
        'https://cdn.laravue.dev/photo1.png',
        'https://cdn.laravue.dev/photo2.png',
        'https://cdn.laravue.dev/photo3.jpg',
        'https://cdn.laravue.dev/photo4.jpg',
      ],
      updating: false,
    };
  },
  created() {
    this.getListClient();
    this.getListVaccine();
    this.getListAntiparasitic();
  },
  methods: {
    handleClick(tab, event) {
      console.log('componente vue', tab, event);
      console.log('tab seleccionado ', tab.name);
      console.log('tab seleccionado ', tab.active);
      console.log('tab seleccionado ', tab, event);
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    async getListClient() {
      this.listLoading1 = true;
      const { data } = await ListClient();

      for (const i in data.items) {
        this.optionsClient.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      // console.log(this.optionsClient);
      this.listLoading1 = false;
    },
    // metodo de estetica
    updateData1() {
      console.log(this.$refs['dataForm']);
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          updateHistory(this.temp).then(() => {
            for (const v of this.peluqueria) {
              if (v.id === this.temp.id) {
                const index1 = this.peluqueria.indexOf(v);
                this.peluqueria.splice(index1, 1, this.temp);
                break;
              }
            }
            this.dialogFormVisible1 = false;
            this.$notify({
              title: 'Success',
              message: 'Updated successfully',
              type: 'success',
              duration: 2000,
            });
          });
        }
      });
    },
    // metodo de consulta medica
    updateData() {
      // console.log(this.$refs['dataForm1']);
      this.$refs['dataForm1'].validate((valid) => {
        if (valid) {
          updateHistory(this.form).then(() => {
            for (const v of this.historial) {
              if (v.id === this.form.id) {
                const index = this.historial.indexOf(v);
                this.historial.splice(index, 1, this.form);
                break;
              }
            }
            this.dialogFormVisible = false;
            this.$notify({
              title: 'Success',
              message: 'Updated successfully',
              type: 'success',
              duration: 2000,
            });
          });
        }
      });
    },
    // metodo vacunas
    updateData2() {
      // console.log(this.$refs['dataForm2'][this.carVaccine]);
      this.$refs['dataForm2'][this.carVaccine].validate((valid) => {
        if (valid) {
          updateHistory(this.form1).then(() => {
            for (const v of this.vaccine) {
              if (v.id === this.form1.id) {
                const index1 = this.vaccine.indexOf(v);
                this.vaccine.splice(index1, 1, this.form1);
                break;
              }
            }
            this.dialogFormVisible2 = false;
            this.$notify({
              title: 'Success',
              message: 'Updated successfully',
              type: 'success',
              duration: 2000,
            });
          });
        }
      });
    },
    // metodo desparacitacion
    updateData3() {
      // console.log(this.$refs['dataForm2'][this.carVaccine]);
      this.$refs['dataForm3'][this.carAntiparasitic].validate((valid) => {
        if (valid) {
          updateHistory(this.form2).then(() => {
            for (const v of this.antiparasitic) {
              if (v.id === this.form2.id) {
                const index1 = this.antiparasitic.indexOf(v);
                this.antiparasitic.splice(index1, 1, this.form2);
                break;
              }
            }
            this.dialogFormVisible3 = false;
            this.$notify({
              title: 'Success',
              message: 'Updated successfully',
              type: 'success',
              duration: 2000,
            });
          });
        }
      });
    },
    // estetica y peluqueria
    handleUpdate1(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible1 = true;
    },
    // visita medica
    handleUpdate(row) {
      this.form = Object.assign({}, row); // copy obj
      this.form.timestamp = new Date(this.form.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
    },
    // editar vacunas
    handleUpdate2(row, position) {
      this.form1 = Object.assign({}, row); // copy obj
      this.carVaccine = position;
      this.form1.timestamp = new Date(this.form1.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible2 = true;
    },
    // editar desparasitante
    handleUpdate3(row, position) {
      this.form2 = Object.assign({}, row); // copy obj
      this.carAntiparasitic = position;
      this.form2.timestamp = new Date(this.form2.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible3 = true;
    },
    async getListVaccine() {
      this.listLoading = true;
      const { data } = await ListVaccine();

      for (const i in data.items) {
        this.optionsVaccine.push({ value: data.items[i].id, label: data.items[i].name_vaccines });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('cliente', this.optionsVaccine);
    },
    async getListAntiparasitic() {
      this.listLoading = true;
      const { data } = await ListAntiparasitic();

      for (var i in data.items) {
        this.optionsAntiparasitic.push({ value: data.items[i].id, label: data.items[i].name_antiparasitic });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('desparacitante', this.optionsAntiparasitic);
    },
    async handleModifyStatus(row, status) {
      this.listLoading = true;
      row.status = status;
      await updateHistory(row);
      this.$router.go(0);

      this.$message({
        message: 'Successful operation',
        type: 'success',
      });
      this.listLoading = false;
    },
    async handleModifyStatus1(row, status) {
      this.listLoading = true;
      row.status = status;
      await updateHistory(row);
      this.$router.go(0);
      this.$message({
        message: 'Successful operation',
        type: 'success',
      });
      this.listLoading = false;
    },
    async handleModifyStatus2(row, status) {
      this.listLoading = true;
      row.status = status;
      await updateHistory(row);
      this.$router.go(0);
      this.$message({
        message: 'Successful operation',
        type: 'success',
      });
      this.listLoading = false;
    },
    async handleModifyStatus3(row, status) {
      this.listLoading = true;
      row.status = status;
      await updateHistory(row);
      this.$router.go(0);
      this.$message({
        message: 'Successful operation',
        type: 'success',
      });
      this.listLoading = false;
    },
  },
};
</script>

<style lang="scss" scoped>
.user-activity {
  .user-block {
    .username, .description {
      display: block;
      margin-left: 50px;
      padding: 2px 0;
    }
    img {
      width: 40px;
      height: 40px;
      float: left;
    }
    :after {
      clear: both;
    }
    .img-circle {
      border-radius: 50%;
      border: 2px solid #d2d6de;
      padding: 2px;
    }
    span {
      font-weight: 500;
      font-size: 12px;
    }
  }
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;
    .image {
      width: 100%;
    }
    .user-images {
      padding-top: 20px;
    }
  }
  .list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
    li {
      display: inline-block;
      padding-right: 5px;
      padding-left: 5px;
      font-size: 13px;
    }
    .link-black {
      &:hover, &:focus {
        color: #999;
      }
    }
  }
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
  }
}
.dndList {
  background: #fff;
  padding-bottom: 40px;
  &:after {
    content: "";
    display: table;
    clear: both;
  }
  .dndList-list {
    float: left;

    &:first-of-type {
      margin-right: 2%;
    }
    .dragArea {
      margin-top: 15px;
      min-height: 50px;
      padding-bottom: 30px;
    }
  }
}
</style>
