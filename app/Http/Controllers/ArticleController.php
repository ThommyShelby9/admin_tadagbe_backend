<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ArticleDataTable;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $articleRepo;
    public function __construct(ArticleRepository $repo){
        $this->articleRepo=$repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,ArticleDataTable $dataTable){

        $school_id=$request->query("school_id");
        session(["school_id"=>$school_id]);
                if($school_id)
        $dataTable->with("school_id",$school_id);
        return $dataTable->render('dashboard.articles.index');
    }
    public function datatables(ArticleDataTable $dataTable)
    {
        return $dataTable->ajax();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $school_id=$request->query("school_id");
        $article=new Article();
        return view('dashboard.articles.create',compact("school_id","article"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $validatedData = $request->validate([
            'title'             => 'required',
            'content'           => 'required',
        ]);
        $user = auth()->user();
        $data=$request->all();
        $article = new Article($data);
        $article->save();
        if($request->image1)
        $this->uploadImage($article,$request->image1,"image1");
        if($request->image2)
        $this->uploadImage($article,$request->image2,"image2");
        if($request->image3)
        $this->uploadImage($article,$request->image3,"image3");
        $request->session()->flash('message', 'Succès');
        return redirect()->route('articles.index');
    }
    public function uploadImage($article,$file,$name,$school="all"){
        $file_name=$file->getClientOriginalName();
        $ext=$file->extension();
        $stamp=time();
        $storage_path='articles/'.$article->id."/".$school."/".$name."/".$stamp.".".$ext;
        $result = Storage::disk('s3')->put($storage_path, file_get_contents($file));
        if($result){
        $article->update([$name=>$storage_path]);
        return Storage::disk('s3')->url($storage_path);
        }

        return;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article= Article::find($id);
        $school_id=$article->school_id;
        return view('dashboard.articles.edit',compact('article',"school_id"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article= Article::find($id);
        $user = auth()->user();
        $data=$request->all();
        $article->update($data);
        if($request->image1)
        $this->uploadImage($article,$request->image1,"image1");
        if($request->image2)
        $this->uploadImage($article,$request->image2,"image2");
        if($request->image3)
        $this->uploadImage($article,$request->image3,"image3");
        $request->session()->flash('message', 'Succès');
        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $this->articleRepo->delete($id);
        $request->session()->flash('error', 'Supprimé');
        return redirect("/articles");
    }
}
