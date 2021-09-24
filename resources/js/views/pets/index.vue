<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card" style="height: 90vh">
        <div slot="header" class="clearfix">
          <span>Listado de mascotas</span>
          <el-button
            class="filter-item"
            style="float: right"
            type="primary"
            icon="el-icon-plus"
            @click="handleCreate"
          >
            {{ $t('table.add') }}
          </el-button>
        </div>
        <div style="margin-bottom: 20px">
          <div class="filter-container">
            <el-input
              v-model="listQuery.name"
              placeholder="Nombre"
              style="width: 250px"
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
            label="Nombre"
            prop="name"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.name }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Especie"
            prop="specie"
            align="center"
            width="120px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.specie }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Raza"
            prop="breed"
            align="center"
            width="120px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.breed }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Propietario"
            prop="client_id"
            align="center"
            min-width="200px"
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

          <el-table-column
            label="Historial"

            align="center"
            min-width="80px"
          >
            <template slot-scope="{row}">

              <router-link :to="'/mascotas/pet/edit/'+row.id">
                <el-button type="warning" size="small">
                  <svg-icon icon-class="documentation" />
                </el-button>
              </router-link>
            </template>
          </el-table-column>

          <el-table-column label="Acciones" align="center" width="260" class-name="small-padding fixed-width">
            <template slot-scope="{row}">

              <el-button type="primary" icon="el-icon-edit" size="small" @click="handleUpdate(row)" />
              <el-button type="success" icon="el-icon-view" size="small" @click="handleView(row)" />
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
          <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left">
            <el-form-item label="Nombre mascota" prop="name">
              <el-input v-model="temp.name" placeholder="Nombre mascota" />
            </el-form-item>
            <el-form-item label="Nombre Cliente" prop="client_id">
              <el-select v-model="temp.client_id" placeholder="Seleccione cliente..." style="width:100%" @input="getListClient">
                <el-option
                  v-for="itemcliente in optionsClient"
                  :key="itemcliente.value"
                  :label="itemcliente.label"
                  :value="itemcliente.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Sexo" prop="sex">
              <el-select v-model="temp.sex" placeholder="Seleccionar sexo..." style="width:100%">
                <el-option
                  v-for="itemsex in options"
                  :key="itemsex.value"
                  :label="itemsex.label"
                  :value="itemsex.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Tipo Mascota" prop="specie">
              <el-select v-model="temp.specie" placeholder="Seleccionar" style="width:100%">
                <el-option
                  v-for="item in species"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Edad" prop="age" style="width: 100%;">
              <el-input v-model="temp.age" />
            </el-form-item>
            <!--el-form-item label="Edad" prop="age">
              <el-input v-model="temp.age" />
            </el-form-item-->
            <el-form-item label="Peso" prop="weight">
              <el-input v-model="temp.weight" />
            </el-form-item>
            <el-form-item label="Color" prop="color">
              <el-input v-model="temp.color" />
            </el-form-item>
            <el-form-item label="Chip" prop="chip">
              <el-input v-model="temp.chip" />
            </el-form-item>
            <el-form-item label="Raza" prop="breed">
              <el-input v-model="temp.breed" />
            </el-form-item>
            <el-form-item label="Castrado" prop="castrated">
              <el-input v-model="temp.castrated" />
            </el-form-item>
            <el-form-item label="Nivel de agresividad" prop="aggressiveness">
              <el-select v-model="temp.aggressiveness" placeholder="Seleccionar" style="width:100%">
                <el-option
                  v-for="itemagre in typeaggressiveness"
                  :key="itemagre.value"
                  :label="itemagre.label"
                  :value="itemagre.value"
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

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisiblePet" style="min-width:100vh;">
          <el-form ref="data" :model="temp" label-position="left">
            <el-form-item label="Sexo" prop="sex">
              <el-select v-model="temp.sex" placeholder="Seleccionar..." style="width:100%" disabled>
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Tipo Mascota" prop="specie">
              <el-select v-model="temp.specie" placeholder="Seleccionar..." disabled style="width:100%">
                <el-option
                  v-for="item1 in species"
                  :key="item1.value"
                  :label="item1.label"
                  :value="item1.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Nombre Mascota" prop="name">
              <el-input v-model="temp.name" disabled />
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
              <el-select v-model="temp.client_id" placeholder="Seleccione cliente..." disabled style="width:100%" @input="getListClient">
                <el-option
                  v-for="item2 in optionsClient"
                  :key="item2.value"
                  :label="item2.label"
                  :value="item2.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Chip" prop="chip">
              <el-input v-model="temp.chip" disabled />
            </el-form-item>
            <el-form-item label="Raza" prop="breed">
              <el-input v-model="temp.breed" disabled />
            </el-form-item>
            <el-form-item label="Castrado" prop="castrated">
              <el-input v-model="temp.castrated" disabled />
            </el-form-item>
            <el-form-item label="Nivel de agresividad" prop="aggressiveness">
              <el-select v-model="temp.aggressiveness" placeholder="Seleccionar" style="width:100%" disabled>
                <el-option
                  v-for="item3 in typeaggressiveness"
                  :key="item3.value"
                  :label="item3.label"
                  :value="item3.value"
                />
              </el-select>
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
        update: 'Editar',
        create: 'Crear',
        visualizar: 'Detalle de la mascota',
      },
      rules: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
        age: [{ required: true, message: 'type is required', trigger: 'change' }],
        sex: [{ required: true, message: 'type is required', trigger: 'change' }],
        weight: [{ required: true, message: 'type is required', trigger: 'change' }],
        color: [{ required: true, message: 'type is required', trigger: 'change' }],
        client_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        specie: [{ required: true, message: 'type is required', trigger: 'change' }],
        breed: [{ required: true, message: 'type is required', trigger: 'change' }],
        castrated: [{ required: true, message: 'type is required', trigger: 'change' }],
        aggressiveness: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      temp: {
        id: undefined,
        name: '',
        age: '',
        sex: '',
        weight: '',
        color: '',
        chip: '',
        client_id: '',
        specie: '',
        breed: '',
        castrated: '',
        aggressiveness: '',
      },
      typeaggressiveness: [
        {
          value: '1',
          label: '1',
        },
        {
          value: '2',
          label: '2',
        },
        {
          value: '3',
          label: '3',
        },
        {
          value: '4',
          label: '4',
        },
        {
          value: '5',
          label: '5',
        }],
      options: [
        {
          value: 'Hembra',
          label: 'Hembra',
        },
        {
          value: 'Macho',
          label: 'Macho',
        }],
      optionsAge: [
        {
          value: 'meses',
          label: 'meses',
        },
        {
          value: 'años',
          label: 'años',
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
      // console.log('dataaa', data.items);
    },
    async getListClient() {
      this.listLoading = true;
      const { data } = await ListClient();
      this.optionsClient = [];
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
        name: '',
        age: '',
        numberage: '',
        textage: '',
        sex: '',
        weight: '',
        color: '',
        chip: '',
        client_id: '',
        specie: '',
        breed: '',
        castrated: '',
        aggressiveness: '',
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
        console.log(this.$refs['dataForm']);
        if (valid) {
          this.temp.id = this.list[this.list.length - 1].id + 1;
          this.temp.status = 1;
          //this.temp.age = this.temp.numberage + ' ' + this.temp.textage;
          if (this.temp.chip == ''){
            this.temp.chip = 'no';
          }
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
          this.$router.go(0);
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
