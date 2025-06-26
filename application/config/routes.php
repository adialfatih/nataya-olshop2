<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'beranda';
$route['dashboard'] = 'beranda';
//$route['manager-dashboard'] = 'beranda/dsbmng';
$route['operator-dashboard'] = 'beranda/dsbopt';
$route['404_override'] = 'Notfounde';
$route['translate_uri_dashes'] = FALSE;
//$route['produksi-insfinish/(:any)'] = 'produksistx/insfinish/$1';

$route['login-action'] = 'login/aksi_login';
$route['akses-users'] = 'beranda/akses_user';
$route['bot'] = 'beranda/bot_wa';
$route['product'] = 'beranda/product';
$route['product/data-stok'] = 'data/product_stok';
$route['product/data-stok/(:any)'] = 'data/product_stok2';
$route['product/(:any)'] = 'beranda/product_byid';
$route['product/(:any)/id/(:any)'] = 'beranda/product_byid';
$route['product/(:any)/id/(:any)/(:any)'] = 'beranda/product_byid';
$route['product/update/(:any)'] = 'beranda/product_update';
$route['distributor'] = 'beranda/distributor';
$route['reseller'] = 'beranda/reseller';
$route['data-stok'] = 'beranda/data_stok';
$route['data-stok/toko'] = 'beranda/data_stok';
$route['data-stok/gudang'] = 'beranda/data_stok';
$route['data-kain'] = 'beranda/data_kain';
$route['data-kain/id/(:any)'] = 'beranda/data_kain';
$route['data-kain/update/(:any)'] = 'beranda/data_kain';
$route['data-kain/masuk'] = 'beranda/riwayat_kain';
$route['data-kain/pengiriman'] = 'beranda/riwayat_kain';
$route['data-kain/kirim/id/(:any)'] = 'beranda/kirim_kain';
$route['produksi'] = 'beranda/produksi';
$route['cash-flow'] = 'beranda/cashflow';
$route['stok/kirim/customer'] = 'stok/send_customer';
$route['stok/kirim/customer/(:any)'] = 'stok/send_customer';
$route['stok/kirim/agen'] = 'stok/send_to_agen';
$route['stok/kirim/agen/(:any)'] = 'stok/send_to_agen';
$route['stok/kirim/reseller'] = 'stok/send_reseller';
$route['stok/kirim/reseller/(:any)'] = 'stok/send_reseller';
$route['data-stok/keluar'] = 'stok/keluarall';
$route['data-stok/keluar/rekap'] = 'stok/rekapPengeluaran';
$route['data-stok/masuk'] = 'stok/masukall';
$route['data-stok/mutasi'] = 'stok/mutasiall';
$route['rekapitulasi'] = 'stok/rekapPengeluaran';
$route['rekap/setoran/reseller'] = 'stok/rekapSetoran';

$route['mutasi/toko/gudang'] = 'mutasi/create_mutasi';
$route['mutasi/gudang/toko'] = 'mutasi/create_mutasi';

$route['mutasi/toko/gudang/(:any)'] = 'mutasi/create_mutasi';
$route['mutasi/gudang/toko/(:any)'] = 'mutasi/create_mutasi';

$route['tagihan'] = 'data/tagihan';
$route['piutang'] = 'data/piutang';
$route['piutang/id/(:any)'] = 'data/piutangid';
$route['tagihan/id/(:any)'] = 'data/tagihanid';
$route['tagihan/detail/(:any)'] = 'data/tagihanid2';
$route['redirecting/(:any)/(:any)'] = 'data/redirect';
$route['data-stok/masuk/(:any)'] = 'data/stokmasuk';
$route['produk/data-stok-in'] = 'data/data_stok_in';

$route['save-user'] = 'proses/simpan_user';
$route['save-bot'] = 'proses/save_bot';
$route['save-produk'] = 'proses/save_produk';
$route['save-kategori'] = 'proses/save_kat';
$route['add-image-to-produk'] = 'proses/save_produk_image';
$route['update-product'] = 'proses/update_produk';
$route['save-distributor'] = 'proses/save_distributor';
$route['save-reseller'] = 'proses/save_reseller';
$route['save-produsen'] = 'proses/save_produsen';
$route['save-stokin'] = 'proses/stok_in';
$route['input-kain'] = 'proses/inputkain';
$route['save-stok-kain'] = 'proses/savekain_masuk';
$route['proses-hapuskain-in'] = 'proses/delkain_masuk';
$route['save-kirim-kain'] = 'proses/kirim_kain';
$route['save-saldoawal'] = 'proses/saldoawal';
$route['save-kain-per-item'] = 'proses/save_per_item';
$route['save-foto-sj'] = 'proses/save_foto_sj';
$route['save-update-kain'] = 'proses/saveupdatekain';
$route['save-pembayaran-tagihan'] = 'proses/savepembayaran';
$route['save-pembayaran-hutang'] = 'proses/savepembayaranhutang';
$route['akses-produsen'] = 'proses/aksesprodusen';

$route['save-stokin-produk'] = 'proses/saveprodukmasuk';

$route['update-kode'] = 'proses/updatekodeproduk';
$route['save-reseller-bayar'] = 'proses2/savebayarresel';
$route['reseller/tagihan/nota/(:any)'] = 'beranda/reseller2';
$route['reseller/data/tagihan/(:any)'] = 'reseller2/datas';



$route['signature'] = 'signature/index';
$route['signature/(:any)/(:any)/(:any)'] = 'signature/index';
//$route['signature/save/'] = 'signature/save';
$route['signature/save/(:any)/(:any)'] = 'signature/save/$1/$2';

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/

$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
