<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card" style="height: 90vh">
        <div slot="header" class="clearfix">
          <span>Mascotas</span>
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
            <el-button
              class="filter-item"
              style="margin-left: 10px"
              type="primary"
              icon="el-icon-plus"
              @click="handleCreate"
            >
              {{ $t('table.add') }}
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
            label="Nombre"
            prop="name"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.nombre_mascota }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Edad"
            prop="age"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.age }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Sexo"
            prop="sex"
            align="center"
            width="180px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.sex }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Peso"
            prop="weight"
            align="center"
            width="180px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.weight }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Color"
            prop="color"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.color }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Especie"
            prop="specie"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.specie }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Raza"
            prop="breed"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.breed }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Propietario"
            prop="client_id"
            align="center"
            min-width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.nombre_cliente }}</span>
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
          <el-table-column label="Acciones" align="center" width="330" class-name="small-padding fixed-width">
            <template slot-scope="{row}">

              <el-button v-if="row.status==1" icon="el-icon-turn-off" size="small" type="danger" @click="handleModifyStatus(row, 0)">
                Inactivar
              </el-button>
              <el-button v-if="row.status==0" icon="el-icon-open" size="small" type="success" @click="handleModifyStatus(row, 1)">
                Activar
              </el-button>
              <el-button type="primary" icon="el-icon-edit" size="small" @click="handleUpdate(row)" />
              <router-link :to="'/mascotas/pet/edit/'+row.id">
                <el-button type="primary" size="small" icon="el-icon-edit">
                  Historial
                </el-button>
              </router-link>
              <el-button type="success" icon="el-icon-view" size="small" @click="handleView(row)" />
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
          <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="180px" style="width: 500px; margin-left:50px;">
            <el-form-item label="Sexo" prop="sex">
              <el-select v-model="temp.sex" placeholder="Seleccionar sexo...">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Tipo Mascota" prop="specie">
              <el-select v-model="temp.specie" placeholder="Seleccionar">
                <el-option
                  v-for="item in species"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Nombre mascota" prop="nombre_mascota">
              <el-input v-model="temp.nombre_mascota" />
            </el-form-item>
            <el-form-item label="Edad" prop="age">
              <el-input v-model="temp.age" />
            </el-form-item>
            <el-form-item label="Peso" prop="weight">
              <el-input v-model="temp.weight" />
            </el-form-item>
            <el-form-item label="Color" prop="color">
              <el-input v-model="temp.color" />
            </el-form-item>
            <el-form-item label="Nombre Cliente" prop="client_id">
              <el-select v-model="temp.client_id" placeholder="Seleccione cliente..." @input="getListClient">
                <el-option
                  v-for="item in optionsClient"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Chip" prop="chip">
              <el-input v-model="temp.chip" />
            </el-form-item>
            <el-form-item label="Raza" prop="breed">
              <el-input v-model="temp.breed" />
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

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisiblePet">
          <el-form ref="data" :model="temp" label-position="left" label-width="180px" style="width: 500px; margin-left:50px;">
            <el-form-item label="Sexo" prop="sex">
              <el-select v-model="temp.sex" placeholder="Seleccionar..." disabled>
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Tipo Mascota" prop="specie">
              <el-select v-model="temp.specie" placeholder="Seleccionar..." disabled>
                <el-option
                  v-for="item in species"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Nombre Mascota" prop="nombre_mascota">
              <el-input v-model="temp.nombre_mascota" disabled />
            </el-form-item>
            <el-form-item label="Edad" prop="age">
              <el-input v-model="temp.age" disabled />
            </el-form-item>
            <el-form-item label="Peso" prop="weight">
              <el-input v-model="temp.weight" disabled />
            </el-form-item>
            <el-form-item label="Color" prop="color">
              <el-input v-model="temp.color" disabled />
            </el-form-item>
            <el-form-item label="Nombre cliente" prop="client_id">
              <el-select v-model="temp.client_id" placeholder="Seleccione cliente..." disabled @input="getListClient">
                <el-option
                  v-for="item in optionsClient"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Chip" prop="chip">
              <el-input v-model="temp.chip" disabled />
            </el-form-item>
            <el-form-item label="Raza" prop="breed">
              <el-input v-model="temp.breed" disabled />
            </el-form-item>
          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisiblePet = false">
              {{ $t('table.cancel') }}
            </el-button>
          </div>
        </el-dialog>

      </el-card>
    </el-row>
  </div>
</template>
<script>
import { fetchList, createPet, updatePet, ListClient } from '@/api/pet';
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
        name: undefined,
        type: undefined,
        sort: '+id',
      },
      listLoading: false,
      list: null,
      optionsClient: [],
      showReviewer: false,
      dialogFormVisible: false,
      dialogFormVisiblePet: false,
      dialogStatus: '',
      textMap: {
        update: 'Edit',
        create: 'Crear',
        visualizar: 'Detalle de datos',
      },
      rules: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      temp: {
        id: undefined,
        name: '',
        age: '',
      },
      options: [
        {
          value: 'Hembra',
          label: 'Hembra',
        },
        {
          value: 'Macho',
          label: 'Macho',
        }],

      species: [
        {
          value: 'Canino',
          label: 'Canino',
        },
        {
          value: 'Felino',
          label: 'Felino',
        },
        {
          value: 'Roedores',
          label: 'Roedores',
        },
        {
          value: 'Aves',
          label: 'Aves',
        }],
    };
  },
  created() {
    this.getList();
    this.getListClient();
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
      console.log('dataaa', data.items);
    },
    async getListClient() {
      this.listLoading = true;
      const { data } = await ListClient();

      for (var i in data.items) {
        this.optionsClient.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('cliente', this.optionsClient);
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
        name: '',
        age: '',
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
          this.temp.id = this.list[this.list.length - 1].id + 1;
          this.temp.status = 1;
          createPet(this.temp).then((response) => {
            this.list.push(this.temp);
            this.dialogFormVisible = false;

            this.$notify({
              title: 'Success',
              message: 'Created successfully',
              type: 'success',
              duration: 2000,
            });
          });
        }
      });
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          console.log(this.temp);
          updatePet(this.temp).then(() => {
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
      await updatePet(row);

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
    },

    handleView(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp);
      console.log(this.temp);
      this.dialogStatus = 'visualizar';
      this.dialogFormVisiblePet = true;
    },

  },
};
</script>
<style scoped>
.mixin-components-container {
  background-color: #f0f2f5;
  padding: 30px;
  min-height: calc(100vh - 84px);
}
.component-item {
  min-height: 100px;
}
</style>
