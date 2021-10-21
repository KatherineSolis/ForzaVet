<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Resultados</span>

        </div>
        <div style="margin-bottom: 50px">
          <div class="filter-container">
            <el-input
              v-model="listQuery.reason"
              placeholder="Tipo"
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

        <div>
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
              prop="date"
              align="center"
              min-width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.date | parseTime('{y}-{m}-{d}') }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Propietario"
              prop="client_id"
              align="center"
              width="200px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.nombre_cliente }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Paciente"
              prop="name"
              align="center"
              width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.name }} </span>
                <!-- <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span> -->
              </template>
            </el-table-column>
            <el-table-column
              label="Tipo"
              prop="reason"
              align="center"
              min-width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.reason }}</span>
              </template>
            </el-table-column>

            <el-table-column label="Acciones" align="center" width="230" class-name="small-padding fixed-width">
              <template slot-scope="{row}">
                <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
                <el-button icon="el-icon-delete" size="small" type="danger" @click="handleModifyStatus(row, 0)" />
              </template>
            </el-table-column>

          </el-table>
          <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" align="center" @pagination="getList" />
          <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" style="min-width:100vh;">
            <el-form ref="dataForm" :rules="rules" :model="temp" style="padding:0px 30px;">
              <el-form-item label="Fecha" style="width:100%;">
                <el-date-picker v-model="temp.date" type="datetime" placeholder="ingrese fecha" style="width:100%;" />
              </el-form-item>
              <el-form-item label="Nombre Cliente" prop="client_id">
                <el-select v-model="temp.client_id" placeholder="Seleccione cliente..." style="width:100%;" @input="getListClient">
                  <el-option
                    v-for="item in optionsClient"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Nombre Mascota" prop="pet_id">
                <el-select v-model="temp.pet_id" placeholder="Seleccione cliente..." style="width:100%;" @input="getListPet">
                  <el-option
                    v-for="item in optionsPet"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
              <el-form-item label="Motivo de visita" prop="reason">
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
                <el-input v-model="temp.diagnostic" type="textarea" />
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
      </el-card>
    </el-row>
  </div>
</template>

<script>
import { ListClient, fetchListPet } from '@/api/appointment';
import { updateHistory, peluqueriaList } from '@/api/clinic_history';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
export default {
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      tableKey: 0,
      total: 0,
      listQuery: {
        page: 1,
        limit: 20,
        importance: undefined,
        reason: undefined,
        type: undefined,
        sort: '+id',
      },
      listLoading: false,
      list: null,
      optionsClient: [],
      optionsPet: [],
      optionsVaccine: [],
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
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Edit',
        create: 'Crear',
      },
      rules: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
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
    };
  },
  created() {
    this.getList();
    this.getListClient();
    this.getListPet();
  },
  methods: {
    onSubmit() {
      this.$message('submit!');
    },
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning',
      });
    },
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    async getList() {
      this.listLoading = true;
      const { limit, page } = this.listQuery;
      const { data } = await peluqueriaList(this.listQuery);
      this.list = data.items;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = data.total;
      // Just to simulate the time of the request
      this.listLoading = false;
    },
    async getListClient() {
      this.listLoading = true;
      const { data } = await ListClient();

      for (var i in data.items) {
        this.optionsClient.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
    },
    async getListPet() {
      this.listLoading = true;
      const { data } = await fetchListPet();
      this.optionsPet = [];
      for (var i in data.items) {
        this.optionsPet.push({ value: data.items[i].id, label: data.items[i].name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          console.log(this.temp);
          updateHistory(this.temp).then(() => {
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v);
                this.list.splice(index, 1, this.temp);
                break;
              }
            }
            this.handleFilter();
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
    handleUpdate(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
    },
    async handleModifyStatus(row, status) {
      this.listLoading = true;
      row.status = status;
      await updateHistory(row);
      this.handleFilter();
      this.$message({
        message: 'Successful operation',
        type: 'success',
      });
      this.listLoading = false;
    },

  },
};

</script>

<style scoped>
.line{
  text-align: center;
}
</style>

