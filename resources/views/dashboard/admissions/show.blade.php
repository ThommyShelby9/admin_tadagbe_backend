@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header"><h4>Admission-{{ $admission->school_id }} -{{ $admission->id }}</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <tbody>
                                    <tr>
                                        <th>
                                        ID
                                      </th>
                                        <td>
                                        {{ $admission->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Nom
                                        </th>
                                        <td>
                                        {{ $admission->first_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Prénom
                                        </th>
                                        <td>
                                        {{ $admission->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Nationalité
                                        </th>
                                        <td>
                                        {{ $admission->nationality }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Email
                                        </th>
                                        <td>
                                        {{ $admission->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Téléphone
                                        </th>
                                        <td>
                                        {{ $admission->phone }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Date de naissance
                                        </th>
                                        <td>
                                        {{ $admission->birth_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Statut de paiement
                                        </th>
                                        <td>
                                        @if($admission->payment())
                                        {!!$admission->payment()->getStatusSpan()!!}
                                        @else()
                                        <span class="badge badge-danger" >Aucun payement</span>
                                        @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Fillière
                                        </th>
                                        <td>
                                        {{ $admission->study_path_id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Statut
                                        </th>
                                        <td>
                                          {!!$admission->getStatusSpan()!!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Pièce d'identité
                                        </th>
                                        <td>
                                          @if($admission->id_card_url)
                                        <a target="__blank" href="{{Storage::disk('s3')->url($admission->id_card_url)}}"><img src="{{Storage::disk('s3')->url($admission->id_card_url)}}" width=250 heigth=250 /></a>
                                        <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($admission->id_card_url)}}" target="_blank" >Voir</a>
                                          @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Photo
                                        </th>
                                        <td>
                                          @if($admission->photo_url)
                                        <a target="__blank" href="{{Storage::disk('s3')->url($admission->photo_url)}}"><img src="{{Storage::disk('s3')->url($admission->photo_url)}}" width=250 heigth=250 /></a>
                                        <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($admission->photo_url)}}" target="_blank" >Voir</a>
                                          @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        CV
                                        </th>
                                        <td>
                                          @if($admission->cv_url)
                                        <embed src="{{Storage::disk('s3')->url($admission->cv_url)}}" width="250" height="250" type="application/pdf">
                                        <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($admission->cv_url)}}" target="_blank" >Voir</a>
                                        @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Relevé de notes du baccalauréat
                                        </th>
                                        <td>
                                          @if($admission->releve_bac_url)
                                          <embed src="{{Storage::disk('s3')->url($admission->releve_bac_url)}}" width="250" height="250" type="application/pdf">
                                          <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($admission->releve_bac_url)}}" target="_blank" >Voir</a>
                                          @endif
                                      </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Dernier diplôme obtenu
                                        </th>
                                        <td>
                                          @if($admission->last_degre_url)
                                          <embed src="{{Storage::disk('s3')->url($admission->last_degre_url)}}" width="250" height="250" type="application/pdf">
                                          <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($admission->last_degre_url)}}" target="_blank" >Voir</a>
                                          @endif
                                      </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Lettre de motivation
                                        </th>
                                        <td>
                                          @if($admission->motivation_letter_url)
                                          <embed src="{{Storage::disk('s3')->url($admission->motivation_letter_url)}}" width="250" height="250" type="application/pdf">
                                          <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($admission->motivation_letter_url)}}" target="_blank" >Voir</a>
                                          @endif
                                      </td>
                                    </tr>

                            </tbody>
                        </table>
                        <div class="row d-flex  justify-content-end">
                        <a href="{{ route('admissions.index', $admission->id) }}" class="m-2  text-primary float-right"> Retour </a>
                        <div class="card-body">
                        <form method="POST" action="{{ route('admissions.validate', $admission->id) }}" >
                            @csrf
                            @method('POST')
                        <input type="hidden" name="new_status" value="1">
                        <button type="submit" class="m-2 btn btn-success float-right"> Valider l'admission </button>
                        </form>
                        <a href="/admission/pay/{{$admission->id}}" class="m-2 btn btn-success float-right"> Payer </a>
                        <form method="POST" action="{{ route('admissions.validate', $admission->id) }}" >
                            @csrf
                            @method('POST')
                        <input type="hidden" name="new_status" value="3">
                        <button type="submit"class="m-2 btn btn-danger float-right"> Rejeter l'admission </button>
                        </form>
                      </div>

                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')

@endsection
