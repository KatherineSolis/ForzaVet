<template>
  <div class="app-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Nueva Visita</span>
        </div>
        <div style="padding:25px 50px 0px 20px;">

          <el-form ref="form" :rules="rules" :model="form" label-width="120px">
            <el-form-item label="Fecha">
              <el-date-picker v-model="form.date" type="datetime" placeholder="ingrese fecha" />
            </el-form-item>
            <el-form-item label="Veterinario" prop="personal_id">
              <el-select v-model="form.personal_id" placeholder="Seleccione Veterinario..." style="width: 100%;">
                <el-option
                  v-for="item in optionsPersonal"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
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
            <el-form-item label="Motivo de visita" prop="reason">
              <el-input v-model="form.reason" type="textarea" style="width: 100%;" />
            </el-form-item>

            <el-form-item label="Anamnesis" prop="anamnesis">
              <el-input v-model="form.anamnesis" type="textarea" style="width: 100%;" />
            </el-form-item>

            <div>
              <div style="border:1px solid #aeb6bf;width:100%;padding:30px;border-radius:8px;background:#eaf2f8;">
                <template>
                  <img src="images/vaccine.png" alt="Vacuna">  <h4 style="display:inline;">VACUNAS</h4>

                  <button data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" @click="mostrarVacunas"><!---->
                    <i class="el-icon-plus" />
                    <span>Añadir</span>
                  </button>
                </template>
              </div>
              <div id="mostrar" style="border:1px solid #aeb6bf;width:100%;padding:30px 20px 50px 20px;border-radius: 0px 0px 8px 8px;display:none;">
                <el-form-item label="Tipo de vacuna" prop="vaccine_id">
                  <el-select v-model="form.vaccine_id" placeholder="Tipo Vacuna" style="width: 90%;">
                    <el-option
                      v-for="item in optionsVaccine"
                      :key="item.value"
                      :label="item.label"
                      :value="item.value"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item label="Detalles adicionales">
                  <el-input v-model="form.vaccine_observation" type="textarea" style="width: 90%;" />
                </el-form-item>
                <button data-v-d3a7d412="" type="button" class="el-button el-button--danger el-button--medium borrar" style="float: right;margin-left:20px;" @click="ocultarVacunas"><!----><i class="el-icon-delete" />
                  <span>Borrar</span>
                </button>
              </div>
            </div>
            <br>
            <div>
              <div style="border:1px solid #aeb6bf;width:100%;padding:30px;border-radius:8px;background:#eaf2f8;">
                <template>
                  <img src="images/medicamento.png" alt="Vacuna">  <h4 style="display:inline;"> ANTIPARASITARIOS</h4>

                  <button data-v-d3a7d412="" type="button" class="el-button el-button--primary el-button--medium" style="float: right;margin-botton:15px;" @click="mostrarDesparasitacion"><!---->
                    <i class="el-icon-plus" />
                    <span>Añadir</span>
                  </button>
                </template>
              </div>
              <div id="mostrar1" style="border:1px solid #aeb6bf;width:100%;padding:30px 20px 50px 20px;border-radius: 0px 0px 8px 8px;display:none;">
                <el-form-item label="Tipo de antiparasitario" prop="antiparasitic_id">
                  <el-select v-model="form.antiparasitic_id" placeholder="Desparacitante" style="width: 90%;">
                    <el-option
                      v-for="item in optionsAntiparasitic"
                      :key="item.value"
                      :label="item.label"
                      :value="item.value"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item label="Detalles adicionales">
                  <el-input v-model="form.antiparasitic_observation" type="textarea" style="width: 90%;" />
                </el-form-item>
                <button data-v-d3a7d412="" type="button" class="el-button el-button--danger el-button--medium borrar" style="float: right;margin-left:20px;" @click="ocultarDesparasitacion"><!----><i class="el-icon-delete" />
                  <span>Borrar</span>
                </button>
              </div>
            </div>
            <br>

            <div>
              <el-form-item label="Diagnostivo" prop="diagnostic">
                <el-input v-model="form.diagnostic" type="textarea" />
              </el-form-item>
              <el-form-item label="Patología" prop="pathology">
                <el-input v-model="form.pathology" type="textarea" />
              </el-form-item>
              <el-form-item label="Tratamiento" prop="treatment">
                <el-input v-model="form.treatment" type="textarea" />
              </el-form-item>
              <el-form-item label="Receta" prop="prescription">
                <el-input v-model="form.prescription" type="textarea" />
              </el-form-item>

              <el-form-item label="">
                <el-checkbox-group v-model="form.type">
                  <el-checkbox label="¿Enviar receta al cliente por correo?" name="type" />
                </el-checkbox-group>
              </el-form-item>
            </div>

            <br>

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
import { ListPersonal, ListClient, ListPet, ListVaccine, ListAntiparasitic } from '@/api/appointment';
import { fetchList, createHistory } from '@/api/clinic_history';
export default {
  data() {
    return {
      listLoading: false,
      total: 0,
      list: null,
      rules: {
        date: [{ required: true, message: 'type is required', trigger: 'change' }],
        personal_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        client_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        pet_id: [{ required: true, message: 'type is required', trigger: 'change' }],
        reason: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      optionsPersonal: [],
      optionsClient: [],
      optionsPet: [],
      optionsVaccine: [],
      optionsAntiparasitic: [],
      form: {
        id: undefined,
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
    this.getList();
    this.getListClient();
    this.getListVaccine();
    this.getListAntiparasitic();
    this.getListPersonal();
  },
  methods: {
    async getList() {
      this.listLoading = true;
      const { data } = await fetchList();
      this.list = data.items;

      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('visit', data.items);
    },
    onSubmit() {
      this.$refs['form'].validate((valid) => {
        if (valid) {
          const fechaHora = this.form.date.toLocaleString().split(' ');
          const formatFecha = (fechaHora[0]).split('/');
          // console.log(`${formatFecha[0]}-${formatFecha[1]}-${formatFecha[2]} ${fechaHora[1]}`);
          this.form.id = this.list[this.list.length - 1].id + 1;
          this.form.status = 1;
          this.form.date = `${formatFecha[2]}-${formatFecha[1]}-${formatFecha[0]} ${fechaHora[1]}`;
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

      console.log(this.$refs['form']);
      // this.$message('submit!');
    },
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning',
      });
    },
    mostrarVacunas() {
      const x = document.getElementById('mostrar');
      if (x.style.display === 'none') {
        x.style.display = 'block';
      } else {
        x.style.display = 'none';
      }
    },
    mostrarDesparasitacion() {
      const y = document.getElementById('mostrar1');
      if (y.style.display === 'none') {
        y.style.display = 'block';
      } else {
        y.style.display = 'none';
      }
    },
    ocultarVacunas() {
      const x = document.getElementById('mostrar');
      if (x.style.display === 'block') {
        x.style.display = 'none';
      } else {
        x.style.display = 'block';
      }
    },
    ocultarDesparasitacion() {
      const y = document.getElementById('mostrar1');
      if (y.style.display === 'block') {
        y.style.display = 'none';
      } else {
        y.style.display = 'block';
      }
    },
    resetTemp() {
      this.form = {
        id: undefined,
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

      };
    },
    async getListPersonal() {
      this.listLoading = true;
      const { data } = await ListPersonal();

      for (var i in data.items) {
        this.optionsPersonal.push({ value: data.items[i].id, label: data.items[i].first_name + ' ' + data.items[i].last_name });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('medicos', this.optionsPersonal);
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
    async getListVaccine() {
      this.listLoading = true;
      const { data } = await ListVaccine();

      for (var i in data.items) {
        this.optionsVaccine.push({ value: data.items[i].id, label: data.items[i].name_vaccines });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('vacunas', this.optionsVaccine);
    },
    async getListAntiparasitic() {
      this.listLoading = true;
      const { data } = await ListAntiparasitic();

      for (var i in data.items) {
        this.optionsAntiparasitic.push({ value: data.items[i].id, label: data.items[i].name_antiparasitic });
      }
      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('desparacitante', this.optionsAntiparasitic);
    },

  },
};
</script>

<style scoped>
.line{
  text-align: center;
}
</style>

