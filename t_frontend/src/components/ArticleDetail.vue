<template>
  <div class="p-4">
    <div v-if="article">
      <h1 class="text-3xl font-bold">{{ article.title }}</h1>
      <div class="mt-4" v-html="article.content"></div>  <!-- Affichage du contenu HTML -->
    </div>
    <div v-else>
      <p>Chargement...</p>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue';
import axios from '../plugins/axios';
import { Article } from '../types';
import { useRoute } from 'vue-router';

export default defineComponent({
  setup() {
    const article = ref<Article | null>(null);
    const route = useRoute(); // Accéder à l'ID de l'article depuis l'URL

    onMounted(async () => {
      const articleId = route.params.id;
      try {
        const response = await axios.get(`/articles/${articleId}`);
        article.value = response.data;
      } catch (error) {
        console.error('Erreur lors du chargement de l\'article:', error);
      }
    });

    return { article };
  },
});
</script>

<style scoped>
  /* Style pour la page de détail */
</style>
