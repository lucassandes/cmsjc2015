<?php
//if(!isset($_POST[Submit])) die("N&atilde;o recebi nenhum par&acitc;metro. Por favor volte ao formulario.html antes");
/* Medida preventiva para evitar que outros domínios sejam remetente da sua mensagem. */
if (eregi('tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER[HTTP_HOST])) {
    $emailsender='contato@camarasjc2.hospedagemdesites.ws';
} else {
    $emailsender = "contato@" . $_SERVER[HTTP_HOST];
    //    Na linha acima estamos forçando que o remetente seja 'webmaster@seudominio',
    // você pode alterar para que o remetente seja, por exemplo, 'contato@seudominio'.
}

/* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");



$name = $_POST['name'];
$emailremetente = trim($_POST['email']);
$entidade = $_POST['entidade'];
$telefone = $_POST['telefone'];
$data_visita = $_POST['data_visita'];
$horario = $_POST['horario'];
$comcopia ='abel.taira@camarasjc.sp.gov.br';
$emaildestinatario ='amanda.leite@camarasjc.sp.gov.br';

$mensagemHTML = '

        <h4><strong>Visita a Camara </strong></h4>
        <p>
            <strong>Nome: </strong>' . $name . '<br/>
            <strong>Entidade: </strong> ' . $entidade . '<br/>
            <strong>Email: </strong> ' . $email . '<br/>

            <strong>Telefone: </strong>' . $telefone . '<br/>
            <strong>Data da Visita: </strong>' . $data_visita . '<br/>
            <strong>Horário da Visita: </strong>' . $horario . '<br/>

         </p>

';


$dadosHTML = '

        <p>
            <strong>Nome: </strong>' . $name . '<br/>
            <strong>Entidade: </strong> ' . $entidade . '<br/>
            <strong>Email: </strong> ' . $email . '<br/>

            <strong>Telefone: </strong>' . $telefone . '<br/>
            <strong>Data da Visita: </strong>' . $data_visita . '<br/>
            <strong>Horário da Visita: </strong>' . $horario . '<br/>

         </p>

';


/* Montando o cabeçalho da mensagem */
$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=UTF-8".$quebra_linha;
// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
$headers .= "From: Visitando a Camara <".$emailsender.">".$quebra_linha;
$headers .= "Return-Path: " . $emailsender . $quebra_linha;
// Esses dois "if's" abaixo são porque o Postfix obriga que se um cabeçalho for especificado, deverá haver um valor.
// Se não houver um valor, o item não deverá ser especificado.
$headers .= "Cc: ".$comcopia.$quebra_linha;

$headers .= "Reply-To: ".$emailremetente.$quebra_linha;
// Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)





?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Agende sua visita à Câmara Municipal de São José dos Campos.">
    <meta name="author" content="CMSJC">
    <title>Visitando a Câmara &bull; Agende sua visita</title>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">
</head>
<body>
<div class="fotos"></div>
<div class="titulo">
    <a href="index.php"><h1 class="text-center "><span class="hidden-xs">&#8226; &#8226; &#8226; &#8226;</span> Visitando a
        Câmara <span class="hidden-xs">&#8226; &#8226; &#8226; &#8226;</span></h1></a>
</div>
<div class="container">
    <div class="col-md-6 col-md-offset-3">


        <?php
        /* Enviando a mensagem */
        //É obrigatório o uso do parâmetro -r (concatenação do "From na linha de envio"), aqui na Locaweb:
        if (/* Enviando a mensagem */
        mail($emaildestinatario, $assunto, $mensagemHTML, $headers, "-r". $emailsender)) {
        ?>


        <!--if (@mail($recipient, $subject, $message, $headers)){ ?> -->

            <div class="alert alert-success">
                <h4><strong>Mensagem enviada!</strong></h4>
                <p>Aguarde a confirmação do agendamento por email.<br/></p>
                <h3><strong>Dados enviados:</strong></h3>
                <p><?php  echo $dadosHTML; ?></p>
            </div>

        <?php
        } else {
            echo '<div class="alert alert-danger">
                    <h4>Ops, ocorreu um erro!</h4>
                    <p>Desculpe, ocorreu ao tentar enviar sua mensagem. Por favor tente novamente mais tarde.</p>
                  </div>';
        }
        ?>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.mask.js"></script>


</body>
</html>