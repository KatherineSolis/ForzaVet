<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Resultados</span>

          <router-link data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" to="/servicio/crear"><!----><i class="el-icon-plus" /><span>
            Nuevo
          </span></router-link>

        </div>
        <div style="margin-bottom: 50px">
          <div class="filter-container">
            <el-input
              v-model="listQuery.reason"
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

        <div style="padding:25px 50px 0px 20px;">
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
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.date }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Propietario"
              prop="client_id"
              align="center"
              width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.client_id }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Paciente"
              prop="name"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.pet_id }} </span>
                <!-- <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span> -->
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

            <el-table-column label="Acciones" align="center" width="330" class-name="small-padding fixed-width">
              <template slot-scope="{row}">
                <el-button type="primary" icon="el-icon-edit-outline" size="small" />
                <el-button v-if="row.status==1" icon="el-icon-turn-off" size="small" type="danger">
                  Inactivar
                </el-button>
                <el-button v-if="row.status==0" icon="el-icon-open" size="small" type="success">
                  Activar
                </el-button>
                <el-button :v-if="true" size="small" type="success">
                  Mascotas
                </el-button>
              </template>
            </el-table-column>

          </el-table>
          <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />
        </div>
      </el-card>
    </el-row>
  </div>
</template>

<script>
import { ListClient, ListPet } from '@/api/appointment';
import { peluqueriaList } from '@/api/clinic_history';
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
      form: {
        date: '',
        client_id: '',
        pet_id: '',
        reason: '',
      },
    };
  },
  created() {
    this.getList();
    this.getListClient();
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
      const { data } = await peluqueriaList(this.listQuery);
      this.list = data.items;

      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('visit', data.items);
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
    async getListPet() {
      this.listLoading = true;
      const { data } = await ListPet(this.form);
      this.optionsPet = [];
      for (var i in data.items) {
        this.optionsPet.push({ value: data.items[i].id, label: data.items[i].name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('pet', this.optionsPet);
    },

  },
};

</script>

<style scoped>
.line{
  text-align: center;
}
</style>

