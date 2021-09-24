<template>
  <div class="dashboard-editor-container">
    <div class=" clearfix">
      <span style="font-size:35px;padding-top:10px;text-align:center;display:block;">BIENVENIDO AL SISTEMA</span>

      <div class="info-container">
        <span class="display_name">{{ name }}</span>

      </div>
    </div>
    <div>
      <img :src="emptyGif" class="emptyGif">
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'DashboardEditor',
  data() {
    return {
      emptyGif: 'https://cdn.dribbble.com/users/2309583/screenshots/4609423/vet_drib.gif',
    };
  },
  computed: {
    ...mapGetters([
      'name',
      'avatar',
      'roles',
    ]),
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  .emptyGif {
    display: block;
    width: 45%;
    margin: 0 auto;
  }

  .dashboard-editor-container {
    background-color:    #f2f4f4  ;
    min-height: 100vh;
    padding: 50px 60px 0px;
    .pan-info-roles {
      font-size: 12px;
      font-weight: 700;
      color:  #566573  ;
      display: block;
    }
    .info-container {
      margin-left: 190px;
      margin-top: 25px;
      margin-bottom: 20px;
      display: block;
      padding-left: 25%;

      .display_name {
        font-size: 28px;
        line-height: 48px;
        color:   #42b983  ;
        top: 25px;

      }
    }
  }
</style>
