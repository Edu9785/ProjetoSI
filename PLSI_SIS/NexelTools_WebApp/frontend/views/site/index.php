    <?php

    /** @var yii\web\View $this */

    use common\models\Produto;
    use yii\helpers\Html;
    use yii\helpers\Url;

    $this->title = 'Página Principal';
    ?>
    <div class="container-fluid mb-3">
        <div class="row px-xl-5"">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="<?= Yii::getAlias('@web') ?>/img/carousel-1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Ferramentas Manuais</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">A precisão está nas suas mãos</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="<?= Url::to(['produto/index', 'id_categoria' => 20]) ?>">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="<?= Yii::getAlias('@web') ?>/img/carousel-2.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Ferramentas Elétricas</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Potência e eficiência para o seu trabalho</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="<?= Url::to(['produto/index', 'id_categoria' => 18]) ?>">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="<?= Yii::getAlias('@web') ?>/img/carousel-3.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Ferramentas de medição</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Medir é a chave para a perfeição</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="<?= Url::to(['produto/index', 'id_categoria' => 21]) ?>">Comprar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="<?= Yii::getAlias('@web') ?>/img/offer-1.jpg" alt="">
                    <div class="offer-text">
                        <h3 class="text-white mb-3">Ferramentas certas</h3>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="<?= Yii::getAlias('@web') ?>/img/offer-2.jpg" alt="">
                    <div class="offer-text">
                        <h3 class="text-white mb-3">Trabalho perfeito</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Categorias</span>
        </h2>
        <div class="row px-xl-5 pb-3">
            <?php foreach ($categorias as $categoria): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="<?= Url::to(['produto/index', 'id_categoria' => $categoria->id]) ?>">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 140px; height: 100px;">
                                <img src="<?= Yii::getAlias('@uploadsUrl/') . basename($categoria->imagem->imagens) ?>"
                                     alt="<?= Html::encode($categoria->tipo) ?>"
                                     class="img-fluid categoria-img">
                            </div>

                            <div class="flex-fill pl-3">
                                <h6><?= Html::encode($categoria->tipo) ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Produtos Recentes</span></h2>
        <div class="row px-xl-5">
            <?php foreach ($produtos as $produto): ?>
            <?php if($produto->estado == Produto::DISPONIVEL): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="<?= $imagemUrls[$produto->id] ?>" alt="" style="width: 100%; height: 200px; object-fit: cover">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['carrinhocompra/create', 'id_produto' => $produto->id]) ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['favorito/create', 'id_produto' => $produto->id]) ?>"><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['produto/view', 'id' => $produto->id]) ?>"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href=""><?= Html::encode($produto->nome) ?></a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5><?= Html::encode($produto->preco . '€') ?></h5>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Products End -->


