<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */
Route::get('/', 'arunikaController@index');

// Route::get('register', 'registerController@index')->name('register')->middleware('isNotLogin');
Route::post('validate-input', 'registerController@validateNIP')->name('validate-nip')->middleware('isNotLogin');
//Route::get('login', 'loginController@index')->name('login')->middleware('isNotLogin');
/* Route::get('login', function(){
    cas()->authenticate();
}); */
Route::get('sso', 'loginController@sso')->name('sso')->middleware('isNotLogin');
//Route::get('login', 'loginController@index')->name('check-login')->middleware('isNotLogin');
// Route::get('logout', 'loginController@logout')->name('logout')->middleware('auth');
Route::get('logout', 'loginController@logoutSso')->name('logout');
Route::get('test/{a}', 'loginController@test')->name('test');

Route::get('dashboard', 'dashboardController@index')->name('dashboard')->middleware('cas.auth');

Route::get('form-new-artikel/{token}/{v_init?}', 'artikelController@formNewArtikel')->name('form-new-artikel')->middleware('cas.auth');
Route::post('form-data-pribadi', 'artikelController@formDataPribadi')->name('form-data-pribadi')->middleware('cas.auth');
Route::post('search-nip', 'artikelController@searchNIP')->name('search-nip')->middleware('cas.auth');
Route::post('save-data-pribadi', 'artikelController@saveDataPribadi')->name('save-data-pribadi')->middleware('cas.auth');
Route::post('update-data-pribadi', 'artikelController@updateDataPribadi')->name('update-data-pribadi')->middleware('cas.auth');
Route::post('form-data-artikel', 'artikelController@formDataArtikel')->name('form-data-artikel')->middleware('cas.auth');
Route::post('update-data-artikel', 'artikelController@updateDataArtikel')->name('update-data-artikel')->middleware('cas.auth');
Route::get('download/{file}/{type}', 'artikelController@downloadFile')->name('download')->middleware('cas.auth');
Route::post("remove-keyword", 'artikelController@removeKeyword')->name('remove-keyword')->middleware('cas.auth');
Route::post('view-data-konfirmasi', 'artikelController@dataKonfirmasi')->name('view-data-konfirmasi')->middleware('cas.auth');
Route::get('list-editorial-team', 'editorialTeamController@listTeam')->name('list-editorial-team')->middleware('cas.auth');

Route::post('add-new-editor', 'editorialTeamController@formAddNew')->name('add-new-editor')->middleware('cas.auth');
Route::post('search-nip-editorial', 'editorialTeamController@searchNip')->name('search-nip-editorial')->middleware('cas.auth');
Route::post('save-editor', 'editorialTeamController@saveEditor')->name('save-editor')->middleware('cas.auth');
Route::post('remove-editor', 'editorialTeamController@removeEditor')->name('remove-editor')->middleware('cas.auth');

