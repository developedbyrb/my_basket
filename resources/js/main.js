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

export const addHTMLForPut = '<input type="hidden" name="_method" id="putMethod" value="PUT">';