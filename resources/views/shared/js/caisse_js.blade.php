<?php
          use App\Utils\Utils;
          $session_status=0;
          $caisse_session=Utils::get_session();
          if($caisse_session){
            $session_status=$caisse_session->status;
          }
      ?>  
<script>
function promptNewCaisseSessionDialog(){
  let modal =$("#openCaisseModal");
  modal.modal({backdrop: 'static', keyboard: false}) ;
  modal.modal("show");
         modal.find("#btn_open_caisse").on("click",function(){
          let data=modal.find('form#openCaisseForm').serialize();
          $.ajax({
            url:"/caisses/open",
            method:"POST",
            data:data,
            success:function(res){
              window.location.reload(true);
            },
            error:function(err){
            }
          })
         });
}
function promptPendingCaisseSessionDialog(){
  let modal =$("#openCaisseModal");
  modal.modal({backdrop: 'static', keyboard: false}) ;
  modal.find("#validation_message").text("Votre demande est en attente de validation, veuillez patientez encore SVP");
            modal.modal("show");
            modal.find("#openCaisseForm").hide();
            modal.find("#btn_open_caisse").text("OK");
            modal.find("#btn_open_caisse").on("click", function(){
              window.location.href="/";
            });
}

function openCaisse(){
    let session_caisse=@json($caisse_session);
    console.log("openCaisse",session_caisse);
    if(session_caisse){
      if(session_caisse.status===0){
        promptPendingCaisseSessionDialog()
      }else if(session_caisse.status!=1){
        promptNewCaisseSessionDialog()  
      }
    }else{
      promptNewCaisseSessionDialog()
    }
  }
  openCaisse();
  
  </script>