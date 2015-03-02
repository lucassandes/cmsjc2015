<?php

if ($oPaginator && $oPaginator->TotalPages > 1) {
    $oPaginator->Anchor = ((!$oPaginator->Anchor) ? "paginator" : $oPaginator->Anchor);
    $oPaginator->IsTotal = false;
    $oPaginator->IsPager = true;
    $oPaginator->IsFisrt = false;
    $oPaginator->IsPrev = false;
    $oPaginator->IsNext = false;
    $oPaginator->IsLast = false;
    $oPaginator->TextPagerSeparator = "  ";
    $oPaginator->ClassPager = "numeros";
    $oPaginator->ForceFormat = true;
    $oPaginator->LimitPageNumber = 7;
    $oPaginator->Create();
    ?>
    <div class="text-center">
        <nav>
            <ul class="pagination">
                <?php if ($oPaginator->CheckPrevPage()) { ?>
                    <li><a href="<?= $oPaginator->GenerateLinkPrevPage(); ?>" class="botAnt">&laquo</a></li><?php } ?>

                <li><?= $oPaginator->Result; ?></li>
                <?php if ($oPaginator->CheckNextPage()) { ?>
                    <li><a href="<?= $oPaginator->GenerateLinkNextPage(); ?>" class="botAnt">&raquo;</a></li><?php } ?>


            </ul>
        </nav>
    </div>
    <?php /*
	<div class="paginacao">

	    <?php if($oPaginator->CheckPrevPage()) { ?><a href="<?=$oPaginator->GenerateLinkPrevPage();?>" class="botAnt"><img src="imgs/geral/navegacao/bot-seta-anterior.png" alt="Anterior" title="Anterior" /></a><?php } ?>
	    <?php if($oPaginator->CheckNextPage()) { ?><a href="<?=$oPaginator->GenerateLinkNextPage();?>" class="botProx"><img src="imgs/geral/navegacao/bot-seta-proximo.png" alt="Pr�ximo" title="Pr�ximo" /></a><?php } ?>
	    <?=$oPaginator->Result;?>
	</div>*/
    ?>
<?php
}

?>