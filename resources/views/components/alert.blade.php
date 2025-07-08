@props(['type' => 'danger', 'dismissible' => false])

<div {{ $attributes->merge(['class' => 'alert alert-' . $type]) }}>
    @if($dismissible)
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    @endif

    @if(isset($title))
        <h4 class="alert-heading">{{ $title }}</h4>
    @endif

    {{ $slot }}
</div>