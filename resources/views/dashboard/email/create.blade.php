@extends('dashboard.base')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Ajouter un Template</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('mail.store') }}" id="email_form">
                            @csrf
                            <div class="form-group row">
                                <label>Code</label>
                                <input class="form-control" type="text" placeholder="Code" name="code" required autofocus/>
                            </div>
                            <div class="form-group row">
                                <label>Nom</label>
                                <input class="form-control" type="text" placeholder="Name" name="name" required autofocus/>
                            </div>
                            <div class="form-group row">
                                <label>Sujet</label>
                                <input class="form-control" type="text" placeholder="Subject" name="subject" required/>
                            </div>
                            <div class="form-group row table-responsive" id="variable_contents">
                                <label>Variables</label>
                                <table class="table table-responsive-sm table-bordered table-striped table-sm" id="variables-table">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th>IDENTIFIANT</th>
                                        <th>Type</th>
                                        <th>Valeur</th>
                                      </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <span class="btn btn-sm btn-primary pull-right" onclick="addVariable()">Ajouter</span>
                            </div>
                            <input type="hidden" name="variables" id="variables">

                            <div>
                                <input type="hidden" name="content">
                                <div class="form-group row" id="content">

                                </div>
                            </div>

                            <button class="btn btn-success" type="submit" id="submit">Ajouter</button>
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
    console.log("artticle","initi")
    initEditor("email_form","content","content")
    function addVariable(){
        let table=$("#variables-table")
    let row=`<tr>
                 <td><input type="text"class=" variable-key form-control"/></td>
                 <td><input type="text"class=" variable-type form-control" value="text"/></td>
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
            var type=$(this).find(".variable-type").val();
            var value=$(this).find(".variable-value").val();
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
