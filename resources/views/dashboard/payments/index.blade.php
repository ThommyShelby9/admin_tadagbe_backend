@extends('dashboard.base')

@section('css')

@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header"><h4>Payements</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                    @include('dashboard.payments.table')
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
    var table = $('#payment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url:  "{{ route('payments.index') }}",
        data: function (d) {
            console.log("REF",d,d.reference_code);

            let ref=d.reference&&d.reference.includes('{{session("school_id")}}')?d.reference:"";
            d.reference=ref//includes('{{session("school_id")}}')
        }},
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'payer_type', name: 'payer_type'},
            {data: 'amount', name: 'amount'},
            {data: 'status', name: 'status'},
            {data: 'reference', name: 'reference'},
            {data: 'reference_code', name: 'reference_code'},
            {data: 'description', name: 'description'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ]
    });
  });

</script>
@endsection



