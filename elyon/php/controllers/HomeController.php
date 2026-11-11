<?php

require_once __DIR__ . '/../models/Produto.php';

class HomeController
{
    public function index()
    {
        $model = new Produto();

        $produtos = $model->listar();

        require_once __DIR__ . '/../views/home/index.php';
    }

    public function masculino()
    {
        $model = new Produto();

        $produtos = $model->listarMasculino();

        require_once __DIR__ . '/../views/home/index.php';
    }

    public function feminino()
    {
        $model = new Produto();

        $produtos = $model->listarFeminino();

        require_once __DIR__ . '/../views/home/index.php';
    }

    public function cabelos()
    {
        $model = new Produto();

        $produtos = $model->listarCabelos();

        require_once __DIR__ . '/../views/home/index.php';
    }

    public function skincare()
    {
        $model = new Produto();

        $produtos = $model->listarSkincare();

        require_once __DIR__ . '/../views/home/index.php';
    }

    public function maquiagem()
    {
        $model = new Produto();

        $produtos = $model->listarMaquiagem();

        require_once __DIR__ . '/../views/home/index.php';
    }
}