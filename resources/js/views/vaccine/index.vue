<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Listado de vacunas</span>
        </div>
        <div style="margin-bottom: 50px">
          <div class="filter-container">
            <el-input
              v-model="listQuery.name"
              placeholder=" vacuna"
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

          <el-table-column align="center" label="Nombre" prop="name_vaccines" width="150">
            <template slot-scope="scope">
              <span>{{ scope.row.name_vaccines }}</span>
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
          <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left">
            <el-form-item label="Nombre:" prop="name_vaccines">
              <el-input v-model="temp.name_vaccines" />
            </el-form-item>
            <el-form-item label="Descripción:" prop="detail">
              <el-input v-model="temp.detail" />
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
import { fetchList, createVaccine, updateVaccine } from '@/api/vaccine';
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
        limit: 5,
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
      textMap: {
        update: 'Editar',
        create: 'Crear',
      },
      rules: {
        name_vaccines: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      temp: {
        id: undefined,
        name_vaccines: '',
        detail: '',
      },
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
      console.log(data.items);

      this.list = data.items;
      this.total = data.total;
      console.log(data.items);
      // Just to simulate the time of the request
      this.listLoading = false;
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
        observation: '',
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
        console.log(this.temp);
        if (valid) {
          this.temp.id = this.list[this.list.length - 1].id + 1;
          this.temp.status = 1;
          createVaccine(this.temp).then((response) => {
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
          updateVaccine(this.temp).then(() => {
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
      console.log(row);
      await updateVaccine(row);

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
