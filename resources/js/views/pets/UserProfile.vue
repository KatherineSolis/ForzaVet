<template>
  <div class="app-container">
    <el-form v-if="user" :model="user">
      <el-row :gutter="20">
        <el-col :span="6">
          <user-card :user="user" />
          <!-- <user-bio /> -->
        </el-col>
        <el-col :span="18">
          <user-activity :user="user" />
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
    };
  },
  watch: {
    '$route': 'getUser',
  },
  created() {
    const id = this.$route.params && this.$route.params.id;
    const currentUserId = this.$store.getters.userId;
    console.log(id);
    console.log(currentUserId);
    if (id === currentUserId) {
      // this.$router.push('/profile/edit');
      console.log('en el if');
      return;
    }
    this.getUser(id);
  },
  methods: {
    async getUser(id) {
      console.log('en la funcion ' + id);
      const { data } = await getPet(id);
      this.user = data.items[0];
      // console.log(data);
      console.log(this.user);
    },
  },
};
</script>
