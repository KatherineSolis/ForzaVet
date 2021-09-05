<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card" style="height: 90vh">
        <div slot="header" class="clearfix">
          <span>Cliente</span>
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
            :label="$t('table.id')"
            prop="id"
            align="center"
            width="80"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.id }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Tipo de documento"
            prop="document_type"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.document_type }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Numero de documento"
            prop="document_number"
            align="center"
            width="180px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.document_number }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Nombre"
            prop="name"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Direccion"
            prop="direction"
            align="center"
            min-width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.direction }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Correo"
            prop="email"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.email }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Telefono"
            prop="phone"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.phone }}</span>
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
              <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
              <el-button v-if="row.status==1" icon="el-icon-turn-off" size="small" type="danger" @click="handleModifyStatus(row, 0)">
                Inactivar
              </el-button>
              <el-button v-if="row.status==0" icon="el-icon-open" size="small" type="success" @click="handleModifyStatus(row, 1)">
                Activar
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
          <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="180px" style="width: 500px; margin-left:50px;">
            <el-form-item label="Tipo de documento" prop="document_type">
              <el-select v-model="temp.document_type" placeholder="Seleccionar">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Numero Doc" prop="document_number">
              <el-input v-model="temp.document_number" />
            </el-form-item>
            <el-form-item label="Nombres" prop="first_name">
              <el-input v-model="temp.first_name" />
            </el-form-item>
            <el-form-item label="Apellidos" prop="last_name">
              <el-input v-model="temp.last_name" />
            </el-form-item>
            <el-form-item label="Direccion" prop="direction">
              <el-input v-model="temp.direction" />
            </el-form-item>
            <el-form-item label="Correo" prop="email">
              <el-input v-model="temp.email" />
            </el-form-item>
            <el-form-item label="Telefono" prop="phone">
              <el-input v-model="temp.phone" />
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
import { fetchList, createSupplier, updateSupplier } from '@/api/supplier';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

export default {
  name: 'ProveedoresList',
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      tableKey: 0,
      table1Key: 0,
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
      dialogStatus: '',
      total: 0,
      textMap: {
        update: 'Edit',
        create: 'Crear',
        datos_mascotas: 'Lista Mascota',
      },
      rules: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
        observation: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      temp: {
        id: undefined,
        first_name: '',
        last_name: '',
        document_type: '',
        document_number: '',
        phone: '',
        direction: '',
        email: '',
      },
      options: [
        {
          value: 'CI',
          label: 'Cedula',
        },
        {
          value: 'Passport',
          label: 'Pasaporte',
        }],
    };
  },
  created() {
    this.getList();
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
      console.log('datos_proveedor', data.items);
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
        first_name: '',
        last_name: '',
        document_type: '',
        document_number: '',
        phone: '',
        direction: '',
        email: '',
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
          createSupplier(this.temp).then((response) => {
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
          updateSupplier(this.temp).then(() => {
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
      await updateSupplier(row);

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
.mixin-components-container {
  background-color: #f0f2f5;
  padding: 30px;
  min-height: calc(100vh - 84px);
}
.component-item {
  min-height: 100px;
}
</style>
