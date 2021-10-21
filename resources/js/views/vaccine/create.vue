<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <el-button class="el-button el-button--primary el-button--small" @click="onCancel">
            <i class="el-icon-back" />
          </el-button>
          <span>Vacunas</span>
        </div>

        <div style="padding:25px 50px 0px 20px;">

          <el-form ref="form" :rules="rules" :model="form" label-width="100px">

            <el-form-item label="Propietario" prop="client_id">
              <el-select v-model="form.client_id" placeholder="Seleccione Cliente..." style="width: 100%;" disabled @input="getListPet">
                <el-option
                  v-for="(item, index) in optionsClient"
                  :key="'al'+ index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Paciente" prop="pet_id">
              <el-select v-model="form.pet_id" placeholder="Seleccione mascota..." style="width: 100%;" disabled>
                <el-option
                  v-for="(item, index) in optionsPet"
                  :key="'bl'+ index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item label="Tipo Vacuna" prop="vaccine_id">
              <el-select v-model="form.vaccine_id" placeholder="Seleccione tipo..." style="width: 100%;">
                <el-option
                  v-for="(item, index) in optionsVaccine"
                  :key="'cl'+index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item label="Detalles">
              <el-input v-model="form.vaccine_observation" type="textarea" style="width: 100%;" />
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
import { ListClient, fetchListPet, ListVaccine } from '@/api/appointment';
import { fetchList, createHistory, peluqueriaCreate } from '@/api/clinic_history';
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
        vaccine_id: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
      },
      form: {
        date: '',
        personal_id: '',
        client_id: '',
        pet_id: '',
        reason: '',
        anamnesis: '',
        vaccine_id: '',
        vaccine_observation: '',
        antiparasitic_id: '',
        antiparasitic_observation: '',
        diagnostic: '',
        pathology: '',
        treatment: '',
        prescription: '',
      },
    };
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    console.log(this.$route.params);
    console.log(this.$route);
    this.getList();
    this.getListClient();
    this.getListPet();
    this.getPeluqueria(id);
    this.getListVaccine();
  },
  methods: {
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning',
      });
      this.$router.go(-1);
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

      for (const i in data.items) {
        this.optionsClient.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('cliente', this.optionsClient);
    },
    async getListPet() {
      this.listLoading = true;
      const { data } = await fetchListPet();
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

      for (const i in data.items) {
        this.optionsVaccine.push({ value: data.items[i].id, label: data.items[i].name_vaccines });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('cliente', this.optionsVaccine);
    },

    onSubmit() {
      this.$refs['form'].validate((valid) => {
        if (valid) {
          const hoy = new Date();
          const fechaHora = `${hoy.getFullYear()}-${(hoy.getMonth()) + 1}-${hoy.getDate()} ${hoy.getHours()}:${hoy.getMinutes()}:${hoy.getSeconds()}`;
          this.form.id = this.list[this.list.length - 1].id + 1;
          this.form.status = 1;
          this.form.date = fechaHora;
          this.form.reason = 'Vacunación';
          createHistory(this.form).then((response) => {
            this.list.push(this.form);
            this.$notify({
              title: 'Success',
              message: 'Created successfully',
              type: 'success',
              duration: 2000,
            });
          });
          this.$router.go(-1);
        }
      });
    },
    async getPeluqueria(id) {
      const { data } = await peluqueriaCreate(id);
      this.form.client_id = data.items[0].client_id;
      this.form.pet_id = data.items[0].pet_id;
      // console.log('usuario tipo: '+ typeof this.user, 'tipo historial: '+ typeof this.historial, 'tipo vaccine: '+ typeof this.vaccine, 'tipo antiparasitic: '+ typeof this.antiparasitic, typeof this.antiparasitic, typeof this.peluqueria);
    },
  },
};

</script>

<style scoped>
.line{
  text-align: center;
}
</style>

