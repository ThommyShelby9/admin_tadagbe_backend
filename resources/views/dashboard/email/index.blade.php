@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>Template des emails</div>
                    <div class="card-body">
                        @if(Session::has('message'))
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                </div>
                            </div>
                         @endif
                        <div class="row">
                          <a href="{{ route('mail.create') }}" class="btn btn-primary m-2">Ajouter Template</a>
                        </div>
                        <br>
                        <table class="table table-responsive-sm table-striped">
                        <thead>
                          <tr>
                            <th>Nom</th>
                            <th>Sujet</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($emailTemplates as $mail)
                            <tr>
                              <td><strong>{{ $mail->name }}</strong></td>
                              <td><strong>{{ $mail->subject }}</strong></td>
                              <td>
                                <a href="{{ route('prepareSend', ['id' => $mail->id] ) }}" class="btn btn-warning">Envoyer</a>
                              </td>
                              <td>
                                <a href="{{ url('/mail/' . $mail->id) }}" class="btn btn-primary">Voir</a>
                              </td>
                              <td>
                                <a href="{{ url('/mail/' . $mail->id . '/edit') }}" class="btn btn-primary">Modifier</a>
                              </td>
                              <td>
                                <a href="{{ url('/mails/duplicate/' . $mail->id) }}" class="btn btn-primary">Dupliquer</a>
                              </td>
                              <td>
                                <form action="{{ route('mail.destroy', $mail->id ) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger">Supprimer</button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $emailTemplates->links() }}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection
