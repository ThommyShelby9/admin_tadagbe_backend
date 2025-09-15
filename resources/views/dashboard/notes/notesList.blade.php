@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i>Messages</div>
                    <div class="card-body">
                        <div class="row"> 
                          <a href="{{ route('notes.create') }}" class="btn btn-primary m-2">{{ __('Add Note') }}</a>
                        </div>
                        <br>
                        @include('dashboard.notes.table')

                       
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
    var table = $('#notes-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('notes.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'content', name: 'content'},
            {data: 'note_type', name: 'note_type'},
            {data: 'status_id', name: 'status_id'},
            {data: 'users_id', name: 'users_id'},
            {data: 'applies_to_date', name: 'applies_to_date'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    });
  });

</script>
@endsection

