<div id="toast-warning" class="toast-wrapper" role="alert">
    <div class="warning-toast">
        <x-warning-toast-svg />
        <span class="sr-only">Warning icon</span>
    </div>
    <div class="ms-3 text-sm font-normal">{{ $message }}</div>
    <button type="button" class="toast-close" data-dismiss-target="#toast-warning" aria-label="Close">
        <span class="sr-only">Close</span>
        <x-cross-svg />
    </button>
</div>
