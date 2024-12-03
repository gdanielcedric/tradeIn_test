import { createRouter, createWebHistory } from 'vue-router';
import ArticleList from '../components/ArticleList.vue';
import ArticleDetail from '../components/ArticleDetail.vue';

const routes = [
  { path: '/', name: 'Home', component: ArticleList },
  {
    path: '/article/:id',
    name: 'ArticleDetail',
    component: ArticleDetail,
    props: true,
    key: (route) => route.params.id, // Clé basée sur l'ID
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
