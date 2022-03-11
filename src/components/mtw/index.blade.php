<style>
    table {
        background: #fff;
        width: 100%;
        border: 0;
    }
    th {}
    td {
        border-top: 1px solid #999;
        padding: 5px;
    }
    tr:nth-child(odd) {
        background: #ddd;
    }
</style>
<table>
    <thead>
        <th>#</th>
        <th>Question</th>
        <th>Answers</th>
        <th>Hint</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </thead>
    <tbody>
        @php
        $fmt_mtw_ques = DB::table('fmt_mtw_ques')->get();
        @endphp
        @foreach ($fmt_mtw_ques as $que)
        <tr>
            <td>{{$que->id}}</td>
            <td>
                @php $que_media = DB::table('media')->where('id', $que->media_id)->first() @endphp
                <audio controls="controls" src="{{url('/')}}/storage/{{$que_media->url}}"></audio>
                {{-- <li><audio src="{{url('/')}}/storage/{{$que_media->url}}" ></li> --}}
            </td>
            <td>
                @php $fmt_mtw_ans = DB::table('fmt_mtw_ans')->where('question_id', $que->id)->orderby('arrange','asc')->get() @endphp
                <ul>
                    @foreach ($fmt_mtw_ans as $ans)
                    <li>{{$ans->answer}}</li>
                    @endforeach
                    <hr>
                    <b>Answer: </b> 
                    @foreach ($fmt_mtw_ans as $ans)
                    @if($ans->arrange == 0)
                    @else
                    {{$ans->answer}}
                    @endif
                    @endforeach
                </ul>
            </td>
            <td>{{$que->hint ?? '-null-'}}</td>
            <td>{{date('F d, Y',strtotime($que->created_at))}}</td>
            <td>{{date('F d, Y',strtotime($que->updated_at))}}</td>
            <td>
                <a href="javascript:void(0);" onclick="modalmtw({{$que->id}})">Edit</a>
                <a href="{{route('fmt.mtw.delete', $que->id)}}">Delete</a>
            </td>
        </tr>
        <x-mtw.edit :message="$que->id"/>
        @endforeach
    </tbody>
</table>
<script>
    function modalmtw($id){
        var modal = document.getElementById('modalmtw'+$id);
        modal.classList.remove("hidden");
    }
    function closeModalmtw($id){
        var modal = document.getElementById('modalmtw'+$id);
        modal.classList.add("hidden");
    }
</script>
