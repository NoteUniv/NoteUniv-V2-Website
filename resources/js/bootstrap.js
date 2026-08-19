window._ = require("lodash");

const axios = require("axios");
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const { Dropzone } = require("@deltablot/dropzone");
window.Dropzone = Dropzone;
window.Dropzone.autoDiscover = false;
