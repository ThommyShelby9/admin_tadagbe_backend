@extends('dashboard.base')
@section('css')
<style>
    #container {
        width: 1000px;
        margin: 20px auto;
    }
    .ck-editor__editable[role="textbox"] {
        /* Editing area */
        min-height: 200px;
    }
    .ck-content .image {
        /* Block images */
        max-width: 80%;
        margin: 20px auto;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header"><h4>Paramétrages</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                    @include('dashboard.settings.forms')
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
<script>
  function getSetting(code){
    let form= $(`#${code}`);
    $.ajax({
    type: 'GET',
    url: `/settings/${code}`,
    dataType: "json",
    success: function (res) {
         form.find("[name='value']").val(res.value).change();
    },
    error: function(err){
      $('#process_return_results_div').html('<span class="text-danger fa fa-info">Error</span>');
    }
  });
  }
getSetting('EIMCT_SUBSCRIPTION_PRICE')
getSetting('EIMCT_ACOMPTE_PRICE')
getSetting('EIMCT_EMAIL_SUBSCRIPTION')
getSetting('EIMCT_EMAIL_DOCUMENT')
getSetting('EIMCT_EMAIL_PAYMENT_REMINDER')
getSetting('EIMCT_SCHOOL_LINK')
getSetting('EIMCT_API_KEY')
getSetting('EIMCT_API_TOKEN')

getSetting('EIEGI_SUBSCRIPTION_PRICE')
getSetting('EIEGI_ACOMPTE_PRICE')
getSetting('EIEGI_EMAIL_SUBSCRIPTION')
getSetting('EIEGI_EMAIL_DOCUMENT')
getSetting('EIEGI_EMAIL_PAYMENT_REMINDER')
getSetting('EIEGI_SCHOOL_LINK')
getSetting('EIEGI_API_KEY')
getSetting('EIEGI_API_TOKEN')


getSetting('HUPEJUS_SUBSCRIPTION_PRICE')
getSetting('HUPEJUS_ACOMPTE_PRICE')
getSetting('HUPEJUS_EMAIL_SUBSCRIPTION')
getSetting('HUPEJUS_EMAIL_DOCUMENT')
getSetting('HUPEJUS_EMAIL_PAYMENT_REMINDER')
getSetting('HUPEJUS_SCHOOL_LINK')
getSetting('HUPEJUS_API_KEY')
getSetting('HUPEJUS_API_TOKEN')

</script>
@endsection




