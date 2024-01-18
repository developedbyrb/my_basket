<div id="toast-danger" class="toast-wrapper" role="alert">
    <div class="error-toast">
        <x-cross-toast-svg />
        <span class="sr-only">Error icon</span>
    </div>
    <div class="ms-3 text-sm font-normal">{{ $message }}</div>
    <button type="button" class="toast-close" data-dismiss-target="#toast-danger" aria-label="Close">
        <span class="sr-only">Close</span>
        <x-cross-svg />
    </button>
</div>
