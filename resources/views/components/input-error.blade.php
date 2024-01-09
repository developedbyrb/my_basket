@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            @if (gettype($message) === 'array' && count($message) > 0)
                <li>{{ $message[0] }}</li>
            @else
                <li>{{ $message }}</li>
            @endif
        @endforeach
    </ul>
@endif
