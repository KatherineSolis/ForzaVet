<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <el-button class="el-button el-button--primary el-button--small" @click="onCancel">
            <i class="el-icon-back" />
          </el-button>
          <span>Desparasitación</span>
        </div>

        <div style="padding:25px 50px 0px 20px;">

          <el-form ref="form" :rules="rules" :model="form" label-width="100px">

            <el-form-item label="Propietario:" prop="client_id">
              <el-select v-model="form.client_id" placeholder="Seleccione Cliente..." style="width: 100%;" disabled @input="getListPet">
                <el-option
                  v-for="(item, index) in optionsClient"
                  :key="'aa'+ index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Paciente:" prop="pet_id">
              <el-select v-model="form.pet_id" placeholder="Seleccione mascota..." style="width: 100%;" disabled>
                <el-option
                  v-for="(item, index) in optionsPet"
                  :key="'ba'+ index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item label="Tipo:" prop="antiparasitic_id">
              <el-select v-model="form.antiparasitic_id" placeholder="Seleccione tipo..." style="width: 100%;">
                <el-option
                  v-for="(item, index) in optionsAntiparasitic"
                  :key="'ca'+index"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>

            <el-form-item label="Peso:">
              <el-input v-model="form.weight" type="text" style="width: 100%;" />
            </el-form-item>

            <el-form-item label="Detalles:">
              <el-input v-model="form.antiparasitic_observation" type="textarea" style="width: 100%;" />
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
import { ListClient, fetchListPet, ListAntiparasitic } from '@/api/appointment';
import { fetchList, createHistory, peluqueriaCreate } from '@/api/clinic_history';
export default {
  data() {
    return {
      listLoading: false,
      list: null,
      optionsClient: [],
      optionsPet: [],
      optionsAntiparasitic: [],
      rules: {
        client_id: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
        pet_id: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
        antiparasitic_id: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
        weight: [{ required: true, message: 'Este campo es requerido', trigger: 'change' }],
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
    this.getList();
    this.getListClient();
    this.getListPet();
    this.getPeluqueria(id);
    this.getListAntiparasitic();
  },
  methods: {
    onCancel() {
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
    async getListAntiparasitic() {
      this.listLoading = true;
      const { data } = await ListAntiparasitic();

      for (var i in data.items) {
        this.optionsAntiparasitic.push({ value: data.items[i].id, label: data.items[i].name_antiparasitic });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('desparacitante', this.optionsAntiparasitic);
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
          this.form.id = this.list[this.list.length - 1].id + 1;
          this.form.status = 1;
          this.form.date = fechaHora;
          this.form.reason = 'Desparasitación';
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

