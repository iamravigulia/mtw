<?php

namespace edgewizz\lamas\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Edgewizz\Edgecontent\Models\ProblemSetQues;
use Edgewizz\Mtw\Models\MtwAns;
use Edgewizz\Mtw\Models\MtwQues;
use Illuminate\Http\Request;

class MtwController extends Controller
{
    public function store(Request $request){
        $mofQ = new MtwQues();
        $mofQ->difficulty_level_id = $request->difficulty_level_id;
        $mofQ->format_title = $request->format_title;
        $mofQ->question = $request->question;
        for ($i = 1; $i <= 6; $i++){
            $word = 'word'.$i;
            if($request->$word){
                $mofQ->$word = $request->word;
            }
        }
        $mofQ->hint = $request->hint;
        $mofQ->save();
        for ($i=0; $i <=6; $i++) { 
            # code...
            $answer = 'answer'.$i;
            $arrange = 'arrange'.$i;
            $eng_word = 'eng_word'.$i;
            if($request->$answer){
                $ans1 = new MtwAns();
                $ans1->question_id = $mofQ->id;
                $ans1->answer = $request->$answer;
                $ans1->arrange = $request->$arrange;
                $ans1->eng_word = $request->$eng_word;
                $ans1->save();
            }
        }
        /* answer1 */
        if($request->problem_set_id && $request->format_type_id){
            $pbq = new ProblemSetQues();
            $pbq->problem_set_id = $request->problem_set_id;
            $pbq->question_id = $mofQ->id;
            $pbq->format_type_id = $request->format_type_id;
            $pbq->save();
        }
        return back();
    }
    public function update($id, Request $request){
        /* $q = MtwQues::where('id', $id)->first();
        $q->difficulty_level_id = $request->difficulty_level_id;
        if($request->format_title){
            $q->format_title = $request->format_title;
        }
        if($request->question_media){
            $ques_media = new Media();
            $request->question_media->storeAs('public/answers', time().$request->question_media->getClientOriginalName());
            $ques_media->url = 'answers/'.time().$request->question_media->getClientOriginalName();
            $ques_media->save();
            $q->media_id = $ques_media->id;
        }
        if($request->question_media_es){
            $ques_media_es = new Media();
            $name_es = time().$request->question_media_es->getClientOriginalName();
            $request->question_media_es->storeAs('public/answers', $name_es);
            $ques_media_es->url = 'answers/'.$name_es;
            $ques_media_es->save();
            $q->media_id_es = $ques_media_es->id;
        }
        // $q->level = $request->question_level;
        // $q->score = $request->question_score;
        $q->hint = $request->hint;
        $q->save();
        $answers = MtwAns::where('question_id', $q->id)->get();
        foreach($answers as $ans){
            if($request->ans.$ans->id){
                $inputAnswer = 'answer'.$ans->id;
                $inputArrange = 'arrange'.$ans->id;
                $inputEngWord = 'eng_word'.$ans->id;
                $ans->answer = $request->$inputAnswer;
                $ans->eng_word = $request->$inputEngWord;
                if($request->$inputArrange){
                    $ans->arrange = $request->$inputArrange;
                }else{
                    $ans->arrange = 0;
                }
                $ans->save();
            }
        }
        return back(); */
    }

    public function delete($id){
        $f = MtwQues::where('id', $id)->first();
        $f->delete();
        $ans = MtwAns::where('question_id', $f->id)->pluck('id');
        if($ans){
            foreach($ans as $a){
                $f_ans = MtwAns::where('id', $a)->first();
                $f_ans->delete();
            }
        }
        return back();
    }

