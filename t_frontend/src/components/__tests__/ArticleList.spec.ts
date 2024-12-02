
import { mount } from '@vue/test-utils';
import ArticleList from '../../components/ArticleList.vue';
import { describe, it, expect } from 'vitest'

describe('ArticleList.vue', () => {
  it('affiche le message d\'erreur si l\'API échoue', async () => {
    const wrapper = mount(ArticleList);
    wrapper.setData({ errorMessage: 'Erreur de test' });

    expect(wrapper.text()).toContain('Erreur de test');
  });
});
