<div class="form-group {{ $col ?? '' }}">
    <label for="{{ $name }}">{{ $label ?? '' }}</label>
    <input type="{{ $type ?? 'text'}}" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $class ?? '' }}" value="{{ $value ?? '' }}"  placeholder="{{ $placeholder ?? '' }}" @if (!empty($onkeyup)) onkeyup="{{ $onkeyup ?? '' }}" @endif>
    <span class="error"></span>
</div>