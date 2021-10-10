<div class="form-group {{ $col ?? '' }}">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" class="form-control {{ $class ?? '' }}"
        required="{{ $required ?? '' }}" placeholder="{{ $placeholder ?? '' }}" >{{ $value ?? '' }}</textarea>
        
</div>
