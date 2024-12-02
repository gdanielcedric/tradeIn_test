import { createRouter, createWebHistory } from 'vue-router';
import ArticleList from '../components/ArticleList.vue';
import ArticleDetail from '../components/ArticleDetail.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: ArticleList,
  },
  {
    path: '/article/:id',
    name: 'article',
    component: ArticleDetail,
    props: true, // Permet de passer l'ID en tant que prop
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
