<select name="{{ $selecttitle }}" id="{{ $selecttitle }}" class="form-control">
    <option value="">Select One</option>
    @foreach($options as $key => $value)
    <option value="{{ $key }}">{{$value}}</option>
    @endforeach
</select>
