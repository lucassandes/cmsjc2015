﻿<?phpinclude_once("../library/master-page.php");$oMasterPage = new MasterPage();$oMasterPage->Init("../master.php", "Cadastrar Fiscaliza São José");$oMasterPage->AddParameter("css", "fiscaliza-sao-jose/index");$oMasterPage->AddParameter("pagina", "fiscaliza-sao-jose");$oMasterPage->Open("PageContent");include_once("connect.php");include_once("functions.php");?><?phpif (isset($_FILES['fileUpload'])) {    require 'wideimage/lib/WideImage/WideImage.php'; //Inclui classe WideImage à página    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão    $name = $_FILES['fileUpload']['name']; //Atribui uma array com os nomes dos arquivos à variável    $tmp_name = $_FILES['fileUpload']['tmp_name']; //Atribui uma array com os nomes temporários dos arquivos à variável    $allowedExts = array(".gif", ".jpeg", ".jpg", ".png", ".bmp"); //Extensões permitidas    $dir = 'uploads/';    //$ext = strtolower(substr($_FILES['fileUpload']['name'],-4)); //Pegando extensão do arquivo    //$new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo    //$dir = 'uploads/'; //Diretório para uploads    for ($i = 0; $i < count($tmp_name); $i++) //passa por todos os arquivos    {        $ext = strtolower(substr($name[$i], -4));        if (in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas        {            $new_name = date("Y.m.d-H.i.s") . "-" . $i . $ext;            $image = WideImage::load($tmp_name[$i]); //Carrega a imagem utilizando a WideImage            //list($width, $height) = getimagesize($image);            $width = $image->getWidth();            $height = $image->getHeight();            echo $width;            echo "- ";            echo $height;            if ($width > $height) {                $orientation = "Landscape";                $image = $image->resize(960, 640, 'outside'); //Redimensiona a imagem para 170 de largura e 180 de altura, mantendo sua proporção no máximo possível                $image = $image->crop('center', 'center', 960, 640); //Corta a imagem do centro, forçando sua altura e largura            } elseif ($width < $height) {                $image = $image->resize(640, 960, 'outside'); //Redimensiona a imagem para 170 de largura e 180 de altura, mantendo sua proporção no máximo possível                $image = $image->crop('center', 'center', 640, 960);            } else {                $orientation = "square";                $image = $image->resize(960, 960, 'outside'); //Redimensiona a imagem para 170 de largura e 180 de altura, mantendo sua proporção no máximo possível                $image = $image->crop('center', 'center', 960, 960);            }            $image->saveToFile($dir . $new_name); //Salva a imagem            $nomes_img[] = $new_name;        }    }    move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir . $new_name); //Fazer upload do arquivo}$tipoPessoa = $_POST['tipoPessoa'];$nomePessoal = $_POST['nomePessoal'];$cpf = $_POST['cpf'];$razaoSocial = $_POST['razaoSocial'];$nomeFantasia = $_POST['nomeFantasia'];$nomeContato = $_POST['nomeContato'];$cnpj = $_POST['cnpj'];$inscEstadual = $_POST['inscEstadual'];$tipoLogradouro = $_POST['tipoLogradouro'];$logradouro = $_POST['logradouro'];$numero = $_POST['numero'];$complemento = $_POST['complemento'];$bairro = $_POST['bairro'];$estado = $_POST['estado'];$cidade = $_POST['cidade'];$cep = $_POST['cep'];$assunto = $_POST['assunto'];$descricao = $_POST['descricao'];$tipoLogradouro2 = $_POST['tipoLogradouro2'];$logradouro2 = $_POST['logradouro2'];$numero2 = $_POST['numero2'];$complemento2 = $_POST['complemento2'];$bairro2 = $_POST['bairro2'];$estado2 = $_POST['estado2'];$cidade2 = $_POST['cidade2'];$cep2 = $_POST['cep2'];$telResidencial = $_POST['telResidencial'];$telCelular = $_POST['telCelular'];$telComercial = $_POST['telComercial'];$email = $_POST['email'];?>    <h1>Fiscaliza São José</h1><?php/*$tipoPessoa;$nomePessoal ;$cpf;$razaoSocial;$nomeFantasia;$nomeContato;$cnpj;$inscEstadual;$tipoLogradouro;$logradouro;$numero;$complemento;$bairro ;$estado;$cidade;$cep;$assunto;$descricao;$tipoLogradouro2;$logradouro2;$numero2;$complemento2;$bairro2;$estado2;$cidade2;$cep2;$telResidencial;$telCelular;$telComercial;$email;*//*echo $tipoPessoa;echo $nomePessoal;echo $cpf;echo $razaoSocial;echo $nomeFantasia;echo $nomeContato;echo $cnpj;echo $inscEstadual;echo $tipoLogradouro;echo $logradouro;echo $numero;echo $complemento;echo $bairro;echo $estado;echo $cidade;echo $cep;echo $assunto;echo $descricao;echo $tipoLogradouro2;echo $logradouro2;echo $numero2;echo $complemento2;echo $bairro2;echo $estado2;echo $cidade2;echo $cep2;echo $telResidencial;echo $telCelular;echo $telComercial;echo $email;*//*$sql = "INSERT INTO MyGuests (firstname, lastname, email)    VALUES ('John', 'Doe', 'john@example.com')";if (mysqli_query($conn, $sql)) {    echo "New record created successfully";} else {    echo "Error: " . $sql . "<br>" . mysqli_error($conn);}*/$sql_solicitante = "INSERT INTO Solicitante VALUES('','$nomePessoal',$tipoPessoa,'$cpf','$cnpj','$inscEstadual','$nomeContato','$tipoLogradouro $logradouro, $numero','$complemento','$bairro','$cidade','$estado','$cep','$telResidencial','$telCelular','$telComercial','$email');";$last_id_query = "SELECT id FROM Solicitacao ORDER BY id DESC LIMIT 1";$result = $conn->query($last_id_query);if ($result->num_rows > 0) {    while ($row = $result->fetch_assoc()) {        $last_id = $row["id"];    }} else {    $last_id = 1;}$protocolo = date("Y") . date("m");$protocolo .= '-' . $last_id;//echo $protocolo;$sql_solicitacao = "INSERT INTO Solicitacao VALUES ('','$protocolo',(SELECT id FROM Solicitante ORDER BY id DESC LIMIT 1), /*LUCAS SANDES*/'$assunto','$descricao','$tipoLogradouro2 $logradouro2, $numero2','$complemento2','$bairro2','$cidade2','$estado2','$cep2');";$sql_log = "INSERT INTO historico_solicitacao VALUES ('',NOW(),'Criação da Solicitação via Internet','Solicitação Registrada',(SELECT id FROM Solicitacao ORDER BY id DESC LIMIT 1));";$mensagem = '    <h4 style="font-family: Arial, Helvetica, sans-serif;"><strong>Mensagem enviada do site CMSJC</strong></h4>        <p style="font-family: Arial, Helvetica, sans-serif;">            Olá, ' . $nomePessoal . $nomeContato . ', recebemos sua solicitação com sucesso. Abaixo há um pequeno resumo:        </p>        <p style="font-family: Arial, Helvetica, sans-serif;">            <strong>Nome: </strong>' . $nomePessoal . $nomeContato . '<br/>            <strong>Protocolo: </strong>' . $protocolo . '<br/>         </p>         <p style="font-family: Arial, Helvetica, sans-serif;">            <strong>Assunto: </strong>' . $assunto . '<br/>            <strong>Descrição: </strong>' . $descricao . '<br/>         </p>          <p style="font-family: Arial, Helvetica, sans-serif;">            Para acompanhar sua solicitação,  <a href="http://camarasjc2.hospedagemdesites.ws/2015/fiscaliza-sao-jose/acompanhamento.php"> clique aqui </a>            e forneça seu email e protocolo.          </p>';if (mysqli_query($conn, $sql_solicitante)) {    if (mysqli_query($conn, $sql_solicitacao)) {        if (mysqli_query($conn, $sql_log) && mandar_email($nomePessoal, $email, $mensagem, 'Criação da Solicitação - CMSJC')) {            //imagens            if (isset($_FILES['fileUpload'])) {                for ($i = 0; $i < count($tmp_name); $i++) //passa por todos os arquivos                {                    $sql_imagens = "INSERT INTO imagens VALUES (                    '',                    '$nomes_img[$i]',                    (SELECT id FROM Solicitacao ORDER BY id DESC LIMIT 1)                    );                    ";                    mysqli_query($conn, $sql_imagens);                }            }            ?>            <div class="alert alert-success" role="alert">                <h4>Solicitação enviada com sucesso!</h4>                <p> Sua solicitação foi enviada e registrada com sucesso. Te enviamos um e-mail com a confirmação.</p>                <p>Caso não tenha recebido, por favor espere cinco minutos ou confira na sua caixa de spam.</p>                <p>O seu protocolo de atendimento é <strong><?php echo $protocolo; ?></strong>. Utilize esse protocolo                    com seu email                    para                    acompanhar o desenvolvimento da solicitação.</p>            </div>        <?php        } else {            echo ' <div class="alert alert-danger" role="alert">                    <h4>Houve um erro...</h4>                    <p>Infelizmente houve um erro na hora de registrar sua solicitação. Por favor, tente novamente mais tarde.</p>                    <p>Mensagem técnica: ' . mysqli_error($conn) . '</p>                </div>                ';        }    } else {        echo ' <div class="alert alert-danger" role="alert">                    <h4>Houve um erro...</h4>                    <p>Infelizmente houve um erro na hora de registrar sua solicitação. Por favor, tente novamente mais tarde.</p>                    <p>Mensagem técnica: ' . mysqli_error($conn) . '</p>                </div>                ';    }} else {    echo ' <div class="alert alert-danger" role="alert">                    <h4>Houve um erro...</h4>                    <p>Infelizmente houve um erro na hora de registrar sua solicitação. Por favor, tente novamente mais tarde.</p>                    <p>Mensagem técnica: ' . mysqli_error($conn) . '</p>                </div>                ';}?><?phpinclude_once("connect_close.php");$oMasterPage->Close("PageContent");$oMasterPage->End();?>