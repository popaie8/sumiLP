import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  build: {
    outDir: 'dist/js',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        lead: resolve(__dirname, 'assets/js/lead-form.js') // ← ここだけ変更
      },
      output: {
        entryFileNames: '[name].js'     // 生成ファイル名 = lead.js
      }
    }
  }
});
