<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $addTarefa = $auth->createPermission('addTarefa');
        $addTarefa->description = 'Adicionar tarefa';
        $auth->add($addTarefa);

        $editTarefa = $auth->createPermission('editTarefa');
        $editTarefa->description = 'Editar tarefa';
        $auth->add($editTarefa);

        $deleteTarefa = $auth->createPermission('deleteTarefa');
        $deleteTarefa->description = 'Apagar tarefa';
        $auth->add($deleteTarefa);

        $addToCart = $auth->createPermission('addToCart');
        $addToCart->description = 'Adicionar produtos ao carrinho';
        $auth->add($addToCart);

        $editCart = $auth->createPermission('editCart');
        $editCart->description = 'Editar carrinho';
        $auth->add($editCart);

        $removeFromCart = $auth->createPermission('removeFromCart');
        $removeFromCart->description = 'Remover produtos do carrinho';
        $auth->add($removeFromCart);

        $leaveReview = $auth->createPermission('leaveReview');
        $leaveReview->description = 'Deixar comentários e avaliações';
        $auth->add($leaveReview);

        $editReview = $auth->createPermission('editReview');
        $editReview->description = 'Editar comentários e avaliações';
        $auth->add($editReview);

        $deleteReview = $auth->createPermission('deleteReview');
        $deleteReview->description = 'Eliminar comentários e avaliações';
        $auth->add($deleteReview);

        $editProfile = $auth->createPermission('editProfile');
        $editProfile->description = 'Alterar dados do perfil';
        $auth->add($editProfile);

        $viewProductDetails = $auth->createPermission('viewProductDetails');
        $viewProductDetails->description = 'Visualizar detalhes dos produtos';
        $auth->add($viewProductDetails);

        $checkout = $auth->createPermission('checkout');
        $checkout->description = 'Efetuar a compra de produtos com diferentes métodos de pagamento';
        $auth->add($checkout);

        $addFavorites = $auth->createPermission('addFavorites');
        $addFavorites->description = 'Adicionar produto a lista de favoritos';
        $auth->add($addFavorites);

        $deleteFavorites = $auth->createPermission('deleteFavorites');
        $deleteFavorites->description = 'Remover produtos da lista de favoritos';
        $auth->add($deleteFavorites);

        $viewPurchaseHistory = $auth->createPermission('viewPurchaseHistory');
        $viewPurchaseHistory->description = 'Visualizar histórico de compras';
        $auth->add($viewPurchaseHistory);

        $viewSalesHistory = $auth->createPermission('viewSalesHistory');
        $viewSalesHistory->description = 'Visualizar histórico de vendas';
        $auth->add($viewSalesHistory);

        $editUsers = $auth->createPermission('editUsers');
        $editUsers->description = 'Editar utilizadores';
        $auth->add($editUsers);

        $deleteUsers = $auth->createPermission('deleteUsers');
        $deleteUsers->description = 'Remover utilizadores';
        $auth->add($deleteUsers);

        $assignRoles = $auth->createPermission('assignRoles');
        $assignRoles->description = 'Atribuir níveis de acesso com base no papel';
        $auth->add($assignRoles);

        $editCatalog = $auth->createPermission('editCatalog');
        $editCatalog->description = 'Editar  produtos do catálogo';
        $auth->add($editCatalog);

        $removeCatalog = $auth->createPermission('removeCatalog');
        $removeCatalog->description = 'Remover produtos do catálogo';
        $auth->add($removeCatalog);

        $addShippingMethods = $auth->createPermission('addShippingMethods');
        $addShippingMethods->description = 'Adicionar métodos de expedição';
        $auth->add($addShippingMethods);

        $editShippingMethods = $auth->createPermission('editShippingMethods');
        $editShippingMethods->description = 'Editar métodos de expedição';
        $auth->add($editShippingMethods);

        $deleteShippingMethods = $auth->createPermission('deleteShippingMethods');
        $deleteShippingMethods->description = 'Remover métodos de expedição';
        $auth->add($deleteShippingMethods);

        $addCategories = $auth->createPermission('addCategories');
        $addCategories->description = 'Adicionar categorias de ferramentas';
        $auth->add($addCategories);

        $editCategories = $auth->createPermission('editCategories');
        $editCategories->description = 'Editar categorias de ferramentas';
        $auth->add($editCategories);

        $deleteCategories = $auth->createPermission('deleteCategories');
        $deleteCategories->description = 'Remover categorias de ferramentas';
        $auth->add($deleteCategories);

        $createSales = $auth->createPermission('createSales');
        $createSales->description = 'Criar vendas';
        $auth->add($createSales);

        $editSales = $auth->createPermission('editSales');
        $editSales->description = 'Editar vendas';
        $auth->add($editSales);

        $deleteSales = $auth->createPermission('deleteSales');
        $deleteSales->description = 'Eliminar vendas';
        $auth->add($deleteSales);

        $addProductDetails = $auth->createPermission('addProductDetails');
        $addProductDetails->description = 'Inserir detalhes do produto';
        $auth->add($addProductDetails);

        $editProductDetails = $auth->createPermission('editProductDetails');
        $editProductDetails->description = 'Editar detalhes do produto';
        $auth->add($editProductDetails);

        $removeProductDetails = $auth->createPermission('removeProductDetails');
        $removeProductDetails->description = 'Remover detalhes do produto';
        $auth->add($removeProductDetails);

        $addUser = $auth->createPermission('addUser');
        $addUser->description = 'Adicionar utilizadores';
        $auth->add($addUser);

        $accessBackOffice = $auth->createPermission('accessBackOffice');
        $accessBackOffice->description = 'Acessar Backoffice';
        $auth->add($accessBackOffice);



        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $editReview);
        $auth->addChild($admin, $deleteReview);
        $auth->addChild($admin, $editProfile);
        $auth->addChild($admin, $viewProductDetails);
        $auth->addChild($admin, $addUser);
        $auth->addChild($admin, $editUsers);
        $auth->addChild($admin, $deleteUsers);
        $auth->addChild($admin, $assignRoles);
        $auth->addChild($admin, $editCatalog);
        $auth->addChild($admin, $removeCatalog);
        $auth->addChild($admin, $addShippingMethods);
        $auth->addChild($admin, $editShippingMethods);
        $auth->addChild($admin, $deleteShippingMethods);
        $auth->addChild($admin, $addCategories);
        $auth->addChild($admin, $editCategories);
        $auth->addChild($admin, $deleteCategories);
        $auth->addChild($admin, $editSales);
        $auth->addChild($admin, $deleteSales);
        $auth->addChild($admin, $editProductDetails);
        $auth->addChild($admin, $accessBackOffice);
        $auth->addChild($admin, $removeProductDetails);
        $auth->addChild($admin, $addTarefa);
        $auth->addChild($admin, $editTarefa);
        $auth->addChild($admin, $deleteTarefa);

        $utilizador = $auth->createRole('utilizador');
        $auth->add($utilizador);
        $auth->addChild($utilizador, $addToCart);
        $auth->addChild($utilizador, $editCart);
        $auth->addChild($utilizador, $removeFromCart);
        $auth->addChild($utilizador, $leaveReview);
        $auth->addChild($utilizador, $editReview);
        $auth->addChild($utilizador, $deleteReview);
        $auth->addChild($utilizador, $editProfile);
        $auth->addChild($utilizador, $viewProductDetails);
        $auth->addChild($utilizador, $checkout);
        $auth->addChild($utilizador, $addFavorites);
        $auth->addChild($utilizador, $deleteFavorites);
        $auth->addChild($utilizador, $viewPurchaseHistory);
        $auth->addChild($utilizador, $viewSalesHistory);
        $auth->addChild($utilizador, $createSales);
        $auth->addChild($utilizador, $editSales);
        $auth->addChild($utilizador, $deleteSales);
        $auth->addChild($utilizador, $addProductDetails);
        $auth->addChild($admin, $editTarefa);

        $auth->assign($admin, 1);
    }


}
