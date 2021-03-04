<?php 
    if(!isset($name)) {
        throw new Exception("Base input requires a name", 1);
    }
    $label = $label ?? ucwords(str_replace(['_','-'], [' ', ' '], $name));
    $for = $for ?? $name;
    $required = isset($required) && $required ? 'required' : null;
    $value = $value ?? '1';
    $checked = isset($checked) && $checked ? 'checked' : null;
?>


<div class="form-group">
    <div class="checkbox">
        <input 
            value="{{ $value }}" 
            id="{{ $for }}" 
            type="checkbox" 
            class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" 
            name="{{ $name }}" {{ $required }}
            {{ $checked }}
        >
        <label for="{{ $for }}" class="col-form-label"></label>
        <label for="{{ $for }}">{!! $label !!}</label>
    </div>
    <!-- /.checkbox -->
    @if ($errors->has($name))
        <span class="error-label" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>