import { createApp } from 'vue';
import ListaFoto from './components/ListaFoto.vue';

export function initListaFoto() {
  const el = document.getElementById('lista-foto');
  if (!el) return;
  createApp(ListaFoto).mount(el);
}
