import axios from 'axios';
export const useApi = () => {
  const get = (url, config) => axios.get(url, config).then(r=>r.data);
  const post = (url, data, config) => axios.post(url, data, config).then(r=>r.data);
  return { get, post };
};
