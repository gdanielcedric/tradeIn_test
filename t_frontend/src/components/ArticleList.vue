<template>
  <div>
    <!-- Barre de recherche et filtres -->
    <div class="flex justify-between mb-4">
      <input v-model="search"
             @input="fetchArticles()"
             class="border p-2 rounded"
             type="text"
             placeholder="Rechercher par titre ou contenu..." />
      <select v-model="selectedCategory" @change="fetchArticles()" class="border p-2 rounded">
        <option value="">Toutes les catégories</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>
    </div>

    <!-- Liste des articles -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
      <div v-for="article in articles" :key="article.id" class="card">
        <img :src="article.featured_media || 'default-image.jpg'" alt="Article Image" class="w-full h-40 object-cover">
        <div class="p-4">
          <h3 class="text-lg font-semibold">{{ article.title }}</h3>
          <router-link :to="{ name: 'article', params: { id: article.id } }" class="text-blue-500 mt-2 inline-block">Lire plus</router-link>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4 flex justify-center">
      <button class="p-2 mx-1 border rounded"
              :disabled="!pagination.prev_page_url"
              @click="fetchArticles(pagination.prev_page_url)">
        Précédent
      </button>
      <button class="p-2 mx-1 border rounded"
              :disabled="!pagination.next_page_url"
              @click="fetchArticles(pagination.next_page_url)">
        Suivant
      </button>
    </div>
  </div>
</template>

<script lang="ts">
  import { defineComponent, ref, onMounted } from 'vue';
  import axios from '../plugins/axios';
  import type { Article, Category } from '../types';

  export default defineComponent({
    name: 'ArticleList',
    setup() {
      // Typage des données
      const articles = ref([]); // Liste d'articles
      const categories = ref([]); // Liste de catégories
      const search = ref('');
      const selectedCategory = ref('');
      const pagination = ref({
        current_page: 1,
        next_page_url: "",
        prev_page_url: "",
      });

      const fetchCategories = async () => {
        try {
          const response = await axios.get('/categories');
          categories.value = response.data;
        } catch (error) {
          console.error('Erreur lors de la récupération des catégories :', error);
        }
      };

      const fetchArticles = async (url = '/articles?per_page=10') => {
        try {
          const params: Record<string, any> = { per_page: 10, search: search.value };
          if (selectedCategory.value) {
            params.category = selectedCategory.value;
          }

          const response = await axios.get(url, { params });
          articles.value = response.data.data; // Typé comme une liste d'Article
          pagination.value = {
            current_page: response.data.current_page,
            next_page_url: response.data.next_page_url,
            prev_page_url: response.data.prev_page_url,
          };
        } catch (error) {
          console.error('Erreur lors de la récupération des articles :', error);
        }
      };

      onMounted(() => {
        fetchCategories();
        fetchArticles();
      });

      return {
        articles,
        categories,
        search,
        selectedCategory,
        pagination,
        fetchArticles,
      };
    },
  });
</script>
<style scoped>
  .card {
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 5px 0 5px 0;
  }
</style>
