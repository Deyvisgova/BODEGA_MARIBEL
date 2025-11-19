<?php
require_once __DIR__ . '/Controller.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $this->render(__DIR__ . '/../vista/home.php');
    }
}
