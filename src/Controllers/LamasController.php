<?php

namespace edgewizz\lamas\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Edgewizz\Edgecontent\Models\ProblemSetQues;
use Edgewizz\Lamas\Models\LamasAns;
use Edgewizz\Lamas\Models\LamasQues;
use Illuminate\Http\Request;

class LamasController extends Controller
{
    public function store(Request $request){
        $mofQ = new LamasQues();
        $mofQ->difficulty_level_id = $request->difficulty_level_id;
        $mofQ->format_title = $request->format_title;
        $ques_media = new Media();
        $name = time().$request->question_media->getClientOriginalName();
        $request->question_media->storeAs('public/answers', $name);
        $ques_media->url = 'answers/'.$name;
        $ques_media->save();
        if($request->question_media_es){
            $ques_media_es = new Media();
            $name_es = time().$request->question_media_es->getClientOriginalName();
            $request->question_media_es->storeAs('public/answers', $name_es);
            $ques_media_es->url = 'answers/'.$name_es;
            $ques_media_es->save();
            $mofQ->media_id_es = $ques_media_es->id;
        }
        $mofQ->media_id = $ques_media->id;
        // $mofQ->level = $request->question_level;
        // $mofQ->score = $request->question_score;
        $mofQ->hint = $request->hint;
        $mofQ->save();
        /* answer1 */
        if($request->answer1){
            $ans1 = new LamasAns();
            $ans1->question_id = $mofQ->id;
            $ans1->answer = $request->answer1;
            $ans1->arrange = $request->arrange1;
            $ans1->eng_word = $request->eng_word1;
            $ans1->save();
        }
        /* answer1 */
        /* answer2 */
        if($request->answer2){
            $ans2 = new LamasAns();
            $ans2->question_id = $mofQ->id;
            $ans2->answer = $request->answer2;
            $ans2->arrange = $request->arrange2;
            $ans2->eng_word = $request->eng_word2;
            $ans2->save();
        }
        /* answer2 */
        /* answer3 */
        if($request->answer3){
            $ans3 = new LamasAns();
            $ans3->question_id = $mofQ->id;
            $ans3->answer = $request->answer3;
            $ans3->arrange = $request->arrange3;
            $ans3->eng_word = $request->eng_word3;
            $ans3->save();
        }
        /* answer3 */
        /* answer4 */
        if($request->answer4){
            $ans4 = new LamasAns();
            $ans4->question_id = $mofQ->id;
            $ans4->answer = $request->answer4;
            $ans4->arrange = $request->arrange4;
            $ans4->eng_word = $request->eng_word4;
            $ans4->save();
        }
        /* answer4 */
        /* answer5 */
        if($request->answer5){
            $ans5 = new LamasAns();
            $ans5->question_id = $mofQ->id;
            $ans5->answer = $request->answer5;
            $ans5->arrange = $request->arrange5;
            $ans5->eng_word = $request->eng_word5;
            $ans5->save();
        }
        /* answer5 */
        /* answer6 */
        if($request->answer6){
            $ans6 = new LamasAns();
            $ans6->question_id = $mofQ->id;
            $ans6->answer = $request->answer6;
            $ans6->arrange = $request->arrange6;
            $ans6->eng_word = $request->eng_word6;
            $ans6->save();
        }
        /* answer6 */
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
        $q = LamasQues::where('id', $id)->first();
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
        $answers = LamasAns::where('question_id', $q->id)->get();
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
        return back();
    }

    public function delete($id){
        $f = LamasQues::where('id', $id)->first();
        $f->delete();
        $ans = LamasAns::where('question_id', $f->id)->pluck('id');
        if($ans){
            foreach($ans as $a){
                $f_ans = LamasAns::where('id', $a)->first();
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
                $location = 'uploads/lamas';
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
                        "question_media"    => $importData[1],
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
                        "media_es"          => $importData[22],
                    );
                    // var_dump($insertData['answer1']);
                    /*  */
                    if ($insertData['question_media']) {
                        $fill_Q = new LamasQues();
                        // $fill_Q->question = $insertData['question'];
                        if($request->format_title){
                            $fill_Q->format_title = $request->format_title;
                        }
                        if (!empty($insertData['question_media']) && $insertData['question_media'] != '') {
                            $media_id = $this->imagecsv($insertData['question_media'], $audio);
                            $fill_Q->media_id = $media_id;
                        }
                        if (!empty($insertData['media_es']) && $insertData['media_es'] != '') {
                            $media_id_es = $this->imagecsv($insertData['media_es'], $audio_es);
                            $fill_Q->media_id_es = $media_id_es;
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
                                $f_Ans1 = new LamasAns();
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
                        /* if ($insertData['answer1'] == '-') {
                        } else {
                            $f_Ans1 = new LamasAns();
                            $f_Ans1->question_id = $fill_Q->id;
                            $f_Ans1->answer = $insertData['answer1'];
                            $f_Ans1->arrange = $insertData['arrange1'];
                            $f_Ans1->save();
                        }
                        if ($insertData['answer2'] == '-') {
                        } else {
                            $f_Ans2 = new LamasAns();
                            $f_Ans2->question_id = $fill_Q->id;
                            $f_Ans2->answer = $insertData['answer2'];
                            $f_Ans2->arrange = $insertData['arrange2'];
                            $f_Ans2->save();
                        }
                        if ($insertData['answer3'] == '-') {
                        } else {
                            $f_Ans3 = new LamasAns();
                            $f_Ans3->question_id = $fill_Q->id;
                            $f_Ans3->answer = $insertData['answer3'];
                            $f_Ans3->arrange = $insertData['arrange3'];
                            $f_Ans3->save();
                        }
                        if ($insertData['answer4'] == '-') {
                        } else {
                            $f_Ans4 = new LamasAns();
                            $f_Ans4->question_id = $fill_Q->id;
                            $f_Ans4->answer = $insertData['answer4'];
                            $f_Ans4->arrange = $insertData['arrange4'];
                            $f_Ans4->save();
                        }
                        if ($insertData['answer5'] == '-') {
                        } else {
                            $f_Ans5 = new LamasAns();
                            $f_Ans5->question_id = $fill_Q->id;
                            $f_Ans5->answer = $insertData['answer5'];
                            $f_Ans5->arrange = $insertData['arrange5'];
                            $f_Ans5->save();
                        }
                        if ($insertData['answer6'] == '-') {
                        } else {
                            $f_Ans6 = new LamasAns();
                            $f_Ans6->question_id = $fill_Q->id;
                            $f_Ans6->answer = $insertData['answer6'];
                            $f_Ans6->arrange = $insertData['arrange6'];
                            $f_Ans6->save();
                        } */
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
        $f = LamasQues::where('id', $id)->first();
        $f->active = '0';
        $f->save();
        return back();
    }
    public function active($id){
        $f = LamasQues::where('id', $id)->first();
        $f->active = '1';
        $f->save();
        return back();
    }
}
