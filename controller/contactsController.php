<?php
require './model/productsLogic.php';
require './model/ShoppingCartLogic.php';

class ContactsController{

    public function __construct(){
        $this->productsLogic = new productsLogic();
        $this->cartLogic = new ShoppingCartLogic();
    }

    public function handleRequest()
    {
        $op = isset($_GET["op"]) ? $_GET["op"] : "";
        try {
            switch ($op) {
                case "create";
                    $this->collectCreateProduct();
                    break;
                case "shop";
                    $this->shopping();
                    break;
                case "paying";
                    $this->paying();
                    break;
                case "read";
                    $this->collectImage();
                    break;
                case "update";
                    $this->collectUpdateProduct();
                    break;
                case "search";
                    $this->collectSearchProducts();
                    break;
                case "delete";
                    $this->collectDeleteProduct();
                    break;
                case "allProducts" :
                    $this->collectAllProducts();
                    break;
                case "contact":
                    $this->collectContact();
                    break;
                case "admin" :
                    $this->collectAdmin();
                    break;
                case "addToCart" :
                    $this->collectAddToCart();
                    break;
                case "cart" :
                    $this->collectCart();
                    break;
                default:
                    $this->collectReadHome();
                    break;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function collectCart() {
        $products = $this->cartLogic->readCart();

        $table = $this->productsLogic->printTable($products);
//
        include "view/shopping.php";
    }

    public function collectAddToCart() {
        $this->cartLogic->addProductToCart($_REQUEST["id"], isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : 1);
        // $table = $this->productsLogic->printTable($products);     
        $this->collectCart();   
    }


    public function collectSearchProducts(){
        $search = $this->productsLogic->searchProducts($_REQUEST['w']);
        $result = $this->productsLogic->printDiv($search);


        include 'view/products.php';
    }

    public function paying(){
        $products = $this->cartLogic->readCart();

        $table = $this->productsLogic->printTable($products);
//
        include 'view/paying.php';
    }

    public function shopping()
    {
        include 'view/shopping.php';
    }
    public function collectContact(){
        include "view/contact.php";
    }
    public function collectAdmin(){
        $array = $this->productsLogic->readAdminProducts();
        $a = $this->replace($array);
        $b = $this->btnInArray($a);
        $table = $this->productsLogic->printTable($b);
        $pages = $this->productsLogic->pagination();

        include "view/admin.php";
    }

    public function collectReadHome()
    {

        $product = $this->productsLogic->readProductsHome();

        $item = $this->productsLogic->printDiv($product);

        include 'view/home.php';
    }

    public function collectImage()
    {
        $products = $this->productsLogic->createCarouselImage($_GET['id']);
        $result = $this->productsLogic->createCarousel($products);
        $product = $this->productsLogic->readProduct($_GET['id']);
        $table = $this->productsLogic->printDetailTable($product);

        include 'view/details.php';

    }

    public function collectCreateProduct()
    {
        if (isset($_POST['send'])) {
            $create = $this->productsLogic->createProduct($_POST['price'], $_POST['platform'], $_POST['resolution'], $_POST['refresh_rate'], $_POST['function'], $_POST['color'], $_POST['accessoires'], $_POST['product_name']
                , $_POST['detail'], $_POST['connection'], $_POST['brand'], $_POST['EAN']);
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'index.php?op=admin';
            header("Location: http://$host$uri/$extra");

        } else {
            $form = $this->productsLogic->createForm();
            include 'view/form.php';
        }
    }

    public function collectUpdateProduct()
    {
        if (isset($_POST['send'])) {
            $this->productsLogic->updateProduct($_POST['price'], $_POST['platform'], $_POST['resolution'], $_POST['refresh_rate'], $_POST['function'], $_POST['color'], $_POST['accessoires'], $_POST['product_name']
            , $_POST['detail'], $_POST['connection'], $_POST['brand'], $_GET['id']);
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'index.php?op=admin';
            header("Location: http://$host$uri/$extra");
//          header('Location: http://localhost/git/multiversum/index.php?op=admin');            // include 'index.php?op=admin';
        } else {
            $dataProduct = $this->productsLogic->readProduct($_GET['id'])[0];
            $form = $this->productsLogic->createForm($dataProduct);
            include 'view/form.php';
        }
    }

    public function collectDeleteProduct()
    {
        $delete = $this->productsLogic->deleteProduct($_GET['id']);
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'index.php?op=admin';
        header("Location: http://$host$uri/$extra");
    }

    public function collectAllProducts()
    {
        $products = $this->productsLogic->readProducts();

        $result = $this->productsLogic->printDiv($products,"product_name","image_path","price");

        $pages = $this->productsLogic->pagination();
        include "view/products.php";
    }


    function btnInArray($array)
    {
        foreach ($array as $key => $value) {
            $array[$key]["Action"] =

                "<a class='btn btn-primary' href='index.php?op=read&id=$value[EAN]'><i class='fas fa-book'></i> Read</a>
                 <a class='btn btn-success' href='index.php?op=update&id=$value[EAN]'><i class='fas fa-edit'></i> Update</a>
                 <a class='btn btn-danger' href='index.php?op=delete&id=$value[EAN]'><i class='fas fa-trash-alt'></i> Delete</a>";
        }
        return $array;
    }

    public function replace($array)
    {
        foreach ($array as $key => $value) {
            $array[$key]["price"] = "€ " . str_replace(".", ",", $value['price']);
        }
        return $array;
    }
}

?>
