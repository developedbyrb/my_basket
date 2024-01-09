export function setupAjax() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

export function objectifyForm(formArray) {
    let returnArray = {};
    for (let i = 0; i < formArray.length; i++) {
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
};

export function openModel(selector) {
    const modalOptions = {
        placement: 'center-center',
        backdrop: 'static',
        backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: false,
    };
    const $modalElement = document.querySelector(selector);
    const modal = new Modal($modalElement, modalOptions);
    modal.show();
}

export function closeModel(selector) {
    const $modalElement = document.querySelector(selector);
    const modal = new Modal($modalElement);
    modal.hide();
}

export function handleSelectedCategory(value, selectedCategories) {
    if ($.inArray(value, selectedCategories) === -1) {
        selectedCategories.push(value);
    } else {
        selectedCategories = $.grep(selectedCategories, function (val) {
            return val !== value;
        });
    }

    if (selectedCategories.length > 0 && $('#dropdownSearchButton').hasClass('is-invalid')) {
        $('#category-error').html('');
        $('#dropdownSearchButton').removeClass('is-invalid');
    }

    return selectedCategories;
}

export function checkCategoryValidation(selectedCategories) {
    if (selectedCategories && selectedCategories.length > 0) {
        $('#category-error').html('');
        $('#dropdownSearchButton').removeClass('is-invalid');
        return false;
    } else {
        $('#category-error').html('Please select at least one category.');
        $('#dropdownSearchButton').addClass('is-invalid');
        return true;
    }
}

export function requiredAndTrimmed() {
    return {
        required: true,
        normalizer: function (value) {
            return $.trim(value);
        }
    };
}

export const addHTMLForPut = '<input type="hidden" name="_method" id="putMethod" value="PUT">';