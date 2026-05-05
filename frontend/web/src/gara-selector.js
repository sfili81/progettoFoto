import { createApp } from 'vue';
import GaraSelector from './components/GaraSelector.vue';

export function initGaraSelector() {
  const el = document.getElementById('gara-selector');
  if (!el) return;

  const fotos = JSON.parse(el.dataset.fotos || '[]');
  createApp(GaraSelector, { fotos }).mount(el);
}
