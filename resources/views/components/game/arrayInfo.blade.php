@props(['infos', 'title', 'attribute'])

<div {{ $attributes->merge(['class' => 'text-yellow-100 p-1 text-xs pl-2 '.($attribute ?? '')]) }}>
    @foreach($infos as $info)
        <strong>{{ $title }}</strong>:
        {!! $info !!}
    @endforeach
</div>
