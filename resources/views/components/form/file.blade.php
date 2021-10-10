<div class="form-group {{ $col ?? '' }}">
    <label for="{{ $name }} ">{{ $label }}</label>
    <input type="file" name="{{ $name }}" id="{{ $name }}" class="dropify {{ $class ?? '' }}">
    <input type="hidden" name="old_{{ $name }}" id="old_{{ $name }}">
</div>