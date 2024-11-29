<template>
  <div>
    <input v-model="search" placeholder="Search articles" @input="fetchArticles" />
    <select v-model="selectedCategory" @change="fetchArticles">
      <option value="">All Categories</option>
      <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
    </select>
    <ul>
      <li v-for="article in articles" :key="article.id">
        <h2>{{ article.title }}</h2>
        <p v-html="article.content"></p>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            articles: [],
            categories: [],
            search: '',
            selectedCategory: '',
        };
    },
    methods: {
        async fetchArticles() {
            const { data } = await axios.get('http://localhost/api/articles', {
                params: { search: this.search, category: this.selectedCategory },
            });
            this.articles = data.data;
        },
    },
    created() {
        this.fetchArticles();
    },
};
</script>
