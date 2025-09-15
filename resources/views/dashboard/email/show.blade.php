@extends('dashboard.base')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Template: {{ $template->name }}</h4>
                    </div>
                    <div class="card-body" id="email_form">
                        <h4>Nom</h4>
                        <p>{{ $template->name }}</p>
                        <h4>Sujet</h4>
                        <p>{{ $template->subject }}</p>
                        <h4>Contenu</h4>
                        <p id="content" readonly>
                            {{ $template->content }}
                        </p>


                        <a href="{{ route('mail.index') }}" class="btn btn-primary">Retour</a> 
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
        let template=@json($template?? null);

    console.log("artticle",template)
    initEditor("email_form","content","content",template)
</script>
@endsection