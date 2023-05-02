<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function getJumlahPendudukMiskin()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://sata.jatimprov.go.id/bps.php?id=185&a=3500');
        $data = json_decode($response->getBody(), true);

        // Filter data untuk mendapatkan field "jumlah" di tahun 2022
        $filteredData = array_filter($data['result']['data'], function ($item) {
            return $item['tahun'] == '2022';
        });

        // Mengambil data jumlah
        $jumlah = [];
        foreach ($filteredData as $item) {
            $jumlah[] = $item['jumlah'];
            break;
        }

        // Mengembalikan data jumlah
        return $jumlah;
    }

    public function getKetersediaanAir()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://sata.jatimprov.go.id/bps.php?id=115&a=3500');
        $data = json_decode($response->getBody(), true);

        $filteredData = array_filter($data['result']['data'], function ($item) {
            return $item['tahun'] == '2021';
        });

        $jumlah = [];
        foreach ($filteredData as $item) {
            $jumlah[] = $item['jumlah'];
        }

        return $jumlah;
    }

    public function getKebutuhanAir()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://sata.jatimprov.go.id/bps.php?id=76&a=3500');
        $data = json_decode($response->getBody(), true);

        $filteredData = array_filter($data['result']['data'], function ($item) {
            return $item['tahun'] == '2021';
        });

        $jumlah = [];
        foreach ($filteredData as $item) {
            $jumlah[] = $item['jumlah'];
        }
        return $jumlah;
    }
}
