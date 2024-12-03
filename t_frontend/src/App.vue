<template>
  <div class="container mx-auto p-6">
    <!-- Liste des articles -->
    <!--<ArticleList :articles="articles"
                 :hasMorePages="hasMorePages"
                 @loadNextPage="loadNextPage" />-->

    <router-view :articles="articles" :hasMorePages="hasMorePages" @loadNextPage="loadNextPage" />
  </div>
</template>

<script lang="ts">
  import { defineComponent, ref, reactive, onMounted, computed } from 'vue';
  import ArticleList from './components/ArticleList.vue';
  import axios from './plugins/axios';

  export default defineComponent({
    components: { ArticleList },
    setup() {
      const articles = ref([]);
      const currentPage = ref(1);
      const itemsPerPage = 10;
      const totalArticles = ref(0);

      // Charger les articles avec pagination
      const fetchArticles = async () => {
        const params = {
          page: currentPage.value,
          limit: itemsPerPage,
        };
        console.log('parameters', params);
        try {
          const response = await axios.get('/articles', { params });
          articles.value = response.data.data; // Les articles paginés
          totalArticles.value = response.data.total; // Nombre total d'articles
        } catch (error) {
          console.error('Erreur lors de la récupération des articles :', error);
        }
      };

      // Charger la page suivante
      const loadNextPage = () => {
        if (hasMorePages.value) {
          currentPage.value++;
          fetchArticles();
        }
      };

      // Vérifie s'il reste des pages
      const hasMorePages = computed(() => {
        return currentPage.value * itemsPerPage < totalArticles.value;
      });

      onMounted(() => {
        fetchArticles();
      });

      return {
        articles,
        loadNextPage,
        hasMorePages,
      };
    },
  });
</script>