Route::get('list-config-web', 'configController@listConfig')->name('list-config-web')->middleware('cas.auth');
Route::get('list-pengumuman', 'artikelController@listPengumuman')->name('list-pengumuman')->middleware('cas.auth');
Route::post('delete-pengumuman', 'artikelController@deletePengumuman')->name('delete-pengumuman')->middleware('cas.auth');
Route::post('add-pengumuman-arunika', 'artikelController@addPengumuman')->name('add-pengumuman-arunika')->middleware('cas.auth');
Route::post('save-pengumuman', 'artikelController@savePengumuman')->name('save-pengumuman')->middleware('cas.auth');
Route::post('edit-pengumuman', 'artikelController@editPengumuman')->name('edit-pengumuman')->middleware('cas.auth');
Route::post('update-pengumuman', 'artikelController@updatePengumuman')->name('update-pengumuman')->middleware('cas.auth');
Route::post('add-new-config', 'configController@formAddConfig')->name('add-new-config')->middleware('cas.auth');
Route::post('save-config', 'configController@saveWebContent')->name('save-config')->middleware('cas.auth');
Route::post('finish-page-artikel', 'artikelController@finishPage')->name('finish-page-artikel')->middleware('cas.auth');
Route::post('prepare-publish', 'artikelController@preparePublish')->name('prepare-publish')->middleware('cas.auth');
Route::post('send-artikel', 'artikelController@sendArtikel')->name('send-artikel')->middleware('cas.auth');
Route::get('list-artikel-proses', 'artikelController@listArtikelProses')->name('list-artikel-proses')->middleware('cas.auth');
Route::get('list-artikel-proses-reviewer', 'artikelController@listArtikelProsesReviewer')->name('list-artikel-proses-reviewer')->middleware('cas.auth');
Route::get('list-artikel-proses-jm', 'artikelController@listArtikelProsesJM')->name('list-artikel-proses-jm')->middleware('cas.auth');
Route::get('list-artikel-selesai-review', 'artikelController@listArtikelSelesaiReview')->name('list-artikel-selesai-review')->middleware('cas.auth');
Route::get('link-artikel-publish-jm', 'artikelController@linkArtikelPublishJM')->name('link-artikel-publish-jm')->middleware('cas.auth');
Route::get('detil-artikel/{id}/{v_init}', 'artikelController@detilArtikel')->name('detil-artikel')->middleware('cas.auth');
Route::post('data-umum-artikel', 'artikelController@dataUmumArtikel')->name('data-umum-artikel')->middleware('cas.auth');
Route::post('data-review', 'artikelController@dataReview')->name('data-review')->middleware('cas.auth');
Route::post('data-review-author', 'artikelController@dataReviewAuthor')->name('data-review')->middleware('cas.auth');
Route::post('form-tambah-reviewer', 'artikelController@formTambahReviewer')->name('form-tambah-reviewer')->middleware('cas.auth');
Route::post('save-reviewer', 'artikelController@saveReviewer')->name('save-reviewer')->middleware('cas.auth');//harus admin
Route::get('list-pertanyaan-review/{page}', 'configController@listPertanyaan')->name('list-pertanyaan-review')->middleware('cas.auth');
Route::post('save-pertanyaan', 'configController@savePertanyaan')->name('save-pertanyaan')->middleware('cas.auth');//harus admin
Route::post('add-new-pertanyaan', 'configController@formNewPertanyaan')->name('form-new-pertanyaan')->middleware('cas.auth');//harus admin
Route::post('remove-pertanyaan', 'configController@removePertanyaan')->name('remove-pertanyaan')->middleware('cas.auth');
Route::get('dec/{str}', 'configController@dec')->name('dec');
Route::post('form-tambah-review', 'artikelController@formTambahReview')->name('form-tambah-review')->middleware('cas.auth');
Route::post('save-checklist-review', 'artikelController@saveChecklistReview')->name('save-checklist-review')->middleware('cas.auth');
Route::post('form-tambah-hasil-review', 'artikelController@formTambahHasilReview')->name('form-tambah-hasil-review')->middleware('cas.auth');
Route::post('save-hasil-review', 'artikelController@saveHasilReview')->name('save-hasil-review')->middleware('cas.auth');//harus reviewer
Route::post("update-hasil-review", 'artikelController@updateHasilReview')->name('update-hasil-review')->middleware('cas.auth');
Route::post('remove-hasil-review', 'artikelController@removeHasilReview')->name('remove-hasil-review')->middleware('cas.auth');//harus reviewer
Route::post('form-tambah-catatan', 'artikelController@formTambahCatatan')->name('form-tambah-catatan')->middleware('cas.auth');
Route::post('save-catatan-reviewer', 'artikelController@saveCatatanReviewer')->name('save-catatan-reviewer')->middleware('cas.auth');
Route::post('send-review-result', 'artikelController@sendReviewResult')->name('send-review-result')->middleware('cas.auth');
Route::post('cancel-review-result', 'artikelController@cancelReviewResultSent')->name('cancel-review-result')->middleware('cas.auth');
Route::post('save-perbaikan-artikel', 'artikelController@savePerbaikanArtikel')->name('save-perbaikan-artikel')->middleware('cas.auth');
Route::post('remove-edoc-perbaikan', 'artikelController@removeEdocPerbaikan')->name('remove-edoc-perbaikan')->middleware('cas.auth');
Route::post('update-foto-penulis', 'artikelController@updateFotoPenulis')->name('update-foto-penulis')->middleware('cas.auth');
Route::post('send-perbaikan-penulis', 'artikelController@sendPerbaikanPenulis')->name('send-perbaikan-penulis')->middleware('cas.auth');
Route::post('form-cancel-publish', 'artikelController@formCancelPublish')->name('form-cancel-publish')->middleware('cas.auth');
Route::post('cancel-publish', 'artikelController@cancelPublish')->name('cancel-publish')->middleware('cas.auth');
Route::post('accept-to-publish', 'artikelController@acceptToPublish')->name('accept-to-publish')->middleware('cas.auth');
Route::post('direct-to-publish', 'artikelController@directToPublish')->name('direct-to-publish')->middleware('cas.auth');
Route::post('data-publish', 'artikelController@dataPublish')->name('data-publish')->middleware('cas.auth');
Route::post('update-edoc-pub', 'artikelController@updateEdocPub')->name('update-edoc-pub')->middleware('cas.auth');
Route::get('preview/{id}', 'artikelController@previewArtikel')->name('preivew')->middleware('cas.auth');
Route::post('publish-artikel', 'artikelController@publishArtikel')->name('publish')->middleware('cas.auth');
Route::post('check-data-personal', 'artikelController@checkDataPersonal')->name('check-data-personal')->middleware('cas.auth');
Route::post('check-data-artikel', 'artikelController@checkDataArtikel')->name('check-data-artikel')->middleware('cas.auth');
Route::post('check-data-review', 'artikelController@checkDataReview')->name('check-data-review')->middleware('cas.auth');
Route::post('check-data-publish', 'artikelController@checkDataPublish')->name('check-data-publish')->middleware('cas.auth');
Route::get('list-artikel-waiting-publish', 'artikelController@listArtikelWaitingPublish')->name('list-artikel-waiting-publish')->middleware('cas.auth');
Route::get('list-artikel-publish', 'artikelController@listArtikelPublish')->name('list-artikel-publish')->middleware('cas.auth');
Route::get('list-issue-artikel', 'issueArtikelController@index')->name('list-issue-artikel')->middleware('cas.auth');
Route::post('add-issue-artikel', 'issueArtikelController@formAddIssue')->name('add-issue-artikel')->middleware('cas.auth');
Route::post('save-issue-artikel', 'issueArtikelController@saveIssueArtikel')->name('save-issue-artikel')->middleware('cas.auth');
Route::post('update-issue-artikel', 'issueArtikelController@updateIssueArtikel')->name('update-issue-artikel')->middleware('cas.auth');
Route::post('edit-config', 'configController@editConfig')->name('edit-config')->middleware('cas.auth');
Route::post('update-config', 'configController@updateConfig')->name('update-config')->middleware('cas.auth');
Route::get('list-draft', 'artikelController@listDraft')->name('list-draft')->middleware('cas.auth');

