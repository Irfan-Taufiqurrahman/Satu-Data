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
        //karena satuan data masih dalam ribuan, dirubah menjadi per orang dengan cara dikali 1000
        $finalValue = end($jumlah) * 1000;

        // Mengembalikan data jumlah
        return $finalValue;
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

    // public function getJumlahPendudukKK()
    // {
    //     $client = new Client();
    //     $response = $client->request('GET', 'https://sata.jatimprov.go.id/service.php/dataset/jumlah-penduduk-jawa-timur-berdasarkan-kk');
    //     $data = json_decode($response->getBody(), true);

    //     if (isset($data['result']['data'])) {
    //         $filteredData = array_filter($data['result']['data'], function ($item) {
    //             return isset($item['tahun']) && $item['tahun'] == '2021';
    //         });

    //         $jumlah = array_sum(array_column($filteredData, 'jumlah_penduduk_berdasarkan_kk'));

    //         return $jumlah;
    //     } else {
    //         return 0; // If no data is found
    //     }
    // }


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
        // $jumlahPendudukKK = $this->getJumlahPendudukKK();

        $atas = [
            [
                'id' => 1,
                'name' => 'Jumlah Pelanggaran HAM yang ditindak lanjuti 2018',
                'value' => 392610,
            ],
            [
                'id' => 2,
                'name' => 'Jumlah Pelanggaran HAM yang ditindak lanjuti 2019',
                'value' => 421752,
            ],
            [
                'id' => 3,
                'name' => 'Jumlah Pelanggaran HAM yang ditindak lanjuti 2020',
                'value' => 291677,
            ],
            [
                'id' => 4,
                'name' => 'Jumlah Penduduk yang bekerja 2021',
                'value' => 1332360,
            ],
            [
                'id' => 5,
                'name' => 'Jumlah Penduduk Miskin di Jawa Timur 2020',
                'value' => 4419100,
            ],
            [
                'id' => 6,
                'name' => 'Jumlah Penduduk Miskin di Jawa Timur 2021',
                'value' => 4572730,
            ],
            [
                'id' => 7,
                'name' => 'Jumlah Ketersediaan Air 2021',
                'value' => $ketersediaanAir,
            ],
            [
                'id' => 8,
                'name' => 'Jumlah Koperasi Aktif Jawa Timur 2021',
                'value' => 22845,
            ],

        ];

        $bawah = [
            [
                'id' => 1,
                'name' => 'Jumlah Pelanggaran HAM terjadi 2019',
                'value' => 431471,
            ],
            [
                'id' => 2,
                'name' => 'Jumlah Pelanggaran HAM terjadi 2018',
                'value' => 406178,
            ],
            [
                'id' => 3,
                'name' => 'Jumlah Pelanggaran HAM terjadi 2020',
                'value' => 299911,
            ],
            [
                'id' => 4,
                'name' => 'Jumlah Angkatan Kerja 2021',
                'value' => 22180000,
            ],
            [
                'id' => 5,
                'name' => 'Jumlah Penduduk Jawa Timur 2020',
                'value' => 41149974,
            ],
            [
                'id' => 6,
                'name' => 'Jumlah Penduduk Jawa Timur 2021',
                'value' => 40878789,
            ],
            [
                'id' => 7,
                'name' => 'Jumlah kebutuhan Air 2021',
                'value' => $kebutuhanAir,
            ],
            [
                'id' => 8,
                'name' => 'Jumlah Koperasi Seluruh Indonesia 2021',
                'value' => 127846,
            ]
        ];

        $result = [
            'atas' => $atas,
            'bawah' => $bawah,
        ];

        return response()->json($result);
    }
}
