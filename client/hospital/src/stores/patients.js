import { defineStore } from 'pinia';
import axios from 'axios';
import Toast from 'awesome-toast-component';

export const usePatientStore = defineStore('patients', {
  state: () => ({
    baseUrl: 'http://localhost:8000',
    patients: [],
    patientDetail: {},
  }),
  getters: {},
  actions: {
    success(msg) {
      new Toast(`${msg}`, {
        position: 'top',
        style: {
          container: [['background-color', 'green']],
          message: [['color', '#eee']],
          bold: [['font-weight', 'bold']],
        },
      });
    },
    error(err) {
      new Toast(`${err}`, {
        position: 'top',
        style: {
          container: [['background-color', 'red']],
          message: [['color', '#eee']],
          bold: [['font-weight', 'bold']],
        },
      });
    },

    async fetchPatients(value) {
      try {
        const { data } = await axios.get(this.baseUrl + '/api/getPatients');
        this.patients = data;
      } catch (error) {
        console.log(error);
        this.error(error);
      }
    },

    async fetchPatientDetail(patientId) {
      try {
        const { data } = await axios.get(this.baseUrl + '/api/getPatient/' + patientId);
        this.patientDetail = data.result;
      } catch (error) {
        console.log(error);
        this.error(error);
      }
    },

    async addOrEdit(value, id) {
      console.log(value, 'value', id, 'id');
      try {
        let data = {
          name: value.name,
          address: value.address,
          sex: value.sex,
          religion: value.religion,
          phone: value.phone,
          nik: value.nik,
        };
        const endpoint = id ? `/editPatient/${id}` : '/addPatient';
        const methods = id === '' ? 'put' : 'post';
        const api = axios.create({
          baseURL: 'http://localhost:8000/api',
        });
        await api[methods](endpoint, data, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        this.success(`Successfully ${id ? 'updated' : 'created'} patient`);
        this.router.push('/');
      } catch (error) {
        console.log(error);
        this.error(error);
      }
    },

    async deletePatient(patientId) {
      console.log(patientId, 'patientID');
      try {
        await axios.get(this.baseUrl + '/api/deletePatient/' + patientId);

        this.success(`Success delete patient`);

        this.fetchPatients();
        this.router.push('/');
      } catch (error) {
        console.log(error);
        this.error(error);
      }
    },
  },
});
