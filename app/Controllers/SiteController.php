<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Package;

final class SiteController extends Controller
{
    public function home(): string
    {
        return $this->view('site.home', ['pacotes' => Package::byCategory('avulso')], layout: null);
    }
}
