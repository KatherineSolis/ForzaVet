<template>
  <el-card v-if="user.nombre_cliente">
    <div class="user-profile">
      <div class="user-avatar box-center">
        <pan-thumb v-if="user.specie ==='Canino'" image="https://www.bunko.pet/__export/1611884288964/sites/debate/img/2021/01/28/10_cosas_que_solo_el_duexo_de_un_golden_retriever_conoce.jpeg_1422213347.jpeg" :height="'100px'" :width="'100px'" :hoverable="false" />
        <pan-thumb v-else-if="user.specie ==='Felino'" image="https://thumbs.dreamstime.com/b/opini%C3%B3n-superior-el-gato-del-beb%C3%A9-en-el-fondo-blanco-25400601.jpg" :height="'100px'" :width="'100px'" :hoverable="false" />
        <pan-thumb v-else-if="user.specie ==='Roedores'" image="https://www.65ymas.com/uploads/s1/78/85/87/bigstock-lop-rabbit-1324524.jpeg" :height="'100px'" :width="'100px'" :hoverable="false" />
        <pan-thumb v-else image="https://estaticos.muyinteresante.es/media/cache/1140x_thumb/uploads/images/gallery/594a1ced5bafe85dfd3c9869/gato-romano_0.jpg" :height="'100px'" :width="'100px'" :hoverable="false" />
      </div>
      <div class="box-center">
        <div class="user-name text-center">
          <p>{{ user.name }}</p>
        </div>
        <div class="user-role text-center text-muted">
          <p>{{ user.specie }}</p>
        </div>
      </div>
      <div class="box-social">
        <div class="user-name text-center text-muted">
          <p>Nombre Propietario</p>
        </div>
        <div class="user-role text-center text-muted">
          <p>{{ user.nombre_cliente }}</p>
        </div>
        <div class="user-role text-center text-muted">
          <p>{{ user.email_cliente }}</p>
        </div>
      </div>

      <div class="user-follow">
        <el-button type="primary" icon="el-icon-edit" size="small" @click="handleUpdate(temp)" style="width: 100%;font-size:14px;">
          Editar 
          </el-button>

      </div>

      <div class="user-follow">
        <el-button class="el-button el-button--success el-button--small"  @click="regresar" style="width: 100%;font-size:14px;">
          <i class="el-icon-back" /> Regresar
        </el-button>
        <!--router-link class="el-button el-button--success el-button--small" to="/mascotas/list" style="width: 100%;font-size:14px;">
          <i class="el-icon-back" /> Regresar
        </router-link-->

      </div>
    </div>

     <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" style="min-width:100vh;">
          <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left">
            <el-form-item label="Nombre mascota" prop="name">
              <el-input v-model="temp.name" placeholder="Nombre mascota" />
            </el-form-item>
            
            <el-form-item label="Edad" prop="age" style="width: 100%;">
              <el-input v-model="temp.age" />
            </el-form-item>
            <!--el-form-item label="Edad" prop="age">
              <el-input v-model="temp.age" />
            </el-form-item-->
            <el-form-item label="Peso" prop="weight">
              <el-input v-model="temp.weight" />
            </el-form-item>
            <el-form-item label="Color" prop="color">
              <el-input v-model="temp.color" />
            </el-form-item>
            
            <el-form-item label="Castrado" prop="castrated">
              <el-input v-model="temp.castrated" />
            </el-form-item>
            <el-form-item label="Nivel de agresividad" prop="aggressiveness">
              <el-select v-model="temp.aggressiveness" placeholder="Seleccionar" style="width:100%">
                <el-option
                  v-for="itemagre in typeaggressiveness"
                  :key="itemagre.value"
                  :label="itemagre.label"
                  :value="itemagre.value"
                />
              </el-select>
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
</template>

<script>
import PanThumb from '@/components/PanThumb';
import {updatePet } from '@/api/pet';

export default {
  components: { PanThumb },
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          name: '',
          age: '',
          sex: '',
          weight: '',
          color: '',
          chip: '',
          specie: '',
          breed: '',
          nombre_cliente: '',
          email_cliente: '',
          roles: [],
        };
      },
    },
    temp: {
      type: Object,
      default: () => {
        return {
          name: '',
          age: '',
          sex: '',
          weight: '',
          color: '',
          chip: '',
          specie: '',
          breed: '',
          nombre_cliente: '',
          email_cliente: '',
          roles: [],
        };
      },
    },
  },
  data() {
    /*var numeros = (rule, value, callback) => {
      if (/^[0-9]$/.test(value)) {
              callback();
            } else {
              callback(new Error('solo se aceptan numeros'));
            }
    };*/
    return {
      info: {},
       /*temp: {
        id: undefined,
        name: '',
        age: '',
        sex: '',
        weight: '',
        color: '',
        chip: '',
        client_id: '',
        specie: '',
        breed: '',
        castrated: '',
        aggressiveness: '',
      },*/
      rules: {
        name: [{ required: true, message: 'type is required', trigger: 'change' }],
        age: [{ required: true, message: 'type is required', trigger: 'change' }],
        sex: [{ required: true, message: 'type is required', trigger: 'change' }],
        weight: [{ required: true, message: 'type is required', trigger: 'change' },
                { pattern: /^\d*$/, message: 'Must be all numbers', trigger: 'blur'},
                /*{ validator: numeros, trigger: ['blur'] }*/],
        color: [{ required: true, message: 'type is required', trigger: 'change' }],
        castrated: [{ required: true, message: 'type is required', trigger: 'change' }],
        aggressiveness: [{ required: true, message: 'type is required', trigger: 'change' }],
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: 'Editar',
        create: 'Crear',
        visualizar: 'Detalle de la mascota',
      },
      typeaggressiveness: [
        {
          value: '1',
          label: '1',
        },
        {
          value: '2',
          label: '2',
        },
        {
          value: '3',
          label: '3',
        },
        {
          value: '4',
          label: '4',
        },
        {
          value: '5',
          label: '5',
        }],
      social: [
        {
          'name': 'info.nombre_cliente',

        },
        {
          'name': 'melisa_rodriguez@gmail.com',

        },

      ],
    };
  },
  methods:{
      handleUpdate(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
    },
    regresar(){
      this.$router.go(-1);
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          updatePet(this.temp).then(() => {
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
          this.$router.go(0);
        }
      });
    },
    onlyNumber ($event) {
   //console.log($event.keyCode); //keyCodes value
   let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
   if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
      $event.preventDefault();
   }
}
  }
  /* created(){
    this.info = this.$refs;
    console.log("Datos: ");
    console.log(this.$props.user);
    console.log(this.user);
  }*/

};
</script>

<style lang="scss" scoped>
.user-profile {
  .user-name {
    font-weight: bold;
  }
  .box-center {
    padding-top: 10px;
  }
  .user-role {
    padding-top: 10px;
    font-weight: 400;
    font-size: 14px;
  }
  .box-social {
    padding-top: 30px;
    .el-table {
      border-top: 1px solid #dfe6ec;
    }
  }
  .user-follow {
    padding-top: 20px;
  }
}
</style>
