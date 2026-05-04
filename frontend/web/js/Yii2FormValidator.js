/* eslint-disable prettier/prettier */
/**
 * Yii2 + Bootstrap 5 — Vanilla JS Validator
 * Usa attributi data-* sugli input per dichiarare le regole
 */

const SKIP_TYPES = new Set(['hidden', 'submit', 'button', 'reset', 'image']);

export default class Yii2Validator {
  constructor(formId) {
    this.form = document.getElementById(formId);
    if (!this.form) return;
    this._bind();
  }

  _bind() {
    this.form.addEventListener('submit', (e) => {
      if (!this._validateAll()) {
        e.preventDefault();
        e.stopPropagation();
      }
    });

    this._getValidatableInputs().forEach((input) => {
      input.addEventListener('blur', () => this._validateField(input));

      const revalidate = () => {
        if (input.classList.contains('is-invalid')) {
          this._validateField(input);
        }
      };

      input.addEventListener('input', revalidate);
      input.addEventListener('change', revalidate);
    });
  }

  _getValidatableInputs() {
    return Array.from(this.form.querySelectorAll('input, textarea, select')).filter(
      (el) => !SKIP_TYPES.has(el.type)
    );
  }

  _validateAll() {
    let valid = true;
    this._getValidatableInputs().forEach((input) => {
      if (!this._validateField(input)) valid = false;
    });
    return valid;
  }

  _validateField(input) {
    const rules = this._getRules(input);
    let error = null;

    for (const rule of rules) {
      error = this._applyRule(input, rule);
      if (error) break;
    }

    error ? this._showError(input, error) : this._clearError(input);
    return !error;
  }

  _getRules(input) {
    const rules = [];

    if (input.dataset.required === 'true') rules.push({ type: 'required' });
    if (input.dataset.type) rules.push({ type: input.dataset.type });
    if (input.dataset.minLength)
      rules.push({
        type: 'minLength',
        value: parseInt(input.dataset.minLength),
      });
    if (input.dataset.maxLength)
      rules.push({
        type: 'maxLength',
        value: parseInt(input.dataset.maxLength),
      });
    if (input.dataset.min) rules.push({ type: 'min', value: parseFloat(input.dataset.min) });
    if (input.dataset.max) rules.push({ type: 'max', value: parseFloat(input.dataset.max) });
    if (input.dataset.pattern) rules.push({ type: 'pattern', value: input.dataset.pattern });
    if (input.dataset.compare) rules.push({ type: 'compare', value: input.dataset.compare });
    if (input.dataset.range) rules.push({ type: 'range', value: input.dataset.range.split(',') });

    return rules;
  }

  _getLabel(input) {
    // legge il testo dalla <label for="input.id"> generata da Yii2
    const label = document.querySelector(`label[for="${input.id}"]`);
    return label ? label.textContent.trim() : 'Campo';
  }

  _findFeedback(input) {
    // risale il DOM finché trova un elemento con .invalid-feedback
    let parent = input.parentElement;
    while (parent) {
      const feedback = parent.querySelector('.invalid-feedback');
      if (feedback) return feedback;
      parent = parent.parentElement;
    }
    return null;
  }

  _applyRule(input, rule) {
    const val = input.value.trim();
    const label = this._getLabel(input);

    switch (rule.type) {
      case 'required':
        if (input.type === 'checkbox' ? !input.checked : !val) return `${label} è obbligatorio.`;
        break;

      case 'email':
        if (val && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val))
          return `${label} non è un indirizzo email valido.`;
        break;

      case 'url':
        if (val && !/^https?:\/\/.+\..+/.test(val)) return `${label} non è un URL valido.`;
        break;

      case 'integer':
        if (val && !/^-?\d+$/.test(val)) return `${label} deve essere un numero intero.`;
        break;

      case 'number':
        if (val && isNaN(Number(val))) return `${label} deve essere un numero.`;
        break;

      case 'minLength':
        if (val && val.length < rule.value)
          return `${label} deve contenere almeno ${rule.value} caratteri.`;
        break;

      case 'maxLength':
        if (val && val.length > rule.value)
          return `${label} non può superare ${rule.value} caratteri.`;
        break;

      case 'min':
        if (val && parseFloat(val) < rule.value)
          return `${label} deve essere almeno ${rule.value}.`;
        break;

      case 'max':
        if (val && parseFloat(val) > rule.value) return `${label} non può superare ${rule.value}.`;
        break;

      case 'boolean':
        if (input.type === 'checkbox' && !input.checked) return `${label} deve essere selezionato.`;
        break;

      case 'range': {
        if (val && !rule.value.map((v) => v.trim()).includes(val))
          return `${label} non è un valore valido.`;
        break;
      }

      case 'pattern': {
        try {
          if (val && !new RegExp(rule.value).test(val))
            return `${label} non è nel formato corretto.`;
        } catch {
          console.warn(`Yii2Validator: pattern non valido su "${input.id}":`, rule.value);
        }
        break;
      }

      case 'compare': {
        const other = document.querySelector(rule.value);
        if (!other) {
          console.warn(
            `Yii2Validator: selettore compare non trovato su "${input.id}":`,
            rule.value
          );
          break;
        }
        if (val !== other.value.trim()) return `${label} non corrisponde.`;
        break;
      }
    }

    return null;
  }

  _showError(input, message) {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
    const feedback = this._findFeedback(input);
    if (feedback) feedback.textContent = message;
  }

  _clearError(input) {
    input.classList.remove('is-invalid');
    const hasValue = input.type === 'checkbox' ? input.checked : input.value.trim();
    if (hasValue) input.classList.add('is-valid');
    else input.classList.remove('is-valid');
    const feedback = this._findFeedback(input);
    if (feedback) feedback.textContent = '';
  }
}
