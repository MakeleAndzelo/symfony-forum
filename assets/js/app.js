import Vue from 'vue';
import Flash from './components/Flash';

new Vue({
    el: "#root",
    delimiters: ['${', '}'],
    components: {
        'flash': Flash
    }
});