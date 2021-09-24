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
          <p>{{ user.nombre_mascota }}</p>
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
        <router-link class="el-button el-button--success el-button--small" to="/mascotas/list" style="width: 100%;font-size:14px;">
          <i class="el-icon-back" /> Regresar
        </router-link>

      </div>
    </div>
  </el-card>
</template>

<script>
import PanThumb from '@/components/PanThumb';

export default {
  components: { PanThumb },
  props: {
    user: {
      type: Object,
      default: () => {
        return {
          nombre_mascota: '',
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
    return {
      info: {},
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
