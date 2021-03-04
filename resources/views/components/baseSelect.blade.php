<?php 
    if(!isset($name)) {
        throw new Exception("Base select requires a name", 1);
    }
    if(!isset($options)) {
        throw new Exception("Please provide options", 1);
    }
    if(!is_array($options)) {
        throw new Exception("options must be an array", 1);
    }
    $label = $label ?? ucwords(str_replace(['_','-'], [' ', ' '], $name));
    $for = $for ?? $name;
    $type = $type ?? 'text';
    $placeholder = $placeholder ?? null;
    $placeholder_disabled = $placeholder_disabled ?? null;
    $default_selection = $default_selection ?? null;
    $required = isset($required) && $required ? 'required' : null;
    $attributes = isset($attributes) && $attributes ? $attributes : [];
?>


<div class="form-group  select">
    <label for="{{ $for }}" class="col-form-label">{!! $label !!}</label>

    <select 
        placeholder="{{ $placeholder }}" 
        id="{{ $for }}" 
        type="{{ $type }}" 
        name="{{ $name }}"
        class="select-control {{ $errors->has($name) ? 'is-invalid' : '' }}" 
        {{ $required }}
        @foreach($attributes as $key => $value)
            {{ $key }}="{{ $value }}"
        @endforeach
    >
        @if($placeholder)
            <option
                {{ $placeholder_disabled ? 'disabled' : null }}
                value="{{ $placeholder_value }}"
            >
                {{ $placeholder }}
            </option>
        @endif
        @foreach($options as $key => $value)
            <option 
                value="{{ $key }}"
                {{ $default_selection == $key ? 'selected' : null }}
            >
                {{ $value }}
            </option>
        @endforeach
    </select>

    @if ($errors->has($name))
        <span class="error-label" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>