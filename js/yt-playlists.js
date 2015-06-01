$(document).ready(function () {
    toggleFields();
    $( "#reportagens-btn" ).click(function() {
        toggleFields();
    });

    $( "#com-a-palavra-btn" ).click(function() {
        toggleFields();
    });

    $( "#sessao-btn" ).click(function() {
        toggleFields();
    });
});

function toggleFields() {
    $( "#reportagens-btn" ).click(function() {
        $( "#feed-playlist" ).html( "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/videoseries?list=PLey9M_cWIxnnX1wHd4xM7UoB08mgmFgqI\" frameborder=\"0\" allowfullscreen></iframe>" );
        $("#titulo-playlist").html("Notícias da Câmara");
        $("#desc-playlist").html("Tudo o que acontece de importante em São José dos Campos, sob o olhar da Câmara Municipal. As reportagens produzidas pela TV Câmara tem o objetivo de prestar contas dos atos do Legislativo, além de informar o cidadão sobre temas importantes da vida da Cidade.");
    });

    $( "#sessao-btn" ).click(function() {
        $( "#feed-playlist" ).html( "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/videoseries?list=PLey9M_cWIxnk9ulpdng_s9q9vWu16VCco\" frameborder=\"0\" allowfullscreen></iframe>" );
        $("#titulo-playlist").html("Direto do Plenário");
        $("#desc-playlist").html("Toda a atividade legislativa, votações e reconhecimento aos cidadãos de São José que acontecem n Câmara Municipal são destaque nas transmissões ao vivo da TV Câmara. Acompanhe as últimas votações e homenagens.");

    });

    $( "#com-a-palavra-btn" ).click(function() {
        $( "#feed-playlist" ).html( "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/videoseries?list=PLey9M_cWIxnl4QppWqPmUITXzH_ECajoG\" frameborder=\"0\" allowfullscreen></iframe>" );
        $("#titulo-playlist").html("Com a Palavra");
        $("#desc-playlist").html("Trazendo convidados com temas de interesse da cidade, o programa “Com a Palavra” é exibido sempre às quintas-feiras. Você pode rever as entrevistas e os assuntos também pelo nosso canal no Youtube.");

    });
}
