@props([
    'label',
    'name',
    'value' => '',
    'placeholder' => '',
    'type' => 'text',
    'required' => true
])

<div class="row mt-4 mb-4" style="align-items: center;">
    <div class="col-md-3">
        <label class="title-input" for="{{ $name }}">{{ $label }}</label>
    </div>
    <div class="col-md-8">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="input_off_plan"
            style="border-right: 3px solid #9D865C!important"
            @if($required) required @endif
        >
    </div>
</div>
