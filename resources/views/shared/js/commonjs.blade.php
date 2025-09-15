<script>
    $(".select2").select2({placeholder:"Sélectionner..."});
    function addNewClient(){
    $.ajax({
    type: 'GET',
    url: '/client/form',
    dataType: "html",
    success: function (res) {
        console.log(res);
        let modal =$("#addClientModal");
         modal.find("#addClientModal_body").html(res);
         modal.modal("show");
    },
    error: function(err){
      $('#process_return_results_div').html('<span class="text-danger fa fa-info">Error</span>');
    }
  });
}
</script>