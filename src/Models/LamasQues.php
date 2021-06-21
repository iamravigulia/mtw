<?php
namespace Edgewizz\Lamas\Models;

use Illuminate\Database\Eloquent\Model;

class LamasQues extends Model{
    public function answers(){
        return $this->hasMany('Edgewizz\Lamas\Models\LamasAns', 'question_id');
    }
    protected $table = 'fmt_lamas_ques';
}