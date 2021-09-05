<script>

// import { defineComponent } from '@vue/composition-api'

import { fetchList } from '@/api/clinic_history';

export default {
  data() {
    return {
      list: null,
      listLoading: false,
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
  },

  methods: {
    async getList() {
      this.listLoading = true;
      const { data } = await fetchList();
      // this.list = data.items;

      // Just to simulate the time of the request
      this.listLoading = false;
      console.log('visit', data.items);
    },
  },
};
</script>
