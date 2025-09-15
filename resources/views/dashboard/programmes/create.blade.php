@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>Ajouter Programmes
                    </div>
                    <div class="card-body">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="form-group row">
                            <label>Ecole</label>
                            <select name="school_id" id="school_id" class="select2 form-controle" >
                                <option value="EIMCT" {{isset($school_id)&&$school_id=="EIMCT"?'selected':''}}>EIMCT</option>
                                <option value="EIEGI" {{isset($school_id)&&$school_id=="EIEGI"?'selected':''}}>EIEGI</option>
                                <option value="HUPEJUS" {{isset($school_id)&&$school_id=="HUPEJUS"?'selected':''}}>HUPEJUS</option>
                            </select>
                        </div>

                            <div class="form-group row">
                                <label>Sélectionner la date</label>
                                <input class="form-control" id="course_date" type="date" placeholder="date" name="title" required autofocus>
                            </div>
                            <div >
                                <table id="creno_table">

                                </table>
                                <span class="btn btn-sm btn-primary" onclick="addCreno()">Ajouter</span>
                            </div>


                    </div>
                    <div class="footer  align-items-end pull-right">
                      <button class="btn  btn-success pull-right" onclick="saveCreno()" >Sauvegarder</button>
                        <a href="{{ route('programmes.index') }}" class="btn  btn-primary pull-right">Retour</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')
<script>
  function addCreno(){
    console.log("add creno")
    let table=$("#creno_table");
    let creno=
    `
    <tr>
      <td>
        <label for="cours" class="form-label">Intitulé du cours</label>
        <textarea  cols="20" id="course" type="cours" class="form-control" aria-describedby="coursHelpBlock"></textarea>
      </td>
      <td>
        <label for="cours" class="form-label">Heure de début du cours</label>
        <div class="input-group ">
          <input id="start_at_hours" type="number" class="form-control" placeholder="Heure de début" aria-label="Heure de début">
          <span class="input-group-text">h</span>
          <input id="start_at_min" type="number" value="0" class="form-control" placeholder="min" aria-label="min">
        </div>
      </td>

      <td>
        <label for="cours" class="form-label">Durée du cours</label>
        <div class="input-group ">
          <input id="duration_hours" type="number" value="2" class="form-control" placeholder="Durée du cours" aria-label="Durée du cours">
          <span class="input-group-text">h</span>
          <input id="duration_min" type="number" value="0" class="form-control" placeholder="min" aria-label="min">
        </div>
      </td>

      <td>
      <label for="teacher" class="form-label">Chargé du cours</label>
      <input id="teacher" type="teacher"  class="form-control" aria-describedby="teacher">
      </td>

      <td>
       <span class="btn btn-sm btn-danger mt-4 delete" id="delete">Supprimer</span>
      </td>
    </tr>
    `
    table.append(creno);
    table.on("click", "#delete", function() {
   $(this).closest("tr").remove();
});

  }

  function getCrenoData(){
    let programme={
      date:$("#course_date").val(),
      school_id:$("#school_id").val()

    }
    let data=[];
    $("#creno_table tr").each(function(){
      let creno={}
      let course=$(this).find("#course").val();
      let start_at=$(this).find("#start_at_hours").val()+"h"+$(this).find("#start_at_min").val();
      let duration=$(this).find("#duration_hours").val()+"h"+$(this).find("#duration_min").val();
      let teacher=$(this).find("#teacher").val();
      creno.course=course;
      creno.start_at=start_at;
      creno.duration=duration;
      creno.teacher=teacher;
      console.log("Creno",creno)
      data.push(creno);
    })
    programme.courses=data;
    console.log("Programme",programme)
    return programme;
  }
  function saveCreno(){
    console.log("Token",$('meta[name="csrf-token"]').attr('content') )
    let data=getCrenoData();
    data.isAjax=true
    $.ajax({
    type: "POST",
    url: "/programmes",
    data: data,
    headers:
    {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    datatype: "json",
    success: function(res){
         window.location.href="/programmes"
    },
    error:function(err){
      conso
le.log("error",err)
    }
    //dataType: dataType
  });
  }
</script>

@endsection
