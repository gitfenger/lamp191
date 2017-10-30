<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    protected $fillable = ['name','title','keywords','description','order','pid'];

    public static function tree()
    {
        $categorys = Category::orderBy('order','asc')->get();
        //dd($categorys);
        return   (new Category)->getTree($categorys,'name','id','pid',0);
    }

    // 分类排序
    public function getTree($data,$field_name,$field_id = "id",$field_pid = "pid",$pid = 0)
    {
        $arr = array();
        foreach($data as $k=>$v){
            if($v->pid == 0){
                //echo $v->name;
                $arr[] = $data[$k];
                foreach($data as $m=>$n){
                    if($n->$field_pid == $v->$field_id){
                        $data[$m][$field_name] = '├﹣'.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
