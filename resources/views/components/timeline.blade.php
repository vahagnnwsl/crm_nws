<div class="tab-pane active" id="timeline">
    <!-- The timeline -->


    <div class="timeline timeline-inverse">
        @foreach($resource as $day =>$activities)
            <div class="time-label">
            <span class="bg-danger">
               {{$day}}
             </span>
            </div>

            @foreach($activities as $activity)
                <div>
                    <i class="fas fa-user bg-info"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="far fa-clock"></i>{{$activity->created_at->format('H:m:s')}}</span>

                        <h3 class="timeline-header border-0"><a
                                href="#">{{$activity->subject->name_for_log}}</a> {{$activity->description}}
                        </h3>
                        <div>
                            <pre  data-json="{{json_encode($activity->changes)}}"></pre>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach


    </div>
    {!! $resource->appends($_GET)->links('vendor.pagination') !!}

</div>
