_<p><a style="cursor:pointer" data-toggle="modal" data-target="#errorModal">Report Error</a> | <span class="left">Content &copy; 2014 vZBW ARTCC</span>
    <span class="right"><a data-toggle="modal" data-target="#disclaimerModal">VATSIM Disclaimer</a></span>
    | v{{ Config::get('zbw.version') }}
 <a style="display:none;cursor:pointer" data-toggle="modal" data-target="#feedbackModal">Feedback</a>
    {{--@include('includes.forms.feedback')--}}
    @include('includes.forms.error')
    @include('includes.forms.disclaimer')
</p>
