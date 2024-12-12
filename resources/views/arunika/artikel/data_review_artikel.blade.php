<div class='row mb-6'>
    <div class="col-12 mb-3" style='min-height:100px;'>
        <br />
        <h5 style='color:#1BC5BD;font-weight:bold;'>Reviewer</h5>
        @if(isJM())
            <button class='btn btn-success btn-xs addReviewer' style='float:right;'>Tambah Reviewer</button>
            <br /><br /><br />
            @if($data_review->artikel->step <= 6)
                <button class='btn btn-warning btn-sm directPublish' style='float:right;' data-target='{!! Crypt::encrypt($artikel_id) !!}'><span class='fas fa-check'></span> Langsung Publish</button>
            @endif
        @endif
        @if($jumlah_reviewer > 0)
            <table class='table' style='font-size:1rem'>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal Penetapan</th>
                    <th>Tgl Mulai</th>
                    <th>Tgl Selesai</th>
                    <th>Status</th>
                </tr>
                @foreach($reviewer as $list_reviewer)
                    <tr>
                        <td>{!! $list_reviewer['nama'] !!}  <br /> <span style='color:orange;font-weight:bold;'>(Reviewer ke {!! $list_reviewer['review_ke'] !!})</span> </td>
                        <td>{!! date('d-m-Y', strtotime($list_reviewer['tgl_pilih'])) !!}</td>
                        <td>{!! date('d-m-Y', strtotime($list_reviewer['tgl_mulai'])) !!}</td>
                        <td>{!! date('d-m-Y', strtotime($list_reviewer['tgl_estimasi_selesai'])) !!}</td>
                        <td>{!!  $list_reviewer['status'] === 1 ? 'Aktif' : 'Tidak aktif' !!}</td>
                    </tr>
                @endforeach
            </table>
        @else
                <span style='color:orange;'>Reviewer belum dipilih</span>
        @endif
    </div>
