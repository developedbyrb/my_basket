$(document).on('click', '.open-confirm-modal', function (e) {
    e.preventDefault();
    const attributeId = $(this).data('id');
    $('#popup-modal').attr("data-attribute-id", attributeId);
    openModel('#popup-modal');
});

$('.modal-confirm-cancel, .close-confirm-modal').on('click', function (e) {
    e.preventDefault();
    $('#popup-modal').attr('data-attribute-id', '');
    closeModel('#popup-modal');
});

$('.modal-confirm-submit').on('click', function (e) {
    e.preventDefault();
    setupAjax();
    const attributeId = $('#popup-modal').attr('data-attribute-id');

    let destroyCatUrl = "{{ route('attributes.destroy', ':id') }}";
    destroyCatUrl = destroyCatUrl.replace(':id', attributeId);
    $.ajax({
        url: destroyCatUrl,
        type: 'DELETE',
        dataType: 'json',
        success: function (response) {
            $('#popup-modal').attr('data-attribute-id', '');
            closeModel('#popup-modal');
            location.reload();
        },
        error: function (data) {
            console.log(data);
        }
    });
});
