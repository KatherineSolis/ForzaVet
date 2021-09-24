<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card" style="height: 90vh">
        <div slot="header" class="clearfix">
          <span>Categoria</span>
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
              icon="el-icon-edit"
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
            label="Nombre"
            prop="name"
            align="center"
            width="150px"
          />
          <el-table-column label="Estado" class-name="status-col" width="100">
            <template slot-scope="{row}">
              <div v-if="row.status == 1">
                <el-tag type="success">
                  Activo
                </el-tag>
              </div>
              <div v-else>
                <el-tag type="danger">
                  Inactivo
                </el-tag>
              </div>
            </template>
          </el-table-column>
          <el-table-column label="Acciones" align="center" width="230" class-name="small-padding fixed-width">
            <template slot-scope="{row}">
              <el-button type="primary" size="mini" @click="handleUpdate(row)">
                Editar
              </el-button>
              <el-button v-if="row.status==1" size="mini" type="danger" @click="handleModifyStatus(row, 0)">
                Inactivar
              </el-button>
              <el-button v-if="row.status==0" size="mini" type="success" @click="handleModifyStatus(row, 1)">
                Activar
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
          <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="120px" style="width: 500px; margin-left:50px;">
            <el-form-item label="Nombre" prop="name">
              <el-input v-model="temp.name" />
            </el-form-item>
            <el-form-item label="Descripcion" prop="description">
              <el-input v-model="temp.description" />
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
import { fetchList, createCategory, updateCategory } from '@/api/category';
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import waves from '@/directive/waves'; // Waves directive
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
      showReviewer: false,
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
        name: '',
        description: '',
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
      this.list = data.items;
      this.total = data.total;

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
        description: '',
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
          createCategory(this.temp).then((response) => {
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
          updateCategory(this.temp).then(() => {
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
      await updateCategory(row);

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
