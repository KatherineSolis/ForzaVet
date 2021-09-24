<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card" style="height: 90vh">
        <div slot="header" class="clearfix">
          <span>Roles y Permisos</span>
        </div>
        <el-table
          :key="tableKey"
          v-loading="listLoading"
          :data="role"
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
            label="Nombre"
            prop="name"
            align="center"
            width="98"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.name }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="descripcion"
            prop="description"
            align="left"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.description }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Acciones" align="center" width="200" class-name="small-padding fixed-width">
            <template>
              <el-button type="primary" icon="el-icon-edit-outline" size="small">Editar Permisos</el-button>
            </template>
          </el-table-column>
        </el-table>

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
// import { fetchList, createSupplier, updateSupplier } from '@/api/supplier';
import waves from '@/directive/waves'; // Waves directive
// import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

export default {
  // components: { Pagination },
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
      textMap: {
        update: 'Editar',
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

      role: [
        {
          id: '1',
          name: 'Admin',
          description: 'Super Administrador. Tener acceso y permiso completo a todas las páginas.',
        },
        {
          id: '2',
          name: 'Veterinary',
          description: 'Veterinario. Tener acceso y permiso a la mayoría de las páginas excepto a la página usuarios, tipo vacuna, tipo desparacitación y permisos.',
        }],
      user: [
        {
          id: '1',
          nombre: 'Carlos Suarez',
          correo: 'carlos.suarezv@outlook.com',
          role: 'admin',
          status: '1',
        },
        {
          id: '2',
          correo: 'bliz@hotmail.es',
          nombre: 'Bianca Alvear',
          role: 'veterinary',
          status: '1',
        },
        {
          id: '3',
          correo: 'erika.gonzales_19@outlook.com',
          nombre: 'Erika Gonzales',
          role: 'veterinary',
          status: '1',
        },
        {
          id: '4',
          correo: 'bryantejada96@outlook.com',
          nombre: 'Bryan Tejada',
          role: 'veterinary',
          status: '1',
        }],
      total: this.user,
    };
  },
  created() {

  },
  methods: {
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
          // createSupplier(this.temp).then((response) => {
          // this.list.push(this.temp);
          this.dialogFormVisible = false;

          this.$notify({
            title: 'Success',
            message: 'Created successfully',
            type: 'success',
            duration: 2000,
            // });
          });
        }
      });
    },
    /* updateData() {
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
    },*/

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
