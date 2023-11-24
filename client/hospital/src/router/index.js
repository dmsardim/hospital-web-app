import { createRouter, createWebHistory } from 'vue-router';
import PatientList from '../views/PatientList.vue';
import Form from '../views/Form.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: PatientList,
    },
    {
      path: '/add',
      name: 'add',
      component: Form,
    },
    {
      path: '/detail/:id',
      name: 'form',
      component: Form,
    },
  ],
});

export default router;
