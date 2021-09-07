<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card" style="height: 90vh">
        <div slot="header" class="clearfix">
          <i class="el-icon-tickets" /> <span>Lista de productos</span>
          <el-button
            class="filter-item"
            style="float: right;"
            type="primary"
            icon="el-icon-plus"
            @click="handleCreate"
          >
            {{ $t('table.add') }}
          </el-button>
        </div>
        <div style="">
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
            label="Categoría"
            prop="category_id"
            align="center"
            min-width="90px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.category_id }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Producto"
            prop="name"
            align="center"
            min-width="100px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.name }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Unidad"
            prop="units"
            align="center"
            width="80px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.units }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Precio"
            prop="sale_price"
            align="center"
            width="80px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.sale_price }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Stock"
            prop="stock"
            align="center"
            min-width="60px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.stock }}</span>
            </template>
          </el-table-column>

          <el-table-column
            label="Imagen"
            prop="image"
            align="center"
            min-width="60px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.image }}</span>
            </template>
          </el-table-column>

          <el-table-column label="Acciones" align="center" width="330" class-name="small-padding fixed-width">
            <template slot-scope="{row}">
              <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
              <el-button type="info" icon="el-icon-view" size="small" @click="handleUpdate(row)" />
              <el-button type="danger" icon="el-icon-close" size="small" @click="handleUpdate(row)" />
              <el-button type="success" icon="el-icon-plus" size="small" @click="handleUpdate(row)">
                Actualizar
              </el-button>

            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
          <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="180px" style="width: 500px; margin-left:50px;">
            <el-form-item label="Proveedor" prop="suppliers_id">
              <el-select v-model="temp.suppliers_id" placeholder="Seleccionar">
                <el-option
                  v-for="item in options_suppliers"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Categoria" prop="category_id">
              <el-select v-model="temp.category_id" placeholder="Seleccionar">
                <el-option
                  v-for="item in options_category"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item label="Nombre" prop="name">
              <el-input v-model="temp.name" />
            </el-form-item>
            <el-form-item label="Precio Compra" prop="buy_price">
              <el-input v-model="temp.buy_price" />
            </el-form-item>
            <el-form-item label="Precio Venta" prop="sale_price">
              <el-input v-model="temp.sale_price" />
            </el-form-item>
            <el-form-item label="Unidad" prop="units">
              <el-input v-model="temp.units" />
            </el-form-item>
            <el-form-item label="Stock" prop="stock">
              <el-input v-model="temp.stock" />
            </el-form-item>
            <el-form-item label="Fecha de vencimiento" prop="expiry_date">
              <el-col :span="11">
                <el-date-picker v-model="temp.expiry_date" type="date" placeholder="Pick a date" style="width: 100%;" />
              </el-col>
            </el-form-item>
            <el-form-item label="Imagen" prop="image">
              <el-image
                style="width: 100px; height: 100px"
                :src="temp.image"
                :fit="fit"
              />
            </el-form-item>
            <el-form-item label="Imagen" prop="image">
              <el-input v-model="temp.image" type="file" />
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
          <el-table
            :key="table1Key"
            v-loading="listLoading"

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
            >
              <template slot-scope="scope">
                <span>{{ scope.row.name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Tipo Mascota"
              prop="specie"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.specie }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Sexo"
              prop="sex"
              align="center"
              width="105px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.sex }}</span>
              </template>
            </el-table-column>
          </el-table>
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
import { fetchList, createProduct } from '@/api/product';
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
      listSuppliers: null,
      listCategory: null,
      showReviewer: false,
      dialogFormVisible: false,
      dialogFormVisiblePet: false,
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
        suppliers_id: '',
        category_id: '',
        name: '',
        buy_price: '',
        sale_price: '',
        units: '',
        stock: '',
        expiry_date: '',
        image: '',
      },
      options_suppliers: [],
      options_category: [],
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
      this.listSuppliers = data.suppliers;
      this.listCategory = data.category;
      this.options_category = [];
      this.options_suppliers = [];
      for (const i in this.listSuppliers) {
        this.options_suppliers.push({ value: this.listSuppliers[i].id, label: this.listSuppliers[i].first_name + ' ' + this.listSuppliers[i].last_name });
      }
      for (const i in this.listCategory) {
        this.options_category.push({ value: this.listCategory[i].id, label: this.listCategory[i].name });
      }

      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('datos_productos', data.items);
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
        suppliers_id: '',
        category_id: '',
        name: '',
        buy_price: '',
        sale_price: '',
        units: '',
        stock: '',
        expiry_date: '',
        image: '',
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
          const splitHoras = this.temp;
          const arrayHoras = splitHoras.expiry_date.toLocaleDateString().split('/');
          this.temp.expiry_date = `${arrayHoras[2]}-${arrayHoras[1]}-${arrayHoras[0]}`;
          console.log(this.temp.expiry_date);

          console.log(this.temp);
          createProduct(this.temp).then((response) => {
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
          /* updateClient(this.temp).then(() => {
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
          });*/
        }
      });
    },
    async handleModifyStatus(row, status) {
      this.listLoading = true;
      row.status = status;
      // await updateClient(row);

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
    modalPet(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.dialogStatus = 'datos_mascotas';
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
