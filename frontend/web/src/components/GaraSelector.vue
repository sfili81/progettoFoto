<template>
  <div class="gara-selector">

    <div v-if="fotos.length === 0" class="alert alert-info">
      Nessuna foto disponibile per questa gara.
    </div>

    <div v-else class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 pb-5">
      <div v-for="foto in fotos" :key="foto.id" class="col">
        <div
          class="foto-card card h-100"
          :class="{ 'foto-card--selected': isInList(foto.id) }"
          @click="openModal(foto)"
        >
          <div class="foto-badge">✓</div>
          <div class="foto-img-wrap">
            <img :src="foto.url" class="foto-img card-img-top" :alt="foto.caption" loading="lazy">
            <img v-if="logoUrl" :src="logoUrl" class="foto-watermark" alt="">
          </div>
          <div v-if="foto.caption" class="card-body p-2 mt-auto">
            <p class="card-text small text-muted mb-0">{{ foto.caption }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal foto -->
    <teleport to="body">
      <transition name="fade">
        <div v-if="modalFoto" class="foto-modal-overlay" @click.self="closeModal">
          <div class="foto-modal-box">
            <button class="foto-modal-close" @click="closeModal" aria-label="Chiudi">✕</button>
            <div class="foto-modal-img-wrap">
            <img :src="modalFoto.url" :alt="modalFoto.caption" class="foto-modal-img">
            <img v-if="logoUrl" :src="logoUrl" class="foto-watermark foto-watermark--lg" alt="">
          </div>
            <p v-if="modalFoto.caption" class="foto-modal-caption">{{ modalFoto.caption }}</p>
            <button
              class="btn btn-primary mt-3 px-4"
              :disabled="isInList(modalFoto.id)"
              @click="addToList"
            >
              <span v-if="isInList(modalFoto.id)">✓ Già in lista</span>
              <span v-else>Aggiungi alla lista</span>
            </button>
          </div>
        </div>
      </transition>
    </teleport>

    <!-- Toast notifica -->
    <teleport to="body">
      <transition name="toast-slide">
        <div v-if="toastVisible" class="foto-toast">
          ✓ Foto aggiunta alla lista
        </div>
      </transition>
    </teleport>

    <!-- Bar lista -->
    <transition name="slide-up">
      <div v-if="listCount > 0" class="selection-bar">
        <div class="container d-flex align-items-center gap-2 gap-md-3">
          <span class="fw-bold text-white text-nowrap">
            {{ listCount }} {{ listCount === 1 ? 'foto in lista' : 'foto in lista' }}
          </span>
          <div class="d-flex gap-2 ms-auto flex-shrink-0">
            <a :href="listaUrl" class="btn btn-sm btn-outline-light text-nowrap">
              Vedi lista
            </a>
          </div>
        </div>
      </div>
    </transition>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const LS_KEY = 'garaFotoLista';

const props = defineProps({
  fotos:    { type: Array,  default: () => [] },
  listaUrl: { type: String, default: '/lista/index' },
  logoUrl:  { type: String, default: '' },
});

const modalFoto    = ref(null);
const listCount    = ref(0);
const listaIds     = ref(new Set());
const toastVisible = ref(false);
let toastTimer = null;

onMounted(() => {
  const list = getList();
  listCount.value = list.length;
  listaIds.value  = new Set(list.map((f) => f.id));
});

function getList() {
  try { return JSON.parse(localStorage.getItem(LS_KEY) || '[]'); }
  catch { return []; }
}

const isInList = (id) => listaIds.value.has(id);

const openModal = (foto) => {
  modalFoto.value = foto;
};

const closeModal = () => {
  modalFoto.value = null;
};

const showToast = () => {
  toastVisible.value = true;
  if (toastTimer) clearTimeout(toastTimer);
  toastTimer = setTimeout(() => { toastVisible.value = false; }, 3000);
};

const addToList = () => {
  if (!modalFoto.value || isInList(modalFoto.value.id)) return;

  const current = getList();
  current.push(modalFoto.value);
  localStorage.setItem(LS_KEY, JSON.stringify(current));
  listCount.value = current.length;
  listaIds.value  = new Set(current.map((f) => f.id));

  closeModal();
  showToast();
};
</script>

<style scoped>
.foto-img-wrap {
  position: relative;
  overflow: hidden;
}

.foto-modal-img-wrap {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.foto-watermark {
  position: absolute;
  bottom: 8px;
  right: 8px;
  width: 28%;
  max-width: 90px;
  pointer-events: none;
  filter: grayscale(1) brightness(2) opacity(0.45);
  mix-blend-mode: luminosity;
}

.foto-watermark--lg {
  width: 20%;
  max-width: 140px;
  bottom: 12px;
  right: 12px;
  filter: grayscale(1) brightness(2) opacity(0.5);
}

.foto-modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.82);
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

.foto-modal-box {
  position: relative;
  background: #fff;
  border-radius: 8px;
  padding: 1.25rem;
  max-width: min(90vw, 860px);
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  overflow: hidden;
}

.foto-modal-close {
  position: absolute;
  top: 0.5rem;
  right: 0.6rem;
  background: none;
  border: none;
  font-size: 1.25rem;
  line-height: 1;
  color: #555;
  cursor: pointer;
  z-index: 10;
}

.foto-modal-close:hover {
  color: #000;
}

.foto-modal-img {
  max-width: 100%;
  max-height: calc(90vh - 8rem);
  object-fit: contain;
  border-radius: 4px;
}

.foto-modal-caption {
  margin-top: 0.6rem;
  margin-bottom: 0;
  font-size: 0.875rem;
  color: #555;
  text-align: center;
}

/* toast */
.foto-toast {
  position: fixed;
  bottom: 5rem;
  left: 50%;
  transform: translateX(-50%);
  background: #198754;
  color: #fff;
  padding: 0.65rem 1.4rem;
  border-radius: 6px;
  font-size: 0.95rem;
  font-weight: 500;
  box-shadow: 0 4px 16px rgba(0,0,0,0.22);
  z-index: 1100;
  white-space: nowrap;
}

.toast-slide-enter-active,
.toast-slide-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}
.toast-slide-enter-from,
.toast-slide-leave-to {
  opacity: 0;
  transform: translateX(-50%) translateY(10px);
}

/* fade transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.18s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
