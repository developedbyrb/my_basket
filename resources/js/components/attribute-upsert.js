$(document).on('click', '.add-option-button', function (e) {
    e.preventDefault();
    let currentOption = $(this).data('option-count');
    currentOption++;
    let html = '';
    html += '<div class="col-span-1 option-row">';
    html += '<div class="grid grid-cols-12 gap-3">';
    html += '<div class="form-group col-span-10">';
    html += `<label for="option${currentOption}" class="form-label">Option Name</label>`;
    html +=
        `<input type="text" name="options[${currentOption}][value]" id="option${currentOption}" class="custom-input-text" placeholder="e.g. Black">`;
    html += '</div>';
    html += '<div class="hidden col-span-2 justify-center items-center remove-option mt-5">';
    html += '<button type="button" class="remove-option-button">';
    html += 'remove';
    html += '</button>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    $(this).data('option-count', currentOption);
    $('#optionFields').append(html);
    if (currentOption > 1) {
        $('.remove-option').removeClass('hidden');
        $('.remove-option').addClass('flex');
    }
});

$(document).on('click', '.remove-option-button', function (e) {
    $(this).closest('.option-row').remove();
    const totalOption = $('.add-option-button').data('option-count');
    $('.add-option-button').data('option-count', totalOption - 1);
    if ($('.add-option-button').data('option-count') === 1) {
        $('.remove-option').removeClass('flex');
        $('.remove-option').addClass('hidden');
    }
});