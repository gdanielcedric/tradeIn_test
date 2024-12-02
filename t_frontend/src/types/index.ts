export interface Category {
  id: number;
  name: string;
}

export interface Article {
  id: number;
  title: string;
  slug: string;
  emoji: string;
  link: string;
  content: string;
  author_slug: string;
  author_avatar: string;
  featured_media: string;
  categories: Category[];
}
