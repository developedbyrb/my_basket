<div class="flex items-start justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    <span class="hidden sm:inline-block md:align-top md:h-screen" aria-hidden="true">​</span>
    <div class="custom-modal">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left divide-y divide-solid outline-slate-400">
                <h3 class="text-lg leading-6 font-semibold text-gray-900" id="modal-title"></h3>
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-start-1 col-end-7">
                        <div class="mt-2 mb-2">
                            <form method="post" id="roleForm">
                                <div class="form-group">
                                    <label for="role"
                                        class="block text-md font-medium leading-6 text-gray-900">Enter Role</label>
                                    <div class="custom-input-wrapper">
                                        <input type="text" name="name" id="role" class="custom-input-text"
                                            placeholder="Please Enter Role Here">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="modal-button save-button" id="submitUpsert">
                    Save
                </button>
                <button type="button" class="closeModal cancel-button" id="closeUpsert">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
