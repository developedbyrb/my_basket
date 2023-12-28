<div id="toast-success" class="toast-wrapper" role="alert">
    <div class="success-toast">
        <x-check-toast-svg />
        <span class="sr-only">Check icon</span>
    </div>
    <div class="ms-3 text-sm font-normal">{{ $message }}</div>
    <button type="button" class="toast-close" data-dismiss-target="#toast-success" aria-label="Close">
        <span class="sr-only">Close</span>
        <x-cross-svg />
    </button>
</div>
