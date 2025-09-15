@extends('dashboard.base')
@section('title')
  <label class="m-3 h4 text-center" for="">Payement</label>
@endsection
@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="row justify-content-center">

              <div class="card col-md-6 col-sm-12">


                    <div class="card-header">Payement</div>

                    <div class="card-body">
                      <div class="form-horizontal"  id="payment_form">
                        <p>Montant:<span class="h2 badge-lg badge badge-info">{{$admission->payment->amount}}</span></p>
                      <kkiapay-widget
                          amount="{{$admission->payment->amount}}"
                          key="40a02d8aec90a1a34b93d32249905aec52a99545"
                          position="center"
                          paymentmethod="card"
                          sandbox="false"
                          data="{{$admission}}"
                          callback="https://admin.inter-nat.com/payments/completed/{{$payment->id}}">
                      </kkiapay-widget>
                     </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')


<script src="https://cdn.kkiapay.me/k.js">
  let payment= @json($payment);
    addSuccessListener(response => {
        console.log("response",response);
        $.ajax({
        type: 'POST',
        data:{payment:payment,transaction:response}
        url: `/payments/update/${payment.id}`,
        success: function (res) {
          console.log("response",res)
        },
        error: function(err){
          console.log("err",err)

        }
      });
    });
   addFailedListener(error => {
        console.log("response",error);
        $.ajax({
        type: 'POST',
        data:{payment:payment,transaction:response}
        url: `/payments/update/${payment.id}`,
        success: function (res) {
        },
        error: function(err){
        }
      });
    });

</script>

@endsection
