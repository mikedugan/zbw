<div class="col-md-6">
 {{-- this area should contain an overview of recent training, promotions, etc --}}
    <div class="col-md-3">
        <h4>Recent Reports</h4>
        @foreach($reports as $r)
            {{-- recent training reports --}}
        @endforeach
    </div>
    <div class="col-md-3">
        @foreach($sessions as $s)
            {{-- sessions where controller was online --}}
        @endforeach
    </div>
</div>
<div class="col-md-6">
 {{-- this area should contain pending training & exam requests, etc --}}
    <div class="col-md-3">
        <h4>Training &amp; Exam Requests</h4>
        @if($requests)
            @foreach($requests as $r)
                {{-- training requests --}}
            @endforeach
        @endif
    </div>
    <div class="col-md-3">
        <h4>Exams Reviews</h4>
        @if($reviews)
            @foreach($reviews as $r)
                {{-- pending exam reviews --}}
            @endforeach
    </div>
</div>
