@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>Utilisateurs</div>
                    <div class="card-body">
                    <div class="row"> 
                          <a href="{{ route('users.create') }}" class="btn btn-primary m-2 pull-right">{{ __('Nouvel utilisateur') }}</a>
                        </div>
                    @include('dashboard.admin.table')
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')

<script type="text/javascript">
  $(function () {
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'menuroles', name: 'menuroles'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    });
  });
</script>

@endsection

