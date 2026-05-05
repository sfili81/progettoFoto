import { createApp } from 'vue';
import ListaFoto from './components/ListaFoto.vue';

export function initListaFoto() {
  const el = document.getElementById('lista-foto');
  if (!el) return;
  const inviaUrl = el.dataset.inviaUrl || '/lista/invia';
  createApp(ListaFoto, { inviaUrl }).mount(el);
}
