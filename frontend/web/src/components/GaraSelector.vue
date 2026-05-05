<template>
  <div class="gara-selector">

    <div v-if="fotos.length === 0" class="alert alert-info">
      Nessuna foto disponibile per questa gara.
    </div>

    <div v-else class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 pb-5">
      <div v-for="foto in fotos" :key="foto.id" class="col">
        <div
          class="foto-card card h-100"
          :class="{ 'foto-card--selected': isSelected(foto.id) }"
          @click="toggle(foto)"
        >
          <div class="foto-badge">✓</div>
          <img :src="foto.url" class="foto-img card-img-top" :alt="foto.caption" loading="lazy">
          <div v-if="foto.caption" class="card-body p-2">
            <p class="card-text small text-muted mb-0">{{ foto.caption }}</p>
          </div>
        </div>
      </div>
    </div>

    <transition name="slide-up">
      <div v-if="selected.length > 0" class="selection-bar">
        <div class="container d-flex align-items-center gap-2 gap-md-3">

          <span class="fw-bold text-white text-nowrap">
            {{ selected.length }} {{ selected.length === 1 ? 'selezionata' : 'selezionate' }}
          </span>

          <div class="selection-thumbs d-flex gap-1 flex-grow-1 overflow-hidden">
            <img
              v-for="f in selected"
              :key="f.id"
              :src="f.url"
              :alt="f.caption"
              class="selection-thumb"
            >
          </div>

          <div class="d-flex gap-2 ms-auto flex-shrink-0">
            <button class="btn btn-sm btn-primary text-nowrap" @click="addToList">
              <span v-if="addedFlash">✓ Aggiunto!</span>
              <span v-else>Aggiungi alla lista</span>
            </button>
            <a :href="listaUrl" class="btn btn-sm btn-outline-light text-nowrap">
              Vedi lista<span v-if="listCount > 0"> ({{ listCount }})</span>
            </a>
            <button class="btn btn-sm btn-outline-secondary text-nowrap" @click="clearAll">
              Deseleziona
            </button>
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
});

const selected   = ref([]);
const listCount  = ref(0);
const addedFlash = ref(false);

onMounted(() => {
  listCount.value = getList().length;
});

function getList() {
  try { return JSON.parse(localStorage.getItem(LS_KEY) || '[]'); }
  catch { return []; }
}

const isSelected = (id) => selected.value.some((f) => f.id === id);

const toggle = (foto) => {
  const idx = selected.value.findIndex((f) => f.id === foto.id);
  if (idx === -1) selected.value.push(foto);
  else selected.value.splice(idx, 1);
};

const clearAll = () => { selected.value = []; };

const addToList = () => {
  if (selected.value.length === 0) return;

  const current    = getList();
  const currentIds = new Set(current.map((f) => f.id));
  const merged     = [...current, ...selected.value.filter((f) => !currentIds.has(f.id))];

  localStorage.setItem(LS_KEY, JSON.stringify(merged));
  listCount.value = merged.length;
  selected.value  = [];

  addedFlash.value = true;
  setTimeout(() => { addedFlash.value = false; }, 2000);
};
</script>
