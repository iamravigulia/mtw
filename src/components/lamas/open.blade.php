<div>
    <style>
        .fmt_box{
            margin: 10px 20px;
            padding: 10px 20px;
            border: 4px solid #eeeeee;
            background: #fff;
            box-shadow: 2px 4px 8px #b1b1b1;
        }
        .fmt_headline{
            font-size: 20px;
            margin:10px 0;
        }
        .fmt_label{
            font-size: 14px;
        }
        .fmt_input{
            padding:4px 10px;
            border:1px solid #707070;
            border-radius: 4px;
            display: block;
            font-size: 16px;
        }
        .fmt_sub_btn{
            padding:6px 20px;
            margin:10px 0;
            border-radius: 8px;
            background:#0047d4;
            color:#fff;
            border:none;
            letter-spacing: 1px;
            cursor: pointer;
        }
        .fmt_checkbox{
            width: 22px;
            height: 22px;
            display: block;
        }
        .fmt_flex{
            display: flex;
            margin: 10px 0;
        }
        #addOption{
            padding: 6px 20px;
            background: #049e04;
            color: #fff;
            cursor: pointer;
        }
    </style>
    <form action="{{route('fmt.lamas.store')}}" method="post" class="fmt_box" enctype="multipart/form-data">
        <div class="fmt_headline">Add a "Listen the Audio & Choose the words and make a sentence"</div>
        <input type="integer" name="problem_set_id" value="{{$pbs72 ?? ''}}" hidden style="border:1px solid #000000;">
        <input type="integer" name="format_type_id" value="{{$fmt72 ?? ''}}" hidden style="border:1px solid #000000;">
        <div>
            <label class="fmt_label" for="">Format Title</label>
            <input class="fmt_input" type="text" name="format_title" style="width: 100%;" placeholder="format_title">
        </div>
        <div>
            <label class="fmt_label" for="">Comment</label>
            <textarea class="fmt_input" type="text" name="hint" placeholder="comment" style="width: 100%;"></textarea>
        </div>
        <div>
            <label class="fmt_label" for="">Question audio</label>
            <input class="fmt_input" type="file" accept="audio/*" name="question_media" placeholder="Question" style="width: 100%;" required>
            {{-- <textarea class="border border-gray-400 p" name="" id="" cols="30" rows="10"></textarea> --}}
        </div>
        <div class="my-2" style="margin:20px 0;">
            <label class="bloc" for="">Difficulty Level</label>
            @php $d_levels = DB::table('difficulty_levels')->get(); @endphp
            <select name="difficulty_level_id" id="" class="w-full my-2 px-2 py-2 border border-gray-500 rounded-lg">
                @foreach ($d_levels as $level)
                <option value="{{$level->id}}">{{$level->name}}</option>
                @endforeach
            </select>
        </div>
        <hr>
        {{-- answer1-arrange1 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 1</label>
                <input class="fmt_input" type="text" name="answer1" placeholder="Answer" required>
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">Arrange for Answer 1</label>
                <input class="fmt_input" type="integer" name="arrange1" placeholder="Arrange for Answer 1" required>
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">English Word 1</label>
                <input class="fmt_input" type="integer" name="eng_word1" placeholder="English Word 1" required>
            </div>
        </div>
        {{-- //answer2-arrange2 --}}
        {{-- answer2-arrange2 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 2</label>
                <input class="fmt_input" type="text" name="answer2" placeholder="Answer">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">Arrange for Answer 2</label>
                <input class="fmt_input" type="integer" name="arrange2" placeholder="Arrange for Answer 2">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">English Word 2</label>
                <input class="fmt_input" type="integer" name="eng_word2" placeholder="English Word 2">
            </div>
        </div>
        {{-- //answer2-arrange2 --}}
        {{-- answer3-arrange3 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 3</label>
                <input class="fmt_input" type="text" name="answer3" placeholder="Answer">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">Arrange for Answer 3</label>
                <input class="fmt_input" type="integer" name="arrange3" placeholder="Arrange for Answer 3">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">English Word 3</label>
                <input class="fmt_input" type="integer" name="eng_word3" placeholder="English Word 3">
            </div>
        </div>
        {{-- //answer3-arrange3 --}}
        {{-- answer4-arrange4 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 4</label>
                <input class="fmt_input" type="text" name="answer4" placeholder="Answer">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">Arrange for Answer 4</label>
                <input class="fmt_input" type="integer" name="arrange4" placeholder="Arrange for Answer 4">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">English Word 4</label>
                <input class="fmt_input" type="integer" name="eng_word4" placeholder="English Word 4">
            </div>
        </div>
        {{-- //answer4-arrange4 --}}
        {{-- answer5-arrange5 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 5</label>
                <input class="fmt_input" type="text" name="answer5" placeholder="Answer">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">Arrange for Answer 5</label>
                <input class="fmt_input" type="integer" name="arrange5" placeholder="Arrange for Answer 5">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">English Word 5</label>
                <input class="fmt_input" type="integer" name="eng_word5" placeholder="English Word 5">
            </div>
        </div>
        {{-- //answer5-arrange5 --}}
        {{-- answer6-arrange6 --}}
        <div class="fmt_flex">
            <div>
                <label class="fmt_label" for="">Answer 6</label>
                <input class="fmt_input" type="text" name="answer6" placeholder="Answer">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">Arrange for Answer 6</label>
                <input class="fmt_input" type="integer" name="arrange6" placeholder="Arrange for Answer 6">
            </div>
            <div style="margin-left:20px;">
                <label class="fmt_label" for="">English Word 6</label>
                <input class="fmt_input" type="integer" name="eng_word6" placeholder="English Word 6">
            </div>
        </div>
        {{-- //answer6-arrange6 --}}
        <div>
            <input type="submit" class="fmt_sub_btn" value="Submit">
        </div>
    </form>
    {{-- <button id="addOption">Add option</button> --}}
</div>
{{-- <script>
    var addOption = document.getElementById('addOption');

</script> --}}

{{--  --}}
<form action="{{route('fmt.lamas.csv')}}" method="POST" enctype='multipart/form-data' style="margin:20px 40px;">
    @csrf
    <input type="integer" name="problem_set_id" value="{{$pbs72 ?? ''}}" hidden style="border:1px solid #000000;">
    <input type="integer" name="format_type_id" value="{{$fmt72 ?? ''}}" hidden style="border:1px solid #000000;">
    <div style="display:block; padding:10px;">
        <label style="font-size:12px;">Format Title</label>
        <input class="fmt_input" type="text" name="format_title" placeholder="format_title">
    </div>
    <div style="display:block; padding:10px;">
        <div style="font-size:12px;">CSV</div>
        <input style="display:block;" type="file" name="file">
    </div>
    <div style="display:block; padding:10px;">
        <div style="font-size:12px;">Audio</div>
        <input style="display:block;" type="file" name="audio[]" multiple accept="audio/*" placeholder="audio" required>
    </div>
    <button type="submit" style="display: inline-block; margin:10px; padding:4px 20px; background:green; color:#fff; text-transform:uppercase; border-radius:4px;">submit</button>
</form>
{{--  --}}