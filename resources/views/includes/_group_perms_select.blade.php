<select name="{{ $selecttitle }}" id="{{ $selecttitle }}" class="form-control">
    <option value="">Select One</option>
    @foreach($options as $key => $value)
        @if(isset($existing) && is_array($existing))
    <option {{ in_array($selecttitle.'.'.$value, $existing) ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
        @else
    <option value="{{ $key }}">{{$value}}</option>
        @endif
    @endforeach
</select>
