@extends('dashboard.base')

@section('css')
@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header"><h4>Admissions</h4>
                <a href="/admission/exports" class="btn btn-info  float-right m-1">Exporter</a>
        </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                    @include('dashboard.admissions.table')
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

    var table = $('#admission-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url:  "{{ route('admissions.index') }}",
        data: function (d) {
            d.school_id = '{{session("school_id")}}';
        }
    },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {data: 'school_id', name: 'school_id'},
            {data: 'paiement_mode', name: 'paiement_mode'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    });
  });

</script>
@endsection



