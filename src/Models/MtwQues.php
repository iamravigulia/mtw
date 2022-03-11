<?php
namespace Edgewizz\Mtw\Models;

use Illuminate\Database\Eloquent\Model;

class MtwQues extends Model{
    public function answers(){
        return $this->hasMany('Edgewizz\Mtw\Models\MtwAns', 'question_id');
    }
    protected $table = 'fmt_mtw_ques';
}