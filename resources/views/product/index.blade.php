@extends('layouts.app')

@section('content')
    @if (\Helper::hasPermissionToView('create-products'))
        <div class="w-full flex flex-row-reverse">
            <a href="{{ route('products.create') }}" class="custom-create-button" type="button">
                @include('svg.plus')
                {{ __('Create Product') }}
            </a>
        </div>
    @endif
    <div class="table-wrapper">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="h-16">
                    <tr class="bg-gray-200 text-left dark:bg-meta-4">
                        <th class="min-w-[100px] table-headers xl:pl-11">
                            #
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Name
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Categories
                        </th>
                        <th class="min-w-30 max-w-50 table-headers">
                            Description
                        </th>
                        <th class="min-w-[150px] table-headers">
                            Created By
                        </th>
                        <th class="min-w-[150px] max-w-90 table-headers">
                            Create At
                        </th>
                        @if (\Helper::hasPermissionToView('edit-products') || \Helper::hasPermissionToView('delete-products'))
                            <th class="table-headers">
                                Actions
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @forelse ($products as $product)
                        <tr>
                            <td class="custom-table-row pl-9">
                                @if ($product->image)
                                    <img class="w-12 h-12 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                                        src="{{ asset('storage' . $product->image) }}" alt="{{ $product->name . '-image' }}"
                                        title="{{ $product->name . '-image' }}">
                                @else
                                    <x-upload-svg />
                                @endif
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">{{ $product->name }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white break-words">
                                    {{ $product->categories->pluck('name')->implode(', ') }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white break-words">
                                    {{ Str::limit($product->description, 80) ?? '-' }}</p>
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">
                                    {{ $product->createdBy->name }}
                                </p>
                            </td>
                            <td class="custom-table-row">
                                <p class="text-black dark:text-white">{{ $product->created_at->format('F j, Y') }}</p>
                            </td>
                            <td class="custom-table-row">
                                <div class="flex items-center space-x-3.5">
                                    @if (
                                        \Helper::hasPermissionToView('edit-products') &&
                                            (Auth::user()->hasRole('admin') || Auth::id() === $product->created_by))
                                        <button class="hover:text-primary open-product-modal"
                                            data-id="{{ $product->id }}">
                                            <x-edit-svg />
                                        </button>
                                    @endif
                                    @if (
                                        \Helper::hasPermissionToView('delete-products') &&
                                            (Auth::user()->hasRole('admin') || Auth::id() === $product->created_by))
                                        <button class="hover:text-primary mt-1 open-confirm-modal"
                                            data-id="{{ $product->id }}">
                                            <x-remove-svg />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b dark:border-neutral-500">
                            <td class="no-records" colspan="4">
                                No records
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden custom-modal-wrapper">
        @include('layouts.common.confirmationPopup', [
            'message' => 'Are you sure you want to delete this product?',
        ])
    </div>
@endsection

@push('page-script')
    <script type="module">
        let selectedCategories = [];
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
            openModel('#popup-modal');
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
                    openModel('#crud-modal');
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
                    openModel('#crud-modal');

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
            for (var i = 0; i < selectedCategories.length; i++) {
                formData.append('categories[]', selectedCategories[i]);
            }
            debugger;
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
            if (modalType === 'crud') {
                $('#productForm')[0].reset();
                closeModel('#crud-modal');
            } else {
                closeModel('#popup-modal');
            }
        }
    </script>
@endpush
