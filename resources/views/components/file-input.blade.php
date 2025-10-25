@props([
    'label',
    'name',
    'current' => null,
    'multiple' => false,
    'accept' => 'image/*'
])

<div class="row mt-4 mb-4" style="align-items: center;">
    <div class="col-md-3">
        <label class="title-input" for="{{ $name }}">{{ $label }}</label>
    </div>
    <div class="col-md-8">
        <input
            type="file"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            id="{{ $name }}"
            {{ $multiple ? 'multiple' : '' }}
            accept="{{ $accept }}"
            style="background: #fff!important"
        >
        <div class="holder mt-4" id="{{ $name }}Holder">
            @if($current)
                @if(is_array($current) || $current instanceof \Illuminate\Support\Collection)
                    @foreach($current as $img)
                        <img src="{{ config('services.cms_link').'/storage/'.$img }}" alt="pic" width="100" height="100"/>
                    @endforeach
                @else
                    <img src="{{ config('services.cms_link').'/storage/'.$current }}" alt="pic" width="100" height="100"/>
                @endif
            @endif
        </div>
    </div>
</div>
