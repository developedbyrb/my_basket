import './bootstrap';

import Alpine from 'alpinejs';
import jQuery from 'jquery';
import 'jquery-validation';
import persist from '@alpinejs/persist';
import 'flowbite';

Alpine.plugin(persist)
window.Alpine = Alpine;
Alpine.start();

window.$ = jQuery;
