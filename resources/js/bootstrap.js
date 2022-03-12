window._ = require('lodash');

const axios = require('axios');
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const { Dropzone } = require("dropzone");
window.Dropzone = Dropzone;
window.Dropzone.autoDiscover = false;
