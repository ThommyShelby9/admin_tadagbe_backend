@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>programmes</h4>
            <a href="{{ route('programmes.create') }}" class="btn btn-primary m-2">Ajouter un programme</a>

        </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                    @include('dashboard.programmes.table')
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

<script type="text/javascript">
  $(function () {
    var table = $('#programme-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
        url:  "{{ route('programmes.index') }}",
        data: function (d) {
            d.school_id = '{{session("school_id")}}'
        }},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'school_id', name: 'school_id'},
            {data: 'date', name: 'date'},
            {data: 'courses', name: 'courses'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    });
  });

</script>
@endsection



