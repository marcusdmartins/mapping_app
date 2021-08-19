<?php

  require_once 'classes/message-controller.php';

  $message = new Message_controller();

  if(!empty($_SESSION['message'])){

      $dados_message = $message->busca($_SESSION['message']);

   ?>

<script>
            swal({
                title: "<?php echo $dados_message->descricao ?>",
                text: "",
                type: "<?php echo $dados_message->tipo; ?>"
            });
</script>

    <?php

     $_SESSION['message'] = '';

  }
