<!DOCTYPE html><html lang="en"><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1">    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->    <title>Bootstrap 101 Template</title>    <!-- Bootstrap -->    <link href="css/bootstrap.min.css" rel="stylesheet">    <link href="css/starter-template.css" rel="stylesheet">    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->    <!--[if lt IE 9]>    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>    <![endif]--></head><body><nav class="navbar navbar-inverse navbar-fixed-top">    <div class="container">        <div class="navbar-header">            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"                    aria-expanded="false" aria-controls="navbar">                <span class="sr-only">Toggle navigation</span>                <span class="icon-bar"></span>                <span class="icon-bar"></span>                <span class="icon-bar"></span>            </button>            <a class="navbar-brand" href="index.php">Adm Solicitações</a>        </div>        <div id="navbar" class="collapse navbar-collapse">            <ul class="nav navbar-nav">                <li class="active"><a href="#">Solicitações em aberto</a></li>                <li><a href="#about">Solicitações Conluidas</a></li>                <!--<li><a href="#contact">Contact</a></li>-->            </ul>        </div>        <!--/.nav-collapse -->    </div></nav><div class="container"><?phpinclude_once("../connect.php");include_once("../functions.php");$id_solicitacao = $_GET["id_solicitacao"];if (!empty($_POST)) {    echo('teste');    $status = $_POST['status'];    $encaminhamento = $_POST['encaminhamento'];    $outros = $_POST['outros'];    $novo_status = "{$status} {$encaminhamento} {$outros}";    $descricao = $_POST['descricao'];    $sql = "INSERT INTO historico_solicitacao    VALUES ('', NOW(), '$descricao', '$novo_status', '$id_solicitacao')";    $mensagem = '    <h4><strong>Mensagem enviada do site CMSJC</strong></h4>        <p>            <strong>Nome: </strong>' . $name . '<br/>            <strong>Protocolo: </strong><br/>' . $protocolo . '<br/>         </p>';    if (mysqli_query($conn, $sql) && mandar_email($nomePessoal, $email, $mensagem, 'Criação da Solicitação - CMSJC') ) {        ?>        <div class="alert alert-success alert-dismissible" role="alert">            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span                    aria-hidden="true">&times;</span></button>            <strong>Sucesso!</strong> A solicitação foi atualizada com sucesso!        </div>    <?php    } else {        ?>        <div class="alert alert-success alert-dismissible" role="alert">            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span                    aria-hidden="true">&times;</span></button>            <strong>Ops...</strong> Aconteceu algum erro. Favor tentar novamente mais tarde. <br/> Detalhes            técinicos: <?php echo " " . $sql . "<br>" . mysqli_error($conn); ?>        </div>    <?php    }}?><h1>Editar solicitação</h1><h3>Solicitação</h3><table class="table table-striped table-hover">    <thead>    <tr>        <th>#</th>        <th>Protocolo</th>        <th>Assunto</th>        <th>Status Atual</th>        <th>Descrição Status</th>    </tr>    </thead>    <tbody>    <?php    //$sql = "SELECT * FROM solicitacao INNER JOIN solicitante ON solicitacao.solicitante=solicitante.id INNER JOIN historico_solicitacao ON solicitacao.id = historico_solicitacao.id_solicitacao";    $sql = "SELECT * FROM solicitacao WHERE id=$id_solicitacao";    $result = $conn->query($sql);    if ($result->num_rows > 0) {    // output data of each row    while ($row = $result->fetch_assoc()) {    $solicitante = $row["solicitante"];    ?>    <tr>        <th scope="row"><?php echo $row["id"] ?></th>        <td><?php echo $row["protocolo"] ?></td>        <td><?php echo $row["assunto"] ?></td>        <?php        // PEGA STATUS        $sql_log = 'SELECT status, descricao FROM historico_solicitacao WHERE id_solicitacao = ' . $row["id"] . ' ORDER BY id DESC LIMIT 1';        $result_log = $conn->query($sql_log);        if ($result_log->num_rows > 0) {            while ($row_status = $result_log->fetch_assoc()) {                echo ' <td>' . $row_status["status"] . '</td>';                echo ' <td>' . $row_status["descricao"] . '</td>';            }        } else {            echo '<td>Erro ao carregar status</td>';        }        ?>    </tr>    </tbody></table>    <p><strong>Descrição da Solicitação:</strong><br/> <?php echo $row["descricao"] ?></p>    <p><strong>Endereço da            Solicitação:</strong><br/> <?php echo $row["endereco"] ?> <?php echo ($row["complemento"]) ? '- ' . $row["complemento"] : ""; ?>        . <?php echo $row["bairro"] ?>.        CEP: <?php echo $row["cep"] ?></p><?php}}?><hr><h3>Solicitante</h3><?php$sql_log = 'SELECT * FROM solicitante WHERE id = ' . $solicitante . '';$result_log = $conn->query($sql_log);if ($result_log->num_rows > 0) {    while ($row = $result_log->fetch_assoc()) {        if ($row["tipo"] == 0) { //pessoa física            ?>            <div class="row">                <div class="col-md-6"><p><strong>Nome:</strong> <?php echo $row["nome"]; ?> </p></div>                <div class="col-md-6"><p><strong>CPF:</strong> <?php echo $row["cpf"]; ?> </p></div>            </div>        <?php        } else {            ?>            <div class="row">                <div class="col-md-6"><p><strong>Nome do Contato:</strong> <?php echo $row["nome_contato"]; ?>                    </p></div>                <div class="col-md-3"><p><strong>CNPJ:</strong> <?php echo $row["cnpj"]; ?> </p></div>                <div class="col-md-3"><p><strong>Inscrição                            estadual:</strong> <?php echo $row["inscricao_estadual"]; ?> </p></div>            </div>        <?php        } //end else        ?>        <p><strong>Endereço:</strong><br/> <?php echo $row["endereco"] ?> <?php echo $row["bairro"] ?>. <br/>            <?php echo $row["cidade"] ?> - <?php echo $row["estado"] ?><br/>            CEP: <?php echo $row["cep"] ?></p>        <h4>Contato:</h4>        <table class="table table-striped table-hover">            <thead>            <tr>                <th>Residencial</th>                <th>Celular</th>                <th>Comercial</th>                <th>Email</th>            </tr>            </thead>            <tbody>            <tr>                <td><?php echo ($row["tel_residencial"]) ? $row["tel_residencial"] : "Não fornecido"; ?></td>                <td><?php echo ($row["celular"]) ? $row["celular"] : "Não fornecido"; ?></td>                <td><?php echo ($row["tel_comercial"]) ? $row["tel_comercial"] : "Não fornecido"; ?></td>                <td><a href="mailto:<?php echo $row["email"] ?>"><?php echo $row["email"] ?></a></td>            </tr>            </tbody>        </table>    <?php    }} else {    echo '<td>Erro ao carregar Histórico</td>';}?><div class="clearfix"></div><hr><h3>Histórico</h3><table class="table table-striped table-hover">    <thead>    <tr>        <th>Data</th>        <th>Status</th>        <th>Descrição</th>    </tr>    </thead>    <tbody>    <?php    $sql_log = 'SELECT * FROM historico_solicitacao WHERE id_solicitacao = ' . $id_solicitacao . ' ORDER BY id ';    $result_log = $conn->query($sql_log);    if ($result_log->num_rows > 0) {        while ($row_status = $result_log->fetch_assoc()) {            ?>            <tr>                <td><?php echo $row_status["time_stamp"] ?></td>                <td><?php echo $row_status["status"] ?></td>                <td><?php echo $row_status["descricao"] ?></td>            </tr>        <?php        }    } else {        echo '<td>Erro ao carregar Histórico</td>';    }    ?>    </tbody></table><div class="clearfix"></div><hr><h3>Adicionar movimentação</h3><form method="post" action="editar_solicitacao.php?id_solicitacao=<?php echo $id_solicitacao ?>">    <!--<input type="hidden" name="id_solicitacao" value="<?php echo $_GET['$id_solicitacao']; ?>" /> -->    <div class="row">        <div class="col-sm-4">            <select class="form-control" name="status" id="status">                <option>Em Análise</option>                <option>Vistoria Realizada</option>                <option>Encaminhamento para ...</option>                <option>Atendimento Encerrado</option>            </select>        </div>        <div class="col-sm-4">            <select class="form-control" name="encaminhamento" id="encaminhamento">                <option>Prefeitura Municipal SJC</option>                <option>SABESP</option>                <option>Bandeirantes</option>                <option>Urban</option>                <option>Fundhas</option>                <option>FCCR</option>                <option>Outro...</option>            </select>        </div>        <div class="col-sm-4">            <div class="form-group">                <!--  <label for="outros">Digite para onde foi encaminhado</label> -->                <input type="text" class="form-control" id="outros" name="outros"                       placeholder="Digite para onde foi encaminhado">            </div>        </div>        <div class="clearfix"></div>    </div>    <label for="descricao">Descrição / Detalhes</label>    <textarea class="form-control" rows="2" id="descricao" name="descricao"></textarea>    <br/>    <button type="submit" class="btn btn-success btn-lg pull-right"><span class="glyphicon glyphicon-floppy-disk"                                                                          aria-hidden="true"></span> Salvar    </button></form><div class="clearfix"></div><p><br/><br/><br/><br/><br/><br/></p></div><?phpinclude_once("../connect_close.php");?><!-- jQuery (necessary for Bootstrap's JavaScript plugins) --><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><!-- Include all compiled plugins (below), or include individual files as needed --><script src="js/bootstrap.min.js"></script><script>    $(document).ready(function () {        toggleFields(); //call this first so we start out with the correct visibility depending on the selected form values        //this will call our toggleFields function every time the selection value of our underAge field changes        $('#encaminhamento').hide();        $('#outros').hide();        $("#encaminhamento").change(function () {            toggleFields();        });        $("#status").change(function () {            toggleFields();        });    });    function toggleFields() {        //tipoOvo == 0 => tradicional        //        if ($("#status").val()=='Encaminhamento para ...'){            $('#encaminhamento').show();            if ($("#encaminhamento").val()=='Outro...'){                $('#outros').show();            }            else {                $('#outros').hide();            }        }        else {            $('#encaminhamento').hide();            $('#outros').hide();        }    }</script></body></html>