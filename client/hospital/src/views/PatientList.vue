<script>
import Navbar from '../components/Navbar.vue';
import { mapActions, mapState, mapWritableState } from 'pinia';
import { usePatientStore } from '../stores/patients';

export default {
  components: {
    Navbar,
  },

  methods: {
    ...mapActions(usePatientStore, ['fetchPatients', 'deletePatient']),

    goToDetailForm(patientId, mode) {
      console.log(patientId, 'patientId<<<>>>', mode, 'mode>>>>>');

      if (patientId) {
        this.$router.push({
          name: 'form',
          params: { id: patientId },
          query: { mode: mode },
        });
      } else {
        this.$router.push({
          name: 'add',
          query: { mode: mode },
        });
      }
    },
  },
  computed: {
    ...mapState(usePatientStore, ['patients']),
  },
  created() {
    this.fetchPatients();
  },
};
</script>

<template>
  <div class="mx-28">
    <button
      type="button"
      class="px-3 py-2 mb-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
    >
      <a href="#" @click.prevent="goToDetailForm(null, 'add')">Add Patient</a>
    </button>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 overflow-y-auto">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">No</th>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Sex</th>
            <th scope="col" class="px-6 py-3">Phone</th>
            <th scope="col" class="px-6 py-3 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(patient, index) in patients.result" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4">{{ index + 1 }}</td>
            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ patient.name }}</td>
            <td class="px-6 py-4">{{ patient.sex }}</td>
            <td class="px-6 py-4">{{ patient.phone }}</td>
            <td class="px-6 text-center">
              <a href="#" class="font-normal bg-slate-400 text-white rounded-xl px-3" @click.prevent="goToDetailForm(patient.id, 'detail')">Detail</a>
              <a href="#" class="font-normal bg-green-400 text-white rounded-xl px-3 ml-3" @click.prevent="goToDetailForm(patient.id, 'edit')">Edit</a>
              <a href="#" @click.prevent="deletePatient(patient.id)" class="font-normal bg-red-400 text-white rounded-xl px-3 ml-3">Delete</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
