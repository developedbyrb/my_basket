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


$(document).ready(function () {
    const supportedFilesExtensions = ['image/jpeg', 'image/png'];
    //custom validation rules
    $.validator.addMethod("checkEmail", function (value) {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    });

    $.validator.addMethod("checkPassword", function (value) {
        return /^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/.test(value);
    });

    $.validator.addMethod('fileExtension', function (value, element) {
        if (value) {
            return supportedFilesExtensions.includes(element.files[0].type);
        }
        return true;
    });

    jQuery.extend(jQuery.validator.messages, {
        required: "This field is required.",
        remote: "Please fix this field.",
        email: "Please enter a valid email address.",
        checkEmail: "Please enter a valid email address.",
        checkPassword: "Please enter a valid password.",
        url: "Please enter a valid URL.",
        date: "Please enter a valid date.",
        dateISO: "Please enter a valid date (ISO).",
        number: "Please enter a valid number.",
        digits: "Please enter only digits.",
        equalTo: "Please enter the same value again.",
        accept: "Please enter a value with a valid extension.",
        range: jQuery.validator.format("Please enter a value between {0} and {1}."),
        max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
        min: jQuery.validator.format("Please enter a value greater than or equal to {0}."),
        fileExtension: "Please upload file in these format only (jpg, jpeg, png)."
    });

    $("#registrationForm").validate({
        rules: {
            name: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            email: {
                required: true,
                checkEmail: {
                    depends: function (element) {
                        return true;
                    }
                },
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            role_id: {
                required: true,
            },
            password: {
                required: true,
                minlength: {
                    param: 8,
                },
                checkPassword: {
                    depends: function (element) {
                        return true;
                    }
                },
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                checkEmail: {
                    depends: function (element) {
                        return true;
                    }
                },
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            password: {
                required: true,
                minlength: {
                    param: 8,
                },
                checkPassword: {
                    depends: function (element) {
                        return true;
                    }
                },
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});