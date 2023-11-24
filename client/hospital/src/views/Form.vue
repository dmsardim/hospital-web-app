<script>
import { mapActions, mapState, mapWritableState } from 'pinia';
import { usePatientStore } from '../stores/patients';
import InputField from '../components/inputfield.vue';

export default {
  components: {
    InputField,
  },
  // props: {},
  data() {
    return {
      sexOptions: [
        { value: 'male', label: 'Male' },
        { value: 'female', label: 'Female' },
      ],
      religionOptions: [
        { value: 'islam', label: 'Islam' },
        { value: 'christiany', label: 'Christiany' },
        { value: 'hindu', label: 'Hindu' },
        { value: 'buddha', label: 'Buddha' },
        { value: 'konghucu', label: 'Konghucu' },
        { value: 'animisme', label: 'Animisme' },
      ],
      localMode: '',
      //////
      id: this.$route.params.id,
      name: '',
      address: '',
      sex: '',
      religion: '',
      phone: '',
      nik: '',
    };
  },
  computed: {
    ...mapState(usePatientStore, ['patientDetail']),
  },

  methods: {
    ...mapActions(usePatientStore, ['fetchPatientDetail', 'addPatient', 'editPatient', 'addOrEdit']),

    getTitle() {
      switch (this.$route.query.mode) {
        case 'add':
          return 'Add Patient';
        case 'edit':
          return 'Edit Patient';
        case 'detail':
          return 'Detail Patient';
        default:
          return '';
      }
    },

    getFieldProps(label, type = 'text', options = {}) {
      const value = this.localMode === 'add' ? '' : this.patientDetail[label.toLowerCase()];
      const readonly = this.localMode === 'detail';
      const disabled = this.localMode === 'detail';
      return { label, type, value, readonly, disabled, ...options };
    },
    submitForm() {
      const formData = {
        name: this.name,
        address: this.address,
        sex: this.sex,
        religion: this.religion,
        phone: this.phone,
        nik: this.nik,
      };

      this.addOrEdit(formData, this.id);
    },
  },
  async created() {
    const queryMode = this.$route.query.mode;
    if (queryMode) {
      this.localMode = queryMode;
    }
    if (this.id) {
      this.fetchPatientDetail(this.id).then(() => {
        this.name = this.patientDetail.name;
        this.address = this.patientDetail.address;
        this.sex = this.patientDetail.sex;
        this.religion = this.patientDetail.religion;
        this.phone = this.patientDetail.phone;
        this.nik = this.patientDetail.nik;
      });
    }
  },
};
</script>

<template>
  <form @submit.prevent="submitForm" class="mx-48">
    <h3 class="mb-8 font-semibold">{{ getTitle() }}</h3>
    <InputField v-model:value="name" v-bind="getFieldProps('Name')" />
    <InputField v-model:value="address" v-bind="getFieldProps('Address')" />
    <div class="grid grid-cols-2 gap-6 mb-10">
      <InputField v-model:value="sex" v-bind="getFieldProps('Sex', 'select', { options: sexOptions })" class="mb-4" />
      <InputField v-model:value="religion" v-bind="getFieldProps('Religion', 'select', { options: religionOptions })" class="mb-4" />
    </div>
    <div class="grid grid-cols-2 gap-6">
      <InputField v-model:value="phone" v-bind="getFieldProps('Phone')" />
      <InputField v-model:value="nik" v-bind="getFieldProps('NIK')" />
    </div>

    <button
      v-if="localMode !== 'detail'"
      type="submit"
      class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    >
      Submit
    </button>
  </form>
</template>
