<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Listado de Citas</span>
          <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" to="/agenda/citas"><!----><i class="el-icon-plus" /><span>
            Nuevo
          </span></router-link>
        </div>
        <div style="margin-bottom: 50px">
          <div class="filter-container">
            <el-input
              v-model="listQuery.name"
              placeholder="Nombre"
              style="width: 200px"
              class="filter-item"
              @keyup.enter.native="handleFilter"
            />

            <el-button
              v-waves
              class="filter-item"
              type="primary"
              icon="el-icon-search"
              @click="handleFilter"
            >
              {{ $t('table.search') }}
            </el-button>
          </div>
        </div>
        <el-table
          :key="tableKey"
          v-loading="listLoading"
          :data="list"
          border
          fit
          highlight-current-row
          style="width: 100%"
          @sort-change="sortChange"
        >
          <el-table-column
            label="Fecha"
            prop="registration_date"
            align="center"
            width="130px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.registration_date }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Hora"
            prop="hours"
            align="center"
            width="130px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.hours }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Titulo"
            prop="description"
            align="center"
            min-width="180px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.description }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Mascota"
            prop="pet_id"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.name }}</span>
            </template>
          </el-table-column>

          <el-table-column label="Estado" class-name="status-col" width="100">
            <template slot-scope="{row}">
              <div v-if="row.status == 1">
                <el-tag type="success" class="tag-item el-tag el-tag--medium el-tag--light">
                  <i class="el-icon-open" /> Activo
                </el-tag>
              </div>
              <div v-else>
                <el-tag type="danger">
                  <i class="el-icon-turn-off" /> Inactivo
                </el-tag>
              </div>
            </template>
          </el-table-column>

          <el-table-column
            label="Historial"
            prop="pet_id"
            align="center"
            width="120px"
          >
            <template slot-scope="{row}">
              <router-link :to="'/mascotas/pet/edit/'+row.pet_id">
                <el-button type="primary" size="small">
                  <svg-icon icon-class="documentation" />
                </el-button>
              </router-link>

            </template>
          </el-table-column>

          <el-table-column label="Acciones" align="center" width="250" class-name="small-padding fixed-width">
            <template slot-scope="{row}">
              <router-link :to="'/agenda/visit/new/'+row.id">
                <el-button type="success" size="small">
                  <svg-icon icon-class="link" />
                </el-button>
              </router-link>

              <el-button type="warning" icon="el-icon-view" size="small" @click="handleUpdate(row)" />
              <el-button v-if="row.status==1" icon="el-icon-turn-off" size="small" type="danger" @click="handleModifyStatus(row, 0)">
                Inactivar
              </el-button>
              <el-button v-if="row.status==0" icon="el-icon-open" size="small" type="success" @click="handleModifyStatus(row, 1)">
                Activar
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" align="right" @pagination="getList" />

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" style="min-width:100vh;">
          <el-form ref="dataForm" :rules="rules" :model="temp" style="padding:0px 30px;">
            <el-form-item label="Titulo de cita" prop="description" style="width: 100%;">
              <el-input v-model="temp.description" disabled />
            </el-form-item>
            <el-form-item label="Veterinario" prop="personal_id">
              <el-select v-model="temp.personal_id" placeholder="Veterinario" disabled style="width: 100%">
                <el-option
                  v-for="itemoppersonal in optionsPersonal"
                  :key="itemoppersonal.value"
                  :label="itemoppersonal.label"
                  :value="itemoppersonal.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Cliente" prop="client_id">
              <el-select v-model="temp.client_id" placeholder="Seleccione un cliente" disabled style="width: 100%">
                <el-option
                  v-for="(item, index) in optionsClient"
                  :key="index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Nombre Mascota" prop="name">
              <el-input v-model="temp.name" disabled style="width: 100%" />
            </el-form-item>
            <el-form-item label="Fecha/Hora de cita" style="width: 100%;">
              <el-col :span="11" style="width: 100%;">
                <el-date-picker v-model="temp.registration_date" type="date" placeholder="Seleccione Fecha" style="width: 100%;" disabled />
              </el-col>
              <br>
              <el-col :span="11" style="width: 100%;">
                <el-time-picker v-model="temp.dateTime" type="fixed-time" placeholder="Seleccione hora" style="width: 100%;" disabled />
              </el-col>
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
import { fetchList, updateCita, ListPersonal, ListClient } from '@/api/appointment';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

export default {
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      tableKey: 0,
      listQuery: {
        page: 1,
        limit: 20,
        importance: undefined,
        name: undefined,
        type: undefined,
        sort: '+id',
      },
      listLoading: false,
      list: null,
      listPets: null,
      showReviewer: false,
      dialogFormVisible: false,
      dialogFormVisiblePet: false,
      dialogStatus: '',
      total: 0,
      optionsPersonal: [],
      optionsClient: [],
      optionsPet: [],
      textMap: {
        update: 'Editar',
        create: 'Crear',
        datos_mascotas: 'Lista Mascota',
      },
      rules: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
        observation: [{ required: true, message: 'type is required', trigger: 'change' }],
        email: [
          { required: true, message: 'Email is required', trigger: 'blur' },
          { type: 'email', message: 'Please input correct email address', trigger: ['blur', 'change'] },
        ],
      },
      appointment: {},
      temp: {
        id: undefined,
        client_id: '',
        description: '',
        registration_date: '',
        hours: '',
        pet_id: '',
        name: '',
        nombre_cliente: '',
        personal_id: '',
        nombre_veterinario: '',
        dateTime: '',
      },
    };
  },
  created() {
    this.getList();
    this.getListPersonal();
    this.getListClient();
    // this.getListPet();
  },
  methods: {
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },

    async getList() {
      this.listLoading = true;
      const { data } = await fetchList(this.listQuery);
      this.list = data.items;
      this.total = data.total;

      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('citas', data.items);
    },
    async getListPersonal() {
      this.listLoading = true;
      const { data } = await ListPersonal();

      for (const i in data.items) {
        this.optionsPersonal.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('medicos', this.optionsPersonal);
    },
    async getListClient() {
      this.listLoading = true;
      const { data } = await ListClient();

      for (const i in data.items) {
        this.optionsClient.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;

      // console.log('cliente', this.optionsClient);
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        client_id: '',
        description: '',
        registration_date: '',
        hours: '',
        pet_id: '',
        name: '',
        nombre_cliente: '',
        personal_id: '',
        nombre_veterinario: '',
      };
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          updateCita(this.temp).then(() => {
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v);
                this.list.splice(index, 1, this.temp);
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
    async handleModifyStatus(row, status) {
      this.listLoading = true;
      row.status = status;
      await updateCita(row);

      this.$message({
        message: 'Successful operation',
        type: 'success',
      });
      this.listLoading = false;
    },
    handleUpdate(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
  },
};
</script>

<style scoped>
.line{
  text-align: center;
}
</style>

