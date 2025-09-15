@extends('dashboard.base')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Envoyer  Email: {{ $template->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('mailSend', ['id' => $template->id,'link'=>'']) }}" id="email_form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label>Adresse email du destinataire</label>
                                <input class="form-control" type="text" placeholder="Email adress" name="email" required autofocus/>
                            </div>

                            @if (json_decode($template->variables))
                            <label>Variables</label>

                            <div class="form-group row table-responsive" id="variable_contents">
                                <table class="table table-responsive-sm table-bordered table-striped table-sm" id="variables-table">
                                    <thead class="thead-dark">
                                      <tr>
                                        <th>IDENTIFIANT</th>
                                        <th>Valeur</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($template->variables) as $variable )

                                        <tr>
                                            <td><input value="{{$variable->key}}" name="name" type="text"class=" variable-key form-control"/></td>
                                            <td>
                                                <input
                                                value="{{$variable->value}}"
                                                @if (isset($variable->type)&&$variable->type=="file")
                                                    type="file"
                                                    name="{{$variable->key}}"
                                                    @else
                                                     type="text"
                                                @endif
                                                class=" variable-value form-control"/>
                                            </td>
                                       </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            <input type="hidden" name="variables" id="variables">
                            <button class="btn btn-success" type="submit" id="submit">Envoyer</button>
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
<script>
    console.log("artticle","initi")
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
            if(key&& key!=undefined && key!="")
            variables.push({key:key,value:value})
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
