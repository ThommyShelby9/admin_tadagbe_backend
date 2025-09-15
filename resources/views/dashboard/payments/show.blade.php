@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header"><h4>Payment -{{ $payment->id }}</h4></div>
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
                                        {{ $payment->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Montant
                                      </th>
                                        <td>
                                        {{ $payment->amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Nom
                                        </th>
                                        <td>
                                        {{ $payment->admission->first_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Prénom
                                        </th>
                                        <td>
                                        {{ $payment->admission->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Nationalité
                                        </th>
                                        <td>
                                        {{ $payment->admission->nationality }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Date de naissance
                                        </th>
                                        <td>
                                        {{ $payment->admission->birth_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Moyen de paiement
                                        </th>
                                        <td>
                                        {{ $payment->payment_method}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                        Statut
                                        </th>
                                        <td>
                                          <span class="badge  {{ $payment->status==2?'badge-success':'badge-warning' }}">{{ $payment->status==2?'Validée':'En attente' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        Photo
                                        </th>
                                        <td>
                                          @if($payment->admission->photo_url)
                                        <a target="__blank" href="{{Storage::disk('s3')->url($payment->admission->photo_url)}}"><img src="{{Storage::disk('s3')->url($payment->admission->photo_url)}}" width=250 heigth=250 /></a>
                                        <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($payment->admission->photo_url)}}" target="_blank" >Voir</a>
                                          @endif
                                        </td>
                                    </tr>



                                    <tr>
                                        <th>
                                        Preuve de versement des frais
                                        </th>
                                        <td>
                                          @if($payment->payment_proof)
                                         <a target="__blank" href="{{Storage::disk('s3')->url($payment->payment_proof)}}"><img src="{{Storage::disk('s3')->url($payment->payment_proof)}}" width=250 heigth=250 /></a>
                                         <a class="btn btn-sm btn-info" href="{{Storage::disk('s3')->url($payment->payment_proof)}}" target="_blank" >Voir</a>
                                          @endif
                                      </td>
                                    </tr>
                            </tbody>
                        </table>
                        <a
                            href="{{ route('payments.index', $payment->id) }}"
                            class="btn btn-primary pull-right"
                        >
                            Retour
                        </a>
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
