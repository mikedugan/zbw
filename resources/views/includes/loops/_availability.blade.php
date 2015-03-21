<div class="well">
  <p>{{ $session->controller->initials }} is available up to {{Zbw\Core\Helpers::readableCert($session->cert_id)}}
   from {{$session->start->toDayDateTimeString()}} to {{$session->end->toDayDateTimeString()}}</p>
   @if(!empty($session->comment))
   <p><b>Notes</b>{{ $session->comment }}</p>
   @endif
</div>
