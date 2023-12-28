@extends('layouts.app')

@section('content')
    @if (\Helper::hasPermissionToView('create-products'))
        <div class="w-full flex flex-row-reverse">
            <button class="custom-create-button open-product-modal" type="button" data-id="">
                <x-plus-svg />
                {{ __('Create Product') }}
            </button>
        </div>
    @endif
    <div class="table-wrapper">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[100px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            #
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Categories
                        </th>
                        <th class="min-w-[150px] py-4 px-4 font-medium text-black dark:text-white">
                            Created By
                        </th>
                        <th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-products') || \Helper::hasPermissionToView('delete-products'))
                            <th class="py-4 px-4 font-medium text-black dark:text-white">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="productTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white"></h3>
                    <button type="button" class="close-confirm-modal">
                        <x-cross-svg />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 mt-5 text-center">
                    <div class="flex items-center">
                        <svg class="mx-auto mb-4 text-warning-400 w-10 h-10 dark:text-warning-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Are you sure you want to delete this product?
                        </h3>
                    </div>
                </div>
                <div class="flex justify-end items-center">
                    <button type="button" class="modal-confirm-cancel">
                        No, cancel
                    </button>
                    <button type="button" class="modal-confirm-submit">
                        Yes, I'm sure
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="modal-title text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                        Create New Product
                    </h3>
                    <button type="button" class="close-modal-icon">
                        <x-cross-svg />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div>
                    <form class="p-4 md:p-5" id="productForm">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 form-group">
                                <label for="name" class="form-label">Name<span style="color:red"> *</span></label>
                                <input type="text" name="name" id="name" class="custom-input-text"
                                    placeholder="Type product name">
                            </div>
                            <div class="col-span-2 form-group">
                                <label for="category" class="form-label">
                                    Category<span style="color:red"> *</span>
                                </label>
                                <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
                                    data-dropdown-placement="bottom" class="custom-input-text text-left" type="button">
                                    <span class="flex justify-between items-center">
                                        Select Category
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 10 6" class="w-2.5 h-2.5 ms-3">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </span>
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdownSearch" class="category-option-wrapper hidden">
                                </div>
                                <span id="category-error" class="invalid-feedback"></span>
                            </div>
                            <div class="col-span-2 form-group">
                                <label class="form-label" for="product_image">Image<span style="color:red"> *</span></label>
                                <input class="file-input" id="product_image" type="file" name="image"
                                    aria-describedby="product_image">
                            </div>
                        </div>
                        <div class="flex flex-row-reverse mt-5">
                            <button type="button" class="modal-submit-button">
                                Save
                            </button>
                            <button type="button" class="modal-cancel-button">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page-script')
    <script type="module">
        // Define JS varibales
        const addHTMLForPut = '<input type="hidden" name="_method" id="putMethod" value="PUT">';
        const modalOptions = {
            placement: 'center-center',
            backdrop: 'static',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: false,
        };
        let selectedCategories = [];

        $(document).ready(function() {
            getProductList();
        });

        $(document).on('click', '.open-product-modal', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            if (productId) {
                getProductDetails(productId);
            } else {
                createProduct();
            }
        });

        $(document).on('click', '.open-confirm-modal', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            $('#popup-modal').data('product-id', productId);
            const $modalElement = document.querySelector('#popup-modal');
            const modal = new Modal($modalElement, modalOptions);
            modal.show();
        });

        $(document).on('change', '.category-selection', function(e) {
            e.preventDefault();
            const value = $(this).data('value');
            if ($.inArray(value, selectedCategories) === -1) {
                selectedCategories.push(value);
            } else {
                selectedCategories = $.grep(selectedCategories, function(val) {
                    return val !== value;
                });
            }

            if (selectedCategories.length > 0 && $('#dropdownSearchButton').hasClass('is-invalid')) {
                $('#category-error').html('');
                $('#dropdownSearchButton').removeClass('is-invalid');
            }
        })

        $('.modal-submit-button').on('click', function(e) {
            e.preventDefault();
            checkCategoryValidation();
            $("#productForm").validate({
                rules: {
                    name: {
                        required: true,
                        normalizer: function(value) {
                            return $.trim(value);
                        }
                    },
                    'categories[]': {
                        required: true,
                        minlength: 1
                    },
                    image: {
                        required: function(element) {
                            return $('#productForm').data('product-id') ? false : true;
                        },
                        fileExtension: true
                    }
                },
                messages: {
                    'categories[]': "Please select at least one option."
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            if ($("#productForm").valid()) {
                const formData = objectifyForm($("#productForm").serializeArray());
                submitForm(formData);
            }
        });

        $('.modal-cancel-button, .close-modal-icon').on('click', function(e) {
            e.preventDefault();
            hideModal('crud');
        });

        $('.modal-confirm-cancel, .close-confirm-modal').on('click', function(e) {
            e.preventDefault();
            hideModal('confirm');
        });

        $('.modal-confirm-submit').on('click', function(e) {
            e.preventDefault();
            setupAjax();
            console.log($('#popup-modal').data('product-id'));
            const productId = $('#popup-modal').data('product-id');
            console.log(productId);

            let destroyProductUrl = "{{ route('products.destroy', ':id') }}";
            destroyProductUrl = destroyProductUrl.replace(':id', productId);
            $.ajax({
                url: destroyProductUrl,
                type: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    hideModal('confirm');
                    getProductList();
                    $('#popup-modal').data('product-id', '');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function getProductList() {
            let URL = "{{ route('products.index') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    $('#productTableBody').html(success.data.html);
                },
                error: function(data) {
                    console.error('Product Error', data);
                }
            });
        }

        function createProduct() {
            const URL = "{{ route('products.create') }}";
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    $('#dropdownSearch').html(success.data.html);
                    $('#modal-title').html('Create New Product');
                    const $modalElement = document.querySelector('#crud-modal');
                    const modal = new Modal($modalElement, modalOptions);
                    modal.show();
                },
                error: function(data) {
                    console.error('Custom Error', data);
                }
            });
        }

        function getProductDetails(id) {
            let URL = "{{ route('products.edit', ':id') }}";
            URL = URL.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: URL,
                success: function(success) {
                    $('#dropdownSearch').html(success.data.html);

                    const productData = success.data.productData;
                    var inputs = $('#productForm [name]');
                    $.each(inputs, function(i, input) {
                        const inputName = $(input).attr('name');
                        if (inputName != 'image')
                            $(input).val(productData[inputName]);
                    });

                    $(".category-selection:checked").each(function() {
                        selectedCategories.push($(this).data('value'));
                    });
                    $('#modal-title').html('Edit Product Details');

                    const $modalElement = document.querySelector('#crud-modal');
                    const modal = new Modal($modalElement, modalOptions);
                    modal.show();

                    $('#productForm').append(addHTMLForPut);
                    $('#productForm').attr('data-product-id', productData['id']);
                },
                error: function(data) {
                    console.error('Custom Error', data);
                }
            });
        }

        function checkCategoryValidation() {
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

        function submitForm(data) {
            setupAjax();
            const productId = $('#productForm').data('product-id');
            let postURL = '';
            if (productId) {
                postURL = "{{ route('products.update', ':id') }}";
                postURL = postURL.replace(':id', productId);
            } else {
                postURL = '{{ route('products.store') }}';
            }
            let formData = new FormData();
            if ($('#product_image').prop('files').length)
                formData.append('image', $('#product_image').prop('files')[0]);
            for (let key in data) {
                formData.append(key, data[key]);
            }
            //override values for categories
            formData.delete('categories[]');
            formData.append('categories[]', selectedCategories);
            $.ajax({
                url: postURL,
                type: 'POST',
                data: formData,
                async: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    selectedCategories = [];
                    hideModal('crud');
                    getProductList();
                    if (productId) {
                        $('#productForm').removeData("product-id");
                        $('#putMethod').remove();
                    }
                },
                error: function(data) {}
            });
        }

        function hideModal(modalType) {
            let $modalElement;
            if (modalType === 'crud') {
                $('#productForm')[0].reset();
                $modalElement = document.querySelector('#crud-modal');
            } else {
                $modalElement = document.querySelector('#popup-modal');
            }
            const modal = new Modal($modalElement);
            modal.hide();
        }

        function setupAjax() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function objectifyForm(formArray) {
            let returnArray = {};
            for (let i = 0; i < formArray.length; i++) {
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;
        }
    </script>
@endpush
