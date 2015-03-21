    <option value="">Random</option>
@foreach(\Config::get('zbw.poker.card_names') as $card => $title)
    <option value="{{$card}}">{{$title}}</option>
@endforeach
