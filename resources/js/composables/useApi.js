import { useUiStore } from '@/stores/ui';

export const useApi = () => {
    const uiStore = useUiStore();

    const request = async (method, url, data = null, config = {}) => {
        try {
            uiStore.setLoading(true);
            
            const response = await axios({
                method,
                url,
                data,
                ...config,
            });

            return response;
        } catch (error) {
            console.error(`API Error (${method} ${url}):`, error);
            
            if (error.response?.status === 401) {
                // Redirect to login if unauthorized
                window.location.href = '/login';
            }

            throw error;
        } finally {
            uiStore.setLoading(false);
        }
    };

    const get = (url, config = {}) => request('get', url, null, config);
    const post = (url, data = {}, config = {}) => request('post', url, data, config);
    const put = (url, data = {}, config = {}) => request('put', url, data, config);
    const del = (url, config = {}) => request('delete', url, null, config);

    return {
        get,
        post,
        put,
        del,
    };
};