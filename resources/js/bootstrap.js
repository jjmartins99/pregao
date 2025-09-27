/**
 * Bootstrap da aplicação Laravel
 * Inicializa bibliotecas e configurações essenciais
 */

window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

// Configuração global do axios
window.axios.defaults.baseURL = '/api';

// Interceptador de requests
window.axios.interceptors.request.use(
    (config) => {
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            config.headers['X-CSRF-TOKEN'] = token.content;
        }
        config.headers['Accept'] = 'application/json';
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

// Interceptador de responses
window.axios.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response?.status === 401) {
            // Não autenticado - redirecionar para login
            window.location.href = '/login';
        } else if (error.response?.status === 419) {
            // Token CSRF expirado - recarregar a página
            window.location.reload();
        } else if (error.response?.status === 429) {
            // Too Many Requests
            showNotification('Muitas tentativas. Por favor, aguarde.', 'error');
        }
        return Promise.reject(error);
    }
);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
        },
    },
});

// Eventos globais do Echo
window.Echo.connector.pusher.connection.bind('connected', function() {
    console.log('Ligação Pusher estabelecida');
});

window.Echo.connector.pusher.connection.bind('disconnected', function() {
    console.log('Ligação Pusher perdida');
});

/**
 * Inicializar bibliotecas de terceiros
 */

// jQuery (se necessário)
try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {
    console.log('jQuery não carregado');
}

// Bootstrap
try {
    window.bootstrap = require('bootstrap');
} catch (e) {
    console.log('Bootstrap não carregado');
}

// Chart.js (para gráficos)
try {
    window.Chart = require('chart.js/auto');
} catch (e) {
    console.log('Chart.js não carregado');
}

// SweetAlert2 (para alertas bonitos)
try {
    window.Swal = require('sweetalert2');
} catch (e) {
    console.log('SweetAlert2 não carregado');
}

/**
 * Polyfills para compatibilidade
 */

// Object.assign polyfill
if (typeof Object.assign !== 'function') {
    Object.assign = function(target) {
        if (target == null) {
            throw new TypeError('Cannot convert undefined or null to object');
        }

        target = Object(target);
        for (let index = 1; index < arguments.length; index++) {
            const source = arguments[index];
            if (source != null) {
                for (const key in source) {
                    if (Object.prototype.hasOwnProperty.call(source, key)) {
                        target[key] = source[key];
                    }
                }
            }
        }
        return target;
    };
}

// Promise polyfill
if (typeof Promise !== 'function') {
    window.Promise = require('promise-polyfill');
}

// Fetch polyfill
if (typeof window.fetch !== 'function') {
    require('whatwg-fetch');
}

console.log('Bootstrap da aplicação carregado');