    public function imagecsv($question_image, $images){
        foreach($images as $valueImage){
            $uploadImage = explode(".", $valueImage->getClientOriginalName());
            if($uploadImage[0] == $question_image){
                // dd($valueImage);
                $name = time(). uniqid() . $valueImage->getClientOriginalName();
                $media = new Media();
                $valueImage->storeAs('public/question_images', $name);
                $media->url = 'question_images/' . $name;
                $media->save();
                return $media->id;
            }
        }
    }
    public function csv_upload(Request $request){
        $file = $request->file('file');
        $audio = $request->file('audio');
        $audio_es = $request->file('audio_es');
        // dd($file);
        // File Details
        $filename = time() . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        // Valid File Extensions
        $valid_extension = array("csv");
        // 2MB in Bytes
        $maxFileSize = 2097152;
        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            // Check file size
            if ($fileSize <= $maxFileSize) {
                // File upload location
                $location = 'uploads/Mtw';
                // Upload file
                $file->move($location, $filename);
                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);
                // Reading file
                $file = fopen($filepath, "r");
                $importData_arr = array();
                $i = 0;
                while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                    $num = count($filedata);
                    // Skip first row (Remove below comment if you want to skip the first row)
                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);
                // Insert to MySQL database
                foreach ($importData_arr as $importData) {
                    $insertData = array(
                        "question"          => $importData[1],
                        "word1"             => $importData[1],
                        "word2"             => $importData[1],
                        "word3"             => $importData[1],
                        "word4"             => $importData[1],
                        "word5"             => $importData[1],
                        "word6"             => $importData[1],
                        "word1"             => $importData[1],
                        "answer1"           => $importData[2],
                        "arrange1"          => $importData[3],
                        "eng_word1"         => $importData[4],
                        "answer2"           => $importData[5],
                        "arrange2"          => $importData[6],
                        "eng_word2"         => $importData[7],
                        "answer3"           => $importData[8],
                        "arrange3"          => $importData[9],
                        "eng_word3"         => $importData[10],
                        "answer4"           => $importData[11],
                        "arrange4"          => $importData[12],
                        "eng_word4"         => $importData[13],
                        "answer5"           => $importData[14],
                        "arrange5"          => $importData[15],
                        "eng_word5"         => $importData[16],
                        "answer6"           => $importData[17],
                        "arrange6"          => $importData[18],
                        "eng_word6"         => $importData[19],
                        "level"             => $importData[20],
                        "comment"           => $importData[21],
                    );
                    // var_dump($insertData['answer1']);
                    /*  */
                    if ($insertData['question']) {
                        $fill_Q = new MtwQues();
                        // $fill_Q->question = $insertData['question'];
                        if($request->format_title){
                            $fill_Q->format_title = $request->format_title;
                        }
                        if ($insertData['question'] && $insertData['question'] != '-') {
                            $fill_Q->question = $insertData['question'];
                        }
                        if ($insertData['word1'] && $insertData['word1'] != '-') {
                            $fill_Q->word1 = $insertData['word1'];
                        }
                        if ($insertData['word2'] && $insertData['word2'] != '-') {
                            $fill_Q->word2 = $insertData['word2'];
                        }
                        if ($insertData['word3'] && $insertData['word3'] != '-') {
                            $fill_Q->word3 = $insertData['word3'];
                        }
                        if ($insertData['word4'] && $insertData['word4'] != '-') {
                            $fill_Q->word4 = $insertData['word4'];
                        }
                        if ($insertData['word5'] && $insertData['word5'] != '-') {
                            $fill_Q->word5 = $insertData['word5'];
                        }
                        if ($insertData['word6'] && $insertData['word6'] != '-') {
                            $fill_Q->word6 = $insertData['word6'];
                        }
                        if(!empty($insertData['level'])){
                            if($insertData['level'] == 'easy'){
                                $fill_Q->difficulty_level_id = 1;
                            }else if($insertData['level'] == 'medium'){
                                $fill_Q->difficulty_level_id = 2;
                            }else if($insertData['level'] == 'hard'){
                                $fill_Q->difficulty_level_id = 3;
                            }
                        }
                        if ($insertData['comment']) {
                            $fill_Q->hint = $insertData['comment'];
                        }
                        // $m = new Media();
                        // $m->url = $insertData['question_media'];
                        // $m->save();
                        // $fill_Q->media_id = $m->id;
                        $fill_Q->save();
                        if($request->problem_set_id && $request->format_type_id){
                            $pbq = new ProblemSetQues();
                            $pbq->problem_set_id = $request->problem_set_id;
                            $pbq->question_id = $fill_Q->id;
                            $pbq->format_type_id = $request->format_type_id;
                            $pbq->save();
                        }

                        for ($x = 1; $x <= 6; $x++) {
                            $f_answer  = $insertData['answer'.$x];
                            $f_arrange  = $insertData['arrange'.$x];
                            $f_eng_word  = $insertData['eng_word'.$x];
                            
                            if ($f_answer == '-') {
                            } else {
                                $f_Ans1 = new MtwAns();
                                $f_Ans1->question_id = $fill_Q->id;
                                $f_Ans1->answer = $f_answer;
                                $f_Ans1->arrange = $f_arrange;
                                if ($f_eng_word == '-') {
                                } else {
                                    $f_Ans1->eng_word = $f_eng_word;
                                }
                                $f_Ans1->save();
                            }
                        }
                    }
                    /*  */
                }
                // Session::flash('message', 'Import Successful.');
            } else {
                // Session::flash('message', 'File too large. File must be less than 2MB.');
            }
        } else {
            // Session::flash('message', 'Invalid File Extension.');
        }
        return back();
    }
    public function inactive($id){
        $f = MtwQues::where('id', $id)->first();
        $f->active = '0';
        $f->save();
        return back();
    }
    public function active($id){
        $f = MtwQues::where('id', $id)->first();
        $f->active = '1';
        $f->save();
        return back();
    }
}
