<div class="hidden js-toaster">
    <div class="toast-wrapper" role="alert">
        <div class="toast">
            <div class="hidden success-icon">
                <x-check-toast-svg />
                <span class="sr-only">Check icon</span>
            </div>
            <div class="hidden error-icon">
                <x-cross-toast-svg />
                <span class="sr-only">Error icon</span>
            </div>
            <div class="hidden warning-icon">
                <x-warning-toast-svg />
                <span class="sr-only">Warning icon</span>
            </div>
        </div>
        <div class="ms-3 text-sm font-normal toast-message"></div>
        <button type="button" class="toast-close" aria-label="Close" id="custom-js-toast-close">
            <span class="sr-only">Close</span>
            <x-cross-svg />
        </button>
    </div>
</div>
