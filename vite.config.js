import { defineConfig } from 'vite';

export default defineConfig({
	server: {
		proxy: {
			'/': {
				target: 'http://localhost:8000/', // URL PHP-сервера
				changeOrigin: true,
				rewrite: path => path.replace(/^\//, ''),
			},
		},
	},
});
