import Axios from 'axios';
import { API_URL } from '../config';

function authRequestInterceptor(config) {
  // const token = storage.getToken();
  // if (token) {
  //   config.headers.authorization = `${token}`;
  // }
  // config.headers.Accept = 'application/json';
  return config;
}

const axios = Axios.create({
  baseURL: API_URL,
});

axios.interceptors.request.use(authRequestInterceptor);
axios.interceptors.response.use(
  (response) => response.data,
  (error) => {
    const message = error.response?.data?.message || error.message;
    // useNotificationStore.getState().addNotification({
    //   type: 'error',
    //   title: 'Error',
    //   message,
    // });
    console.log('test', message);
    return Promise.reject(error);
  },
);

export default axios;
