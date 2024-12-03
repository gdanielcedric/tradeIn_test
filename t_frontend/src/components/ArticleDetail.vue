<template>
  <div>
    <h1 class="text-3xl font-bold mb-4">{{ article?.title }}</h1>
    <img :src="article?.featured_media || '../default-image.jpg'"
         alt="Article Image"
         class="w-full max-h-80 object-cover mb-4" />
    <div v-html="article?.content" class="prose"></div>
  </div>
</template>

<script lang="ts">
  import { defineComponent, onMounted, ref, watch } from 'vue'
  import { useRoute } from 'vue-router'
  import { getCachedArticle } from '../utils/cache'
  import axios from '../plugins/axios'

  export default defineComponent({
    setup() {
      const route = useRoute()
      const article = ref<any | null>(null)

      console.log('ArticleDetail.vue loaded');

      const fetchArticle = async (id: number) => {
        const cached = getCachedArticle(id)
        if (cached) {
          article.value = cached
        } else {
          const { data } = await axios.get(`/articles/${id}`)
          article.value = data
        }
      }

      onMounted(() => {
        const id = Number(route.params.id);
        console.log("Navigated to article ID:", id);
        fetchArticle(id);
      });

      // Watch for route changes
      watch(
        () => route.params.id,
        (newId) => {
          fetchArticle(Number(newId));
        }
      );

      return {
        article,
      }
    },
  })
</script>

<style scoped>
  .prose {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
  }

  h1 {
    font-size: 2rem;
    color: #333;
  }

</style>
