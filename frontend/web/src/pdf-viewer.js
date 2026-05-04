/* eslint-disable prettier/prettier */
import * as pdfjsLib from 'pdfjs-dist';

// Worker ES module (PDF.js 5.x)
const pdfWorker = new Worker(new URL('pdfjs-dist/build/pdf.worker.mjs', import.meta.url), {
  type: 'module',
});
pdfjsLib.GlobalWorkerOptions.workerPort = pdfWorker;

// Stato condiviso
let pdfDoc = null;
let currentPage = 1;
let totalPages = 0;
let scale = 1.2;
let canvas, ctx;

/*───────────────────────────────────────────────
  RENDER SINGOLA PAGINA
────────────────────────────────────────────────*/
async function renderPage(pageNum) {
  const page = await pdfDoc.getPage(pageNum);
  const viewport = page.getViewport({ scale });

  canvas.width = viewport.width;
  canvas.height = viewport.height;

  await page.render({
    canvasContext: ctx,
    viewport,
  }).promise;

  document.getElementById('pdf-current-page').textContent = currentPage;
}

/*───────────────────────────────────────────────
  RENDER MULTIPAGINA
────────────────────────────────────────────────*/
async function renderAllPages(containerId = 'pdf-pages') {
  const pagesContainer = document.getElementById(containerId);
  pagesContainer.innerHTML = '';

  for (let n = 1; n <= totalPages; n++) {
    const page = await pdfDoc.getPage(n);
    const viewport = page.getViewport({ scale });

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.width = viewport.width;
    canvas.height = viewport.height;

    await page.render({
      canvasContext: ctx,
      viewport,
    }).promise;

    pagesContainer.appendChild(canvas);
  }
}

/*───────────────────────────────────────────────
  BOTTONI SINGLE PAGE
────────────────────────────────────────────────*/
function bindControls(containerId) {
  const container = document.getElementById(containerId);

  container.querySelector("[data-action='prev']").addEventListener('click', () => {
    if (currentPage <= 1) return;
    currentPage--;
    renderPage(currentPage);
  });

  container.querySelector("[data-action='next']").addEventListener('click', () => {
    if (currentPage >= totalPages) return;
    currentPage++;
    renderPage(currentPage);
  });

  container.querySelector("[data-action='zoom-in']").addEventListener('click', () => {
    scale += 0.2;
    rerender(container.dataset.pdfMode);
  });

  container.querySelector("[data-action='zoom-out']").addEventListener('click', () => {
    if (scale <= 0.4) return;
    scale -= 0.2;
    rerender(container.dataset.pdfMode);
  });

  container.querySelector("[data-action='zoom-reset']").addEventListener('click', () => {
    scale = 1.2;
    rerender(container.dataset.pdfMode);
  });
}

/*───────────────────────────────────────────────
  RERENDER A SECONDA DELLA MODALITÀ
────────────────────────────────────────────────*/
function rerender(mode) {
  if (mode === 'multi') {
    renderAllPages();
  } else {
    renderPage(currentPage);
  }
}

/*───────────────────────────────────────────────
  INIZIALIZZAZIONE GENERALE
────────────────────────────────────────────────*/
export async function initPdfViewer(containerId = 'pdf-viewer') {
  const container = document.getElementById(containerId);
  if (!container) return;

  const url = container.dataset.pdfUrl;
  if (!url) return;

  const mode = container.dataset.pdfMode || 'single';

  const loadingTask = pdfjsLib.getDocument(url);
  pdfDoc = await loadingTask.promise;

  totalPages = pdfDoc.numPages;
  document.getElementById('pdf-total-pages').textContent = totalPages;

  canvas = document.getElementById('pdf-canvas');
  ctx = canvas.getContext('2d');

  // Per single page → pulsanti attivi
  if (mode === 'single') {
    bindControls(containerId);
    renderPage(currentPage);
  }

  // Per multi page → nascondi controlli e renderizza tutto
  if (mode === 'multi') {
    document.getElementById('pdf-controls').style.display = 'none';
    renderAllPages();
  }
}
