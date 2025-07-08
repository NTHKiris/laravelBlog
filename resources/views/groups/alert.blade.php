{{-- Alert đơn giản --}}
<x-alert>
    Something went wrong!
</x-alert>

{{-- Alert với type khác --}}
<x-alert type="success">
    Operation completed successfully!
</x-alert>

{{-- Alert có thể đóng được --}}
<x-alert type="warning" :dismissible="true">
    This is a warning message.
</x-alert>

{{-- Alert với title --}}
<x-alert type="info">
    <x-slot name="title">Information</x-slot>
    This is an informational message.
</x-alert>

{{-- Alert với custom class --}}
<x-alert type="danger" class="mb-4 shadow-sm">
    Critical error occurred!
</x-alert>