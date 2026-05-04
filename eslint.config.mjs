import js from '@eslint/js';
import globals from 'globals';
import json from '@eslint/json';
import prettier from 'eslint-plugin-prettier';
import { defineConfig } from 'eslint/config';

export default defineConfig([
  {
    files: ['**/*.{js,mjs,cjs}'],
    ignores: ['backend/assets/**', 'frontend/web/dist/**'],
    plugins: { js, prettier },
    extends: ['js/recommended'], // ✅ solo js/recommended
    languageOptions: {
      globals: { ...globals.browser, ...globals.node },
    },
    rules: {
      // Regole Prettier integrate manualmente
      'prettier/prettier': [
        'error',
        {
          printWidth: 80,
          singleQuote: true,
          trailingComma: 'es5',
        },
      ],
    },
  },
  {
    files: ['**/*.json'],
    plugins: { json },
    language: 'json/json',
    extends: ['json/recommended'],
  },
]);