Route::get('home', 'arunikaController@index')->name('home');
Route::post('edit-issue-artikel', 'issueArtikelController@getIssueById')->name('edit-issue-artikel')->middleware('cas.auth');
Route::post('delete-issue-artikel', 'issueArtikelController@deleteIssueArtikel')->name('delete-issue-artikel')->middleware('cas.auth');
Route::post('form-tambah-tema', 'artikelController@formTambahTema')->name('form-tambah-tema')->middleware('cas.auth');
Route::post('update-tema', 'artikelController@updateTema')->name('update-tema')->middleware('cas.auth');
Route::get('issue/{code}', 'arunikaController@getListArtikelByIssue')->name('issue');
Route::get('category/{key}/{any?}', 'arunikaController@getArtikelByCategory')->name('category-by-key-category');

Route::get('baca-artikel/{edoc_name}/{id}', 'arunikaController@bacaArtikel')->name('artikel');
Route::get('tags/{tag}', 'arunikaController@getArtikelByTag')->name('tag');
Route::get('404', 'arunikaController@err404')->name('404');
Route::get('sedang-publish', 'arunikaController@artikelSedangPublish')->name('sedang-publish');
Route::get('arsip', 'arunikaController@arsipIssue')->name('arsip-issue');
Route::get('search', 'arunikaController@searchArtikel')->name('search-artikel');
Route::get('early-view', 'arunikaController@earlyview')->name('early-view');
Route::post('search', 'arunikaController@searchResult')->name('search');
Route::get('download-artikel/{file}/{type}', 'arunikaController@downloadFile')->name('download-file');
Route::post('validate-reader', 'arunikaController@setReader')->name('validate-reader');
Route::get('all-category', 'arunikaController@getAllCategory')->name('all-category');
Route::post('resize-img-view', 'arunikaController@resizeImageView')->name('resize-img-view');
Route::get('syarat-penulisan', 'arunikaController@getSyaratPenulisan')->name('syarat-penulisan');
Route::get('checklist-penilaian', 'arunikaController@getChecklistPenilaian')->name('checklist-penulisan');
Route::get('artikel/{page?}', 'arunikaController@getAllArtikel')->name('all-artikel');
Route::get('penulis-artikel/{nama}/{id_pegawai}', 'arunikaController@getArtikelByPenulis')->name('penulis-artikel');
//Route::get('test-pdf', 'artikelController@testpdf')->name('test-pdf');
//Route::get('generateAdmin', 'registerController@createUserAdmin')->name('generate-admin');