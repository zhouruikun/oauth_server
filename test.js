const axios = require('axios');
const instance = axios.create({
    baseURL: 'www.firemen.com',
    timeout: 5000,
    headers: {'X-Custom-Header': 'foobar'}
});
instance.get('/').then(response => {
        console.log(response.data);
    });
