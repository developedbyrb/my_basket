import './bootstrap';

import Alpine from 'alpinejs';
import jQuery from 'jquery';
import 'jquery-validation';

window.Alpine = Alpine;

Alpine.start();

window.$ = jQuery;

$(document).ready(function () {
    $('.openModal').on('click', function (e) {
        $('#removeRole').removeClass('invisible');
    });
    $('.closeModal').on('click', function (e) {
        $('#removeRole').addClass('invisible');
    });
    $('#closeUpsert').on('click', function (e) {
        $('#upsertRole').addClass('invisible');
    });
});