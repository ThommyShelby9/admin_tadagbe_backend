<?php

namespace App\Repositories;

use MrAtiebatie\Repository;
use App\Models\Article; 

class ArticleRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        // setup the model
        $this->model = app(Article::class);
    }
    public function store($data) {
        $exist= $this->model->where("title",$data["title"])->first();
        $article=null;
        if($exist&& $exist->id){
            $exist->update($data);
            $article= $exist;
        }else{
            $article=$this->model->create($data);
        }
        return $article ;
    }
    public function update($id,$data) {
        $article=$this->model->find($id);
        $response=null;
        if($article)
        $response=$article->update($data);
        return $response;      
    }
    public function get($id) {
        return $this->model->find($id);
    }
    public function list($data=null) {
        $response=null;
        if($data)
             $response= $this->model->where($data)->get();
        else
             $response=$this->model->all();
        return $response;
    }
    public function delete($id) {
        return $this->model->find($id)->delete();
    }

   
}
