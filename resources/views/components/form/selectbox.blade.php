<div class="form-group {{ $col ?? '' }}">
    <label for="{{ $name }}">{{ $label }}</label>
    <select data-search-live="true" data-search-live-placeholder="Search" name="{{ $name }}" id="{{ $name }}" class="form-control {{ $class ?? '' }}" @if (!empty($onchange)) onchange="{{ $onchange ?? '' }}" @endif>
        <option value="">Select Please</option>
        {{ $slot }}
    </select>
 
</div>
