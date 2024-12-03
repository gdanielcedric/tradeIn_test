const articleCache = new Map<number, any>()

export const getCachedArticle = (id: number) => {
  console.log("Getting article from cache:", id, articleCache.get(id));
  return articleCache.get(id);
};

export const cacheArticle = (id: number, article: any) => {
  articleCache.set(id, article)
}

export const isArticleCached = (id: number) => articleCache.has(id)
