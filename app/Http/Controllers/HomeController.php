<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\BrowserKit\HttpBrowser;

class HomeController extends Controller
{
    public function index()
    {

        $client = new HttpBrowser();

        $gam_data = [];

        $website = $client->request('GET', 'https://satta-king.org/');
        $website = $website->filter('.row.border.border-dark');
        $website->filter('.col-6')->each(function ($node) use (&$gam_data) {
            if (isset($node)) {
                $gam_data[$node->children()->eq(0)->text()] = ["time" => $node->children()->eq(1)->text(), "old_result" => (int)$node->children()->eq(2)->text(), "new_result" => (int)filter_var($node->children()->eq(3)->text(), FILTER_SANITIZE_NUMBER_INT)];
            }
        });
        dd($gam_data);

        return view('home');
    }
}
