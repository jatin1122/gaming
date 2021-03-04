<?php 
    if(!isset($name) and (! isset($cse) and ! $cse)) {
        throw new Exception("Base input requires a name if not cse", 1);
    }
    $label = $label ?? ucwords(str_replace(['_','-'], [' ', ' '], $name ?? $for));
    $for = $for ?? $name;
    $type = $type ?? 'text';
    $placeholder = $placeholder ?? null;
    $required = isset($required) && $required ? 'required' : null;
    $readonly = isset($readonly) && $readonly ? 'readonly' : null;
    $disabled = isset($disabled) && $disabled ? 'disabled' : null;
    $attributes = isset($attributes) && $attributes ? $attributes : [];
    $value = $value ?? null;
    $info = $info ?? null;
?>


<div class="form-group input">
    <label for="{{ $for }}" class="col-form-label">{!! $label !!} {!! isset($info) ? "<small>($info)</small>" : '' !!}</label>

    <input 
        placeholder="{{ $placeholder }}" 
        id="{{ $for }}" 
        type="{{ $type }}" 
        @isset ($name)
          name="{{ $name }}" 
        @endisset
        value="{{ $value }}" 
        class="form-control {{ (isset($name) and $errors->has($name)) ? 'is-invalid' : '' }}" 
        {{ $required }}
        {{ $readonly }}
        {{ $disabled }}
        @foreach($attributes as $key => $value)
            {{ $key }}="{{ $value }}"
        @endforeach
    >

    @if (isset($name) and $errors->has($name))
        <span class="error-label" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>