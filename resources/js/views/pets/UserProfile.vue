<template>
  <div class="app-container">
    <el-form v-if="user">
      <el-row :gutter="20">
        <el-col :span="6">
          <user-card :user="user" :temp="temp"/>
          <!-- <user-bio /> -->
        </el-col>
        <el-col :span="18">
          <user-activity :user="user" :historial="historial" :vaccine="vaccine" :antiparasitic="antiparasitic" :peluqueria="peluqueria" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
// import Resource from '@/api/resource';
// import UserBio from './components/UserBio';
import UserCard from './components/UserCard';
import UserActivity from './components/UserActivity';
import { getPet } from '@/api/pet';

// const userResource = new Resource('pets');
export default {
  name: 'EditPet',
  components: { UserCard, UserActivity },
  data() {
    return {
      user: {},
      historial: [],
      vaccine: [],
      antiparasitic: [],
      peluqueria: [],
      temp:[],
    };
  },
  watch: {
    '$route': 'getUser',
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    const currentUserId = this.$store.getters.userId;
    if (id === currentUserId) {
      // this.$router.push('/profile/edit');
      // console.log('en el if');
      return;
    }
    this.getUser(id);
  },
  methods: {
    async getUser(id) {
      const { data } = await getPet(id);
      this.user = data.items[0];
      this.historial = data.historial;
      this.vaccine = data.vaccine;
      this.antiparasitic = data.antiparasitic;
      this.peluqueria = data.peluqueria;
      this.temp = data.items[0];
      // console.log('usuario tipo: '+ typeof this.user, 'tipo historial: '+ typeof this.historial, 'tipo vaccine: '+ typeof this.vaccine, 'tipo antiparasitic: '+ typeof this.antiparasitic, typeof this.antiparasitic, typeof this.peluqueria);
    },
  },
};
</script>
