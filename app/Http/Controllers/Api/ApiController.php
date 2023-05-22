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
        //responseKetersedianair
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
        //response kebutuhanAir
    }

    public function getData()
    {
        $jumlahPendudukMiskin = $this->getJumlahPendudukMiskin();
        $ketersediaanAir = $this->getKetersediaanAir();
        $kebutuhanAir = $this->getKebutuhanAir();

        $atas = [
            [
                'id' => 1,
                'name' => 'Ketersediaan Listrik',
                'value' => 24,
            ],
            [
                'id' => 2,
                'name' => 'RT Pengguna listrik',
                'value' => 50,
            ],
            [
                'id' => 3,
                'name' => 'Volume ketersediaan air baku',
                'value' => 85,
            ],
            [
                'id' => 4,
                'name' => 'Panjang jaringan irigrasi dalam kondisi baik',
                'value' => 36,
            ],
            [
                'id' => 5,
                'name' => 'Jumlah Penduduk Miskin',
                'value' => $jumlahPendudukMiskin,
            ],
            [
                'id' => 6,
                'name' => 'Jumlah Ketersediaan Air',
                'value' => $ketersediaanAir,
            ],
        ];

        $bawah = [
            [
                'id' => 1,
                'name' => 'Kebutuhan Listrik',
                'value' => 5,
            ],
            [
                'id' => 2,
                'name' => 'Jumlah rumah tangga',
                'value' => 8,
            ],
            [
                'id' => 3,
                'name' => 'Volume kebutuhan air baku',
                'value' => 10,
            ],
            [
                'id' => 4,
                'name' => 'Panjang jaringan irigrasi total',
                'value' => 40,
            ],
            [
                'id' => 5,
                'name' => 'Jumlah kebutuhan Air',
                'value' => $kebutuhanAir,
            ],
        ];

        $result = [
            'atas' => $atas,
            'bawah' => $bawah,
        ];

        return response()->json($result);
    }
}
