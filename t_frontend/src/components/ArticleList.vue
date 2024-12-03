<script lang="ts">
  import { defineComponent, ref, computed, onMounted } from 'vue';
  import type { Article, Category } from '../types';
  import { useRouter } from 'vue-router';
  import { cacheArticle } from '../utils/cache';
  import axios from '../plugins/axios';

  export default defineComponent({
    props: {
      articles: {
        type: Array as () => Article[],
        required: true,
      },
      categories: {
        type: Array as () => Category[],
        required: true,
      },
      hasMorePages: {
        type: Boolean,
        required: true,
      },
      totalPages: {
        type: Number,
        required: true,
      },
      currentPage: {
        type: Number,
        required: true,
      },
    },
    setup(props, { emit }) {
      const categories = ref([]);
      const articles_by_categorie = ref([]);
      const search = ref('');
      const selectedCategory = ref('');

      const router = useRouter()

      const paginatedArticles = computed(() => {
        const start = (props.currentPage - 1) * 10
        return props.articles.slice(start, start + 10)
      })

      const viewArticle = (article: any) => {
        console.log('Navigating to article ID:', article.id);

        cacheArticle(article.id, article);
        router.push({ name: 'ArticleDetail', params: { id: article.id } });

      }

      const loadMore = () => {
        emit('loadMore')
      }

      const filteredArticles = computed(() => {
        return props.articles.filter((article) =>
          article.title.toLowerCase().includes(search.value.toLowerCase())
        );
      });

      // Charger les catégories
      const fetchCategories = async () => {
        try {
          const response = await axios.get('/categories');
          categories.value = response.data;
        } catch (error) {
          console.error('Erreur lors de la récupération des catégories :', error);
        }
      };

      onMounted(() => {
        fetchCategories();
      });

      return {
        paginatedArticles,
        viewArticle,
        loadMore,
        categories,
        articles_by_categorie,
        search,
        selectedCategory,
        filteredArticles,
      }
    },
    methods: {
      async onChange() {
        try {
          console.log("categorie", this.selectedCategory);
          if (this.selectedCategory === "all") {
            this.articles_by_categorie = [];
          }
          else {
            const response = await axios.get(`/articles/categories/${this.selectedCategory}`);
            this.articles_by_categorie = response.data;
          }          
          console.log("resultats", this.articles_by_categorie);
        } catch (error) {
          console.error('Erreur lors de la récupération des articles :', error);
        }
      }
    }
  });
</script>

<template>
  <div class="article-view">
    <!-- Champs de recherche et catégorie -->
    <div class="search-and-filter">
      <input type="text"
             v-model="search"
             placeholder="Rechercher..."
             class="border border-gray-300 p-2 rounded w-full md:w-1/2 focus:outline-none focus:ring-2 focus:ring-primary" />
      <select v-model="selectedCategory"
              class="border border-gray-300 p-2 rounded w-full md:w-1/4 focus:outline-none focus:ring-2 focus:ring-primary"
              @change="onChange">
        <option value="all">Toutes les catégories</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>
    </div>

    <!-- Grille d'articles -->

    <div v-if="articles_by_categorie.length > 0">
      <div class="articles-grid">
        <div v-for="article in articles_by_categorie"
             :key="article.id"
             class="article-box">
          <img :src="article.featured_media || 'default-image.jpg'"
               alt="Article Image"
               class="w-full h-40 object-cover" />
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate">
              {{ article.title }}
            </h3>

            <h5 class="text-lg font-bold text-gray-800 mb-2 truncate">
              By {{ article.author_slug }}
            </h5>
            <p class="text-sm text-gray-600">
              <img :src="article.author_avatar" alt="Article Image" class="w-full h-40 object-cover" style="max-width:96px;" />
            </p>
            <p class="text-sm text-gray-600">
              <button @click="viewArticle(article)">Voir Plus</button>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="articles-grid">
        <div v-for="article in filteredArticles"
             :key="article.id"
             class="article-box">
          <img :src="article.featured_media || 'default-image.jpg'"
               alt="Article Image"
               class="w-full h-40 object-cover" />
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 truncate">
              {{ article.title }}
            </h3>

            <h5 class="text-lg font-bold text-gray-800 mb-2 truncate">
              By {{ article.author_slug }}
            </h5>
            <p class="text-sm text-gray-600">
              <img :src="article.author_avatar" alt="Article Image" class="w-full h-40 object-cover" style="max-width:96px;" />
            </p>
            <p class="text-sm text-gray-600">
              <button @click="viewArticle(article)">Voir Plus</button>
            </p>
          </div>
        </div>
      </div>
    </div>    

    <!-- Bouton Suivant -->
    <div v-if="hasMorePages" class="text-center mt-6 article-more">
      <button @click="$emit('loadNextPage')"
              class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">
        Plus d'articles
      </button>
    </div>

  </div>
</template>

<style scoped>
  .articles-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 articles par ligne */
    gap: 20px;
  }

  .article-box {
    border: 1px solid #ddd;
    padding: 20px;
    text-align: center;
    background-color: #f9f9f9;
    border-radius: 8px;
  }

  .article-box img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
  }

  .article-view {
    width: max-content;
  }

  .article-more {
    margin-top: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    gap: 20px;
  }

  .search-and-filter {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
  }

</style>
