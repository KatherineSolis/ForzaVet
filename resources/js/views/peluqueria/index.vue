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
              prop="document_type"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.document_type }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Propietario"
              prop="document_number"
              align="center"
              width="180px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.document_number }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Paciente"
              prop="name"
              align="center"
              width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Tipo"
              prop="direction"
              align="center"
              min-width="150px"
            >
              <template slot-scope="scope">
                <span>{{ scope.row.direction }}</span>
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
                <el-button :v-if="true" size="small" type="success" @click="modalPet(row)">
                  Mascotas
                </el-button>
              </template>
            </el-table-column>

          </el-table>

        </div>
      </el-card>
    </el-row>
  </div>
</template>

<script>
import { ListClient, ListPet } from '@/api/appointment';
export default {
  data() {
    return {
      listLoading: false,
      optionsClient: [],
      optionsPet: [],
      optionsVaccine: [],
      form: {
        name: '',
        client_id: '',
        pet_id: '',
        date2: '',
        delivery: false,
        type: [],
        resource: '',
        desc: '',
      },
    };
  },
  created() {
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

