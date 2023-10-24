<?php
    $data['title'] = "Agendas";
    $data['link_css'] = "";
?>

<?= view("include/head", $data) ?>
    <?= view("include/nav") ?>

    <main class="container my-5">
        <h1><?= $data['title'] ?></h1>

        <!-- FAZER FILTROS -->

        <!-- row -->
        <div class="row">
            <?php foreach($agendas as $a):  ?>
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 my-2">
                    <div class="card h-100">
                        <img src="<?= base_url('assets/img/teste/'. $a['IMAGEM']) ?>" class="bd-placeholder-img card-img-top" width="100%" height="100%">
                        <div class="card-body card-products">
                            <h3><?php echo $a['NOME']; ?></h3>
                            <p class="card-text">
                                Por:
                                <br><span><b><?php echo number_format($a['PRECO'], 2, '.', ''); ?></b></span>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a class="btn input-simples w-100" style="margin-right: 8px" href="<?= base_url('produto/'.$a['CATEGORIA'].'/'.$a['SLUG'].'/'. $a['ID']) ?>">SAIBA MAIS</a>
                                <a href=""><img src="<?= base_url('assets/img/shopping-cart.png') ?>" alt="" style="width:36px; height: 36px"></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <!-- ../row -->
    </main>

    <?= view("include/footer") ?>
<?= view("include/scripts") ?>