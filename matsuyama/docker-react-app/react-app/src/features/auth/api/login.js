import axios from 'lib/axios';

export const login = (data) => axios.post('/auth/login', data);
