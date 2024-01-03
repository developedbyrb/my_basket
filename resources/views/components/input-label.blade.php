@props(['value', 'required'])

<label {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span style="color:red"> *</span>
    @endif
</label>
