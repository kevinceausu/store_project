<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $productModel;

    public function __construct($db)
    {
        $this->productModel = new Product($db);
    }

    // Show a single product's detail page
    public function show($id)
    {
        $product = $this->productModel->getById($id);

        if (!$product) {
            die("❌ Product not found.");
        }

        // Pass product data to the view
        require __DIR__ . '/../views/products/show.php';
    }

    // Show all products
    public function index()
    {
        $products = $this->productModel->getAll();
        require __DIR__ . '/../views/products/index.php';
    }
}