</div>
<div class='row mb-3'>
    <div class="col-12 mb-6">
        <div class="separator separator-dashed separator-border-2 mb-6"></div>
        <h5 style='color:#1BC5BD;font-weight:bold;'>Data Review</h5>
        @if($jumlah_reviewer > 0)
            @if($jumlah_review === 0)
                <span style='color:red;font-weight:bold;'>Review belum dilaksanakan</span>
            @else
                @for($x=0;$x<count($data_review->data_review);$x++)
                    @php 
                        $token_r=$data_review->data_review[$x]->id_review;
                        $token_a=$data_review->data_review[$x]->id_artikel;
                    @endphp    
                    <h5>Review ke {!! $data_review->data_review[$x]->review_ke !!}</h5>
                    @php
                        $display="";
                        if($x > 0){
                            $display="none";
                            echo "<p><b>Status : <span style='color:red;'>Perbaikan.</span></b><br />
                            <b>Catatan : </b>".$data_review->data_review[$x]->catatan_reviewer."</p>
                            <a href='#' class='driven' data-target='$x'><span class='icon_change_$x fas fa-chevron-right' data-target='$x'></span>
                            <span class='text_keterangan_$x'> Lihat detil</span></a>
                            ";
                        }
                        if($data_review->data_review[$x]->catatan_jm !== null){
                            echo "<b>Status : <span style='color:red;'>Perbaikan dari Journal Manager</span><br />";
                            echo "<b>Catatan dari Journal Manager :  </b><span style='color:red;'>".$data_review->data_review[$x]->catatan_jm."</span>";
                        }
                    @endphp
                    <div class="separator separator-dashed separator-border-2 mb-6" style='font-size:2vw;'></div>
                    <div class="timeline timeline-2 review_{!! $x !!}" style='display:{!! $display !!}'>
                        <div class="timeline-bar"></div>
                        
                        <div class="timeline-item" style='margin-bottom:40px;'>
                            <span class="timeline-badge bg-success"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                    @if($data_review->data_review[$x]->step_id === 6)
                                        <h6><span style='color:;font-weight:bold;'>Dokumen yang disetujui Reviewer</span></h6>
                                    @else
                                        <h6><span style='color:;font-weight:bold;'>Dokumen yang direview</span></h6>
                                    @endif
                                    @if((int)$data_review->data_review[$x]->review_ke > 1)
                                    <a href="download/{!! Crypt::encrypt($data_review->data_review[$x]->edoc_perbaikan) !!}/edoc_artikel"><span class='fas fa-file-download'></span>  Download</a>
                                    @else
                                    <a href="download/{!! Crypt::encrypt($data_review->artikel->edoc_artikel) !!}/edoc_artikel"><span class='fas fa-file-download'></span>  Download</a>
                                    @endif
                                </span>
                                <span class="text-muted text-right">
                                    @if($data_review->data_review[$x]->step_id === 6 && isJM() === true)
                                        <button class='btn btn-success btn-sm acceptToPublish' data-token_a='{!! Crypt::encrypt($token_a) !!}' data-token_r="{!! Crypt::encrypt($token_r) !!} "><span class='fas fa-check'></span> Setuju Publish</button>
                                        <button class='btn btn-danger btn-sm cancelPublish' data-token_a="{!! Crypt::encrypt($token_a) !!}" data-token_r="{!! Crypt::encrypt($token_r) !!}"> X Belum dapat dipublish</button>
                                   @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="timeline-item" style='margin-top:30px;'>
                            <div class="timeline-badge bg-success"></div>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                <h6><span style='color:;font-weight:bold;'>Form Checklist Artikel</span></h6>
                                    <input type='hidden' name='token_r[]' value="{!! Crypt::encrypt($data_review->data_review[$x]->id_review) !!}">

                                    {!! $data_review->data_review[$x]->jumlah_checklist_result === 0 ? "<span style='color:red;font-weight:bold;'>Form Checklist Belum diisi</span>" :  "<span style='color:#1BC5BD;font-weight:bold;'>Form Checklist Telah diisi</span>" !!}
                                    @if($data_review->data_review[$x]->jumlah_checklist_result === 0)
                                        @php $label="Isi Checklist Artikel"; @endphp
                                    @else
                                        |  <a href="#" class='addReview' data-index="{!! $x !!}" data-target="form_checklist">Lihat Form</a>
                                        <br /><br />
                                        <b><span style='color:red;'>Checklist Artikel : </span></b>
                                        <ol>
                                        @php $ada_catatan=0; @endphp
                                        @foreach($data_review->checklist_result[$x] as $list_result)
                                            @if($list_result->hasil === 0)
                                                @php $ada_catatan+=1 @endphp
                                                <li><b>Kriteria : </b>{!! $list_result->pertanyaan !!}<br /><b>Keterangan : </b>{!! $list_result->keterangan !!}</li>
                                            @endif
                                        @endforeach
                                        <ol>
                                        {!! $ada_catatan === 0 ? 'Seluruh Checklist telah dipenuhi' : '' !!}
                                    @endif
                                </span>
                                <span class="text-muted text-right">
                                    @if($data_review->data_review[$x]->jumlah_checklist_result === 0 && isYourReviewArtikel($token_r, $token_a) === true)
                                        <button class="btn btn-success btn-xs addReview" data-index="{!! $x !!}">Isi Checklist Artikel</button>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="timeline-item" style='margin-top:30px;'>
                            <span class="timeline-badge bg-success"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                    <h6><span style=';font-weight:bold;'>Form Hasil Review.</span></h6>
                                    <!-- <span class="label label-inline label-light-primary font-weight-bolder">new</span>
                                    <span class="label label-inline label-light-danger font-weight-bolder">hot</span> -->
                                     <b><span style='color:red;font-weight:bold;'>Hasil Review : </span></b>
                                     @if($data_review->data_review[$x]->jumlah_hasil_review > 0)
                                        <ol>    
                                        @for($y=0;$y<count($data_review->data_review[$x]->hasil_review);$y++)
                                            <li><b>{!! $data_review->data_review[$x]->hasil_review[$y]->hasil_review !!}.</b>&nbsp&nbsp&nbsp
                                                <button class='btn btn-warning btn-icon btn-xs btn-circle editHasilReview' data-index="{!! $x !!}" data-target="{!! Crypt::encrypt($data_review->data_review[$x]->hasil_review[$y]->id_catatan)  !!}" style='font-size:0.7vw;' alt='Edit'>
                                                <i class='fa fa-pencil-alt'></i>
                                                </button>
                                                <button class='btn btn-danger btn-icon btn-xs btn-circle removeHasil' data-index="{!! $x !!}" data-target="{!! Crypt::encrypt($data_review->data_review[$x]->hasil_review[$y]->id_catatan)  !!}" style='font-size:0.7vw;' alt='Edit'>
                                                <i class='fa fa-trash-alt'></i>
                                                </button>
                                            </a> <br />{!! nl2br($data_review->data_review[$x]->hasil_review[$y]->keterangan) !!}</li>
                                        @endfor
                                    </ol>
                                    @else
                                        <br />
                                        <span style='color:red;font-weight:bold;'>Belum ada hasil</span>
                                    @endif
                                </span>
                                <span class="text-muted font-italic text-right">
                                    @if($data_review->data_review[$x]->sent_at === null && $data_review->data_review[$x]->isYourReviewArtikel === true)
                                        <button class='btn btn-success btn-sm hasilReview' data-index="{!! $x !!}">[+]Tambah hasil review</button>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="timeline-item" style='margin-top:30px;'>
                            <span class="timeline-badge bg-success"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                    <h6><span style='color:;font-weight:bold;'>Catatan Kepada Penulis / Author</span></h6>

                                    @if($data_review->data_review[$x]->catatan_reviewer === null)
                                    <div class="separator separator-dashed separator-border-2 mb-6"></div>
                                        <span style='color:red;font-weight:bold'>Catatan belum ada</span>
                                    @else
                                        <span style='color:green;font-weight:bold'>Status Artikel :</span> <span style="font-weight:bold;color:{!! $data_review->data_review[$x]->status_artikel === 'Perbaikan' ? 'red' : 'green' !!}">{!! $data_review->data_review[$x]->status_artikel !!}</span>
                                        <br />
                                        <b>Catatan Reviewer : </b> {!! $data_review->data_review[$x]->catatan_reviewer !!}
                                        
                                        <button class='btn btn-warning btn-icon btn-xs btn-circle addNotesToAuthor' data-target="{!! Crypt::encrypt($data_review->data_review[$x]->id_review)  !!}" data-index="{!! $x !!}" style='font-size:0.7vw;' alt='Edit'>
                                            <i class='fa fa-pencil-alt'></i>
                                        </button>
                                        

                                    @endif
                                </span>
                                <span class="text-muted text-right">
                                    @if($data_review->data_review[$x]->catatan_reviewer === null && $data_review->data_review[$x]->isYourReviewArtikel === true)
                                        <button class="btn btn-success btn-xs addNotesToAuthor" data-index="{!! $x !!}">[+]Tambah catatan</button>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="timeline-item" style='margin-top:30px;'>
                            <span class="timeline-badge bg-success"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                    <h6><span style='color:#1BC5BD;font-weight:bold;'>Kirim Hasil Review ke Author / Penulis</span></h6> 
                                    @if($data_review->data_review[$x]->jumlah_checklist_result > 0 && $data_review->data_review[$x]->jumlah_hasil_review > 0 && ($data_review->data_review[$x]->step_id === 5 || $data_review->data_review[$x]->step_id === 6 || $data_review->data_review[$x]->step_id === 7 || $data_review->data_review[$x]->step_id === 8) && $data_review->data_review[$x]->catatan_reviewer !== null)
                                        <b>Dikirim oleh : </b> {!! $data_review->data_review[$x]->sent_by !!}  <br />
                                        <b>Dikirim Pada : </b>{!! $data_review->data_review[$x]->sent_at === null ? '' : date('d-M-Y', strtotime($data_review->data_review[$x]->sent_at)) !!} Pukul : {!! $data_review->data_review[$x]->sent_at === null ? '-' : date('H:i', strtotime($data_review->data_review[$x]->sent_at)) !!} wib<br /><br />
                                    @else
                                        <span style='color:red;font-weight:bold'>Belum dapat mengirimkan Hasil review</span>
                                    @endif
                                </span>
                                <span class="text-muted text-right">
                                    @if($data_review->data_review[$x]->isYourReviewArtikel)
                                        @if($data_review->data_review[$x]->sent_at === null)
                                            <span class='btn_place'>
                                                <button class='btn btn-success btn-sn sendReviewToAuthor' data-link='send-review-result' data-token="{!! Crypt::encrypt($token_a) !!}" data-target="{!! Crypt::encrypt($token_r) !!}">
                                                <span class='fab fa-telegram-plane'></span> Kirim Hasil Review ke Author</button></span>
                                            </span>
                                        @else
                                            <span class='btn_place'>
                                                <button class='btn btn-danger btn-xs sendReviewToAuthor' data-token="{!! Crypt::encrypt($token_a) !!}" data-target="{!! Crypt::encrypt($token_r) !!}" data-link='cancel-review-result'>X Batalkan Pengiriman Hasil</button>
                                            </span>
                                        @endif
                                    @endif
                                    
                                </span>
                            </div>
                        </div>
                        @if($data_review->data_review[$x]->step_id === 5 && $data_review->data_review[$x]->sent_at !== null)
                            <div class="timeline-item" style='margin-top:30px;'>
                                <span class="timeline-badge bg-success"></span>
                                <div class="timeline-content d-flex align-items-center justify-content-between">
                                    <span class="mr-3">
                                        <h6><span style='color:#1BC5BD;font-weight:bold;'>Dokumen Perbaikan Penulis</span></h6> 
                                        @if($data_review->data_review[$x]->edoc_perbaikan_penulis === null)
                                            <span style='color:red;'>Menunggu Perbaikan dilakukan oleh penulis</span>
                                        @else
                                            <b>Dokumen perbaikan : </b>
                                            <a href="download/{!! Crypt::encrypt($data_review->data_review[$x]->edoc_perbaikan_penulis) !!}/edoc_artikel">Download</a> <br />
                                            <b>Tanggal Kirim Perbaikan : </b> {!! date('d M Y', strtotime($data_review->data_review[$x]->send_reviewer_at)) !!}  - Pukul {!! date('H:i', strtotime($data_review->data_review[$x]->send_reviewer_at)) !!} wib
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="timeline-item">
                            <span class="timeline-badge bg-success"></span>
                            <div class="timeline-content d-flex align-items-center justify-content-between">
                                <span class="mr-3">
                                <h6><span style='color:#1BC5BD;font-weight:bold;'>Selesai</span></h6> 
                                </span>
                                <span class="text-muted font-italic text-right">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="separator separator-dashed separator-border-2 mb-20"></div>
                @endfor
            @endif
        @else
        <span style='color:red;font-weight:bold;'>Reviewer tidak dapat dilaksanakan karena reviewer belum dipilih</span>
        @endif
    </div>
</div>

<script src="{!! asset('assets/js/arunika_services.js?q=12345') !!}"></script>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>