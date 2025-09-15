@extends('dashboard.base')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Modifier Template</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('mail.update', $template->id) }}" id="email_form">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label>Nom</label>
                                <input class="form-control" type="text" placeholder="Name" name="name" required autofocus value="{{ $template->name }}"/>
                            </div>
                            <div class="form-group row">
                                <label>Sujet</label>
                                <input class="form-control" type="text" placeholder="Subject" name="subject" required value="{{ $template->subject }}"/>
                            </div>
                            @if (json_decode($template->variables))
                            <label>Variables</label>

                            <div class="form-group row table-responsive" id="variable_contents">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm" id="variables-table">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th>IDENTIFIANT</th>
                                        <th>Type</th>
                                        <th>Valeur</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($template->variables) as $variable )
                                        <tr>
                                            <td><input value="{{$variable->key}}" type="text"class=" variable-key form-control"/></td>
                                            <td>
                                                <input value="{{isset($variable->type)?$variable->type:'text'}}"
                                                type="text"class=" variable-type form-control"/>
                                            </td>
                                            <td><input value="{{$variable->value}}" type="text" class=" variable-value form-control"/></td>
                                       </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                                <span class="btn btn-sm btn-primary pull-right" onclick="addVariable()">Ajouter</span>
                            </div>
                            @endif
                            <label>Contenu</label>
                            <div class="form-group row" id="content">
                                <img src="img_girl.jpg" alt="Girl in a jacket" width="500" height="600">
                                <textarea class="form-control"
                                name="content"
                                rows="20" placeholder="Content"
                                required>{{ $template->content }}
                            </textarea>
                            </div>
                            <div class="form-group row">



                            </div>

                            <input type="hidden" name="variables" id="variables">
                            <button class="btn btn-success" type="submit"id="submit">Modifier</button>
                            <a href="{{ route('mail.index') }}" class="btn btn-primary">Retour</a>
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
        let template=@json($template?? null);

    console.log("artticle",template)
    initEditor("email_form","content","content",template)
    function addVariable(){
        let table=$("#variables-table")
    let row=`<tr>
                 <td><input type="text"class=" variable-key form-control"/></td>
                 <td><input type="text"class=" variable-value form-control"/></td>
            </tr>
            `
            table.append(row)
            console.log("Vriables",getVariables())
    }
    function getVariables(){
        let variables=[];
        $("#variables-table tr").each(function() {
            var key=$(this).find(".variable-key").val();
            var value=$(this).find(".variable-value").val();
            var type=$(this).find(".variable-type").val();

            if(key&& key!=undefined && key!="")
            variables.push({key:key,value:value,type:type})
        });
        $("#variables").val(JSON.stringify(variables) );
        console.log("variable",variables)
        return variables;
    }
    $( "#submit" ).on( "click", function( event ) {
        getVariables();
        $( "#email_form" ).trigger( "submit" );
        });
</script>
@endsection
