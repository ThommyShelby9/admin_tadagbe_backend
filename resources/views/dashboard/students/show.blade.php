@extends('dashboard.base')

@section('title')
  <label class="m-3 h4 text-center" for="">Apprenant</label>
@endsection
@section('content')

          <div class="container-fluid">
            <div class="fade-in ">
              <div class=" row justify-content-center">
              <div class="  col">
              @if(isset($student))
              <section style="background-color: #eee;">
                <div class="">
                  <div class="row">
                    <div class="col">
                      <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                          <li class="breadcrumb-item active" aria-current="page"><a href="/students">Apprenants</a></li>
                        </ol>
                      </nav>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <div class="card mb-4">
                        <div class="card-body text-center">
                          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;">
                          <h5 class="my-3">{{$student->user->first_name}}</h5>
                          <p class="text-muted mb-1">{{$student->user->first_name}}</p>
                          <p class="text-muted mb-4">{{$student->user->last_name}}</p>
                          {{-- <div class="d-flex justify-content-center mb-2">
                            <a  href="/students/edit/{{$student->id}}" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Modifier</a>
                            <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Message</button>
                          </div> --}}
                        </div>
                      </div>

                    </div>
                    <div class="col-lg-8">
                      <div class="card mb-4">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Nom</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{$student->user->last_name}}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Prénom(s)</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{$student->user->first_name}}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Téléphone</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{$student->user->phone}}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{$student->user->email}}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Filière</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">{{$student->study_level}}</p>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-sm-3">
                              <p class="mb-0">Code</p>
                            </div>
                            <div class="col-sm-9">
                              <p class="text-muted mb-0">234-5678</p>
                            </div>
                          </div>
                          <hr>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </section>
              @endif
              </div>
            </div>
          </div>

@endsection

@section('javascript')

    <script >
      $('select').prop('disabled', true);

      console.log("test","test")
    function calculateFees(delai){
      let amount=$("#amount").val()||0;
      let processor_rate=0.04;
      let send_rate=0.02;
      let delai_contacts=0.10;
      if(delai==2)
      delai_contacts=0.15
      if(delai==3)
      delai_contacts=0.05
      console.log("delai_contacts",delai_contacts, delai)

      $("#contact_form").find("[name=service_contacts]").val(amount*delai_contacts)
      let total_rates=processor_rate+send_rate+delai_contacts;
      let total_contacts=amount*total_rates
      return Math.ceil(total_contacts);
    }
    function updateCalculation(){
      let processor_rate=0.04;

      let delai=$("#reception_delai").val()||1;
      let amount=$("#amount").val()||0;
      let contacts=calculateFees(delai);
      console.log("contacts",contacts,amount,delai)

      $("#total_contacts").text(contacts);
      let net_amount= amount-contacts
      console.log("net_amount",net_amount)

      $("#net_amount").text(net_amount);

      $("#contact_form").find("[name=net_amount]").val(net_amount)
      $("#contact_form").find("[name=total_contacts]").val(contacts)
      let processor_contacts=amount*processor_rate
      let kkiapay_amount=amount-processor_contacts
      console.log("kkiapay_amount",kkiapay_amount)
      $("#contact_form").find("[name=processor_contacts]").val(processor_contacts)
      $("#kkia_amount").attr("amount",Math.ceil(kkiapay_amount));
      $("#contact_form").find("[name=processor_amount]").val(kkiapay_amount)
    }
$("#reception_delai").change(function(e){
  updateCalculation()
})
$("#amount").on("input",function(e){
  updateCalculation()
})
</script>

<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
</script>
<script
    id="kkia_amount"
    amount="2000"
    theme="#03A9F4"
    contactmethod="card"
    key="40a02d8aec90a1a34b93d32249905aec52a99545"
    position="center"
    sandbox="false"
    data=""
    callback="<url-de-redirection-quand-le-paiement-est-reussi>">

    </script>

@endsection
