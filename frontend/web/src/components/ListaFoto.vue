<template>
  <div class="lista-foto">

    <!-- Successo invio -->
    <div v-if="submitted" class="text-center py-5">
      <div class="display-1 mb-3">✓</div>
      <h2>Richiesta inviata!</h2>
      <p class="text-muted">Ti contatteremo all'indirizzo <strong>{{ form.email }}</strong>.</p>
      <a href="/" class="btn btn-outline-primary mt-3">Torna alla home</a>
    </div>

    <!-- Lista vuota -->
    <div v-else-if="fotos.length === 0" class="text-center py-5">
      <p class="text-muted fs-5">La tua lista è vuota.</p>
      <a href="/" class="btn btn-primary">Seleziona delle foto</a>
    </div>

    <!-- Contenuto principale -->
    <div v-else class="row g-4">

      <!-- Colonna foto -->
      <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0">{{ fotos.length }} {{ fotos.length === 1 ? 'foto selezionata' : 'foto selezionate' }}</h4>
          <button class="btn btn-sm btn-outline-danger" @click="clearAll">Svuota lista</button>
        </div>

        <div class="row row-cols-2 row-cols-md-3 g-3">
          <div v-for="foto in fotos" :key="foto.id" class="col">
            <div class="lista-card card h-100">
              <div class="lista-card__img-wrap">
                <img :src="foto.url" class="card-img-top lista-card__img" :alt="foto.caption" loading="lazy">
                <button class="lista-card__remove" @click="remove(foto.id)" title="Rimuovi">×</button>
              </div>
              <div v-if="foto.caption" class="card-body p-2">
                <p class="small text-muted mb-0">{{ foto.caption }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Form -->
      <div class="col-lg-4">
        <div class="card sticky-top" style="top: 80px;">
          <div class="card-header fw-bold">I tuoi dati</div>
          <div class="card-body">
            <form @submit.prevent="submitForm" novalidate>

              <div class="mb-3">
                <label class="form-label">Nome <span class="text-danger">*</span></label>
                <input
                  v-model.trim="form.nome"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': errors.nome }"
                  autocomplete="given-name"
                >
                <div v-if="errors.nome" class="invalid-feedback">{{ errors.nome }}</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Cognome <span class="text-danger">*</span></label>
                <input
                  v-model.trim="form.cognome"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': errors.cognome }"
                  autocomplete="family-name"
                >
                <div v-if="errors.cognome" class="invalid-feedback">{{ errors.cognome }}</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input
                  v-model.trim="form.email"
                  type="email"
                  class="form-control"
                  :class="{ 'is-invalid': errors.email }"
                  autocomplete="email"
                >
                <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Note</label>
                <textarea v-model="form.note" class="form-control" rows="3" placeholder="Eventuali richieste..."></textarea>
              </div>

              <div v-if="serverError" class="alert alert-danger py-2 small">{{ serverError }}</div>

              <button type="submit" class="btn btn-primary w-100" :disabled="submitting">
                <span v-if="submitting">
                  <span class="spinner-border spinner-border-sm me-1"></span> Invio...
                </span>
                <span v-else>Invia richiesta</span>
              </button>

            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const LS_KEY = 'garaFotoLista';

const fotos       = ref([]);
const submitted   = ref(false);
const submitting  = ref(false);
const serverError = ref('');

const form = ref({ nome: '', cognome: '', email: '', note: '' });
const errors = ref({});

onMounted(() => {
  try { fotos.value = JSON.parse(localStorage.getItem(LS_KEY) || '[]'); }
  catch { fotos.value = []; }
});

function saveList() {
  localStorage.setItem(LS_KEY, JSON.stringify(fotos.value));
}

const remove = (id) => {
  fotos.value = fotos.value.filter((f) => f.id !== id);
  saveList();
};

const clearAll = () => {
  fotos.value = [];
  localStorage.removeItem(LS_KEY);
};

function validate() {
  const e = {};
  if (!form.value.nome)    e.nome    = 'Il nome è obbligatorio.';
  if (!form.value.cognome) e.cognome = 'Il cognome è obbligatorio.';
  if (!form.value.email)   e.email   = "L'email è obbligatoria.";
  else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email))
    e.email = 'Inserisci un indirizzo email valido.';
  errors.value = e;
  return Object.keys(e).length === 0;
}

async function submitForm() {
  serverError.value = '';
  if (!validate()) return;

  submitting.value = true;

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

  try {
    const res = await fetch('/lista/invia', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': csrfToken,
      },
      body: JSON.stringify({
        ...form.value,
        fotoIds: fotos.value.map((f) => f.id),
      }),
    });

    const data = await res.json();

    if (!res.ok || data.error) {
      serverError.value = data.error || 'Errore durante l\'invio. Riprova.';
    } else {
      localStorage.removeItem(LS_KEY);
      submitted.value = true;
    }
  } catch {
    serverError.value = 'Errore di connessione. Riprova.';
  } finally {
    submitting.value = false;
  }
}
</script>
