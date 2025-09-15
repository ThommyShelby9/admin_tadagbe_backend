@extends('dashboard.base')

@section('css')
<style>
    #container {
        width: 1000px;
        margin: 20px auto;
    }
    .ck-editor__editable[role="textbox"] {
        /* Editing area */
        min-height: 200px;
    }
    .ck-content .image {
        /* Block images */
        max-width: 80%;
        margin: 20px auto;
    }
</style>
@endsection


@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                    <div class="card-header">
                        <h4>Modification de l'article</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('articles.update', $article->id) }}"  enctype='multipart/form-data' id="article_form">
                            @csrf
                            @method('PUT')
                            @include('dashboard.articles.form_content')
                            <button id="submit" class="btn btn-success" type="submit">Sauvegarder</button>
                            <a href="{{ route('articles.index') }}" class="btn btn-primary">Retour</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
@include('shared.js.ckeditor_js')
<script>
    let article=@json($article?? null);
    console.log("artticle",article)
    initEditor("article_form","content","content",article)
</script>
@endsection
