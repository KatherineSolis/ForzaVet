<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <router-link class="el-button el-button--primary el-button--small" to="/servicio/peluqueria">
            <i class="el-icon-back" />
          </router-link>
          <span>Nueva estética</span>
          <button data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" @click="myFunction"><!----><i class="el-icon-check" /><span>
            Guardar
          </span></button>
        </div>

        <div style="padding:25px 50px 0px 20px;">

          <el-form ref="form" :rules="rules" :model="form" label-width="100px">

            <el-form-item label="Propietario" prop="client_id">
              <el-select v-model="form.client_id" placeholder="Seleccione Cliente..." style="width: 100%;" @input="getListPet">
                <el-option
                  v-for="item in optionsClient"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Paciente" prop="pet_id">
              <el-select v-model="form.pet_id" placeholder="Seleccione mascota..." style="width: 100%;">
                <el-option
                  v-for="item in optionsPet"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item label="Tipo" prop="reason">
              <el-select v-model="form.reason" placeholder="Seleccione tipo..." style="width: 100%;">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item label="Detalles">
              <el-input v-model="form.diagnostic" type="textarea" style="width: 100%;" />
            </el-form-item>

            <el-form-item>
              <el-button type="primary" @click="onSubmit">
                Create
              </el-button>
              <el-button @click="onCancel">
                Cancel
              </el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-card>
    </el-row>
  </div>
</template>

<script>
import { ListClient, ListPet, ListVaccine } from '@/api/appointment';
import { fetchList, createHistory } from '@/api/clinic_history';
export default {
  data() {
    return {
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
      rules: {
        client_id: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
        pet_id: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
        reason: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
      },
      form: {
        date: '',
        personal_id: '',
        client_id: '',
        pet_id: '',
        reason: '',
        anamnesis: '',
        vaccine_id: '',
        antiparasitic_id: '',
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
    this.getListVaccine();
  },
  methods: {
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning',
      });
    },
    async getList() {
      this.listLoading = true;
      const { data } = await fetchList();
      this.list = data.items;

      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('visit', data.items);
    },
    async getListClient() {
      this.listLoading = true;
      const { data } = await ListClient();

      for (var i in data.items) {
        this.optionsClient.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('cliente', this.optionsClient);
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
      // console.log('pet', this.optionsPet);
    },
    async getListVaccine() {
      this.listLoading = true;
      const { data } = await ListVaccine();

      for (var i in data.items) {
        this.optionsVaccine.push({ value: data.items[i].id, label: data.items[i].name_vaccines });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('cliente', this.optionsVaccine);
    },

    myFunction() {
      var x = document.getElementById('mostrar');
      if (x.style.display === 'none') {
        x.style.display = 'block';
      } else {
        x.style.display = 'none';
      }
    },

    myDelete() {
      var x = document.getElementById('mostrar');
      if (x.style.display === 'block') {
        x.style.display = 'none';
      } else {
        x.style.display = 'block';
      }
    },
    onSubmit() {
      this.$refs['form'].validate((valid) => {
        if (valid) {
          const hoy = new Date();
          const fechaHora = `${hoy.getFullYear()}-${(hoy.getMonth()) + 1}-${hoy.getDate()} ${hoy.getHours()}:${hoy.getMinutes()}:${hoy.getSeconds()}`;
          console.log(fechaHora);
          this.form.id = this.list[this.list.length - 1].id + 1;
          this.form.status = 1;
          this.form.date = fechaHora;
          createHistory(this.form).then((response) => {
            this.list.push(this.form);
            console.log(this.form);
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

  },
};

</script>

<style scoped>
.line{
  text-align: center;
}
</style>

