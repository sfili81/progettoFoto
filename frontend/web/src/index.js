//import css Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';

//import yii css
import '../css/site.css';
//import form css
import '../css/_form.css';

// Import all of Bootstrap's JS
//import * as bootstrap from 'bootstrap'

console.log('[webpack bundle js]');

// PDF.js (5.x)
import { initPdfViewer } from './pdf-viewer';
import Yii2FormValidator from '../js/Yii2FormValidator.js';
import { initGaraSelector } from './gara-selector';
import { initListaFoto }    from './lista-foto';

initPdfViewer();
new Yii2FormValidator('contact-form');
initGaraSelector();
initListaFoto();
