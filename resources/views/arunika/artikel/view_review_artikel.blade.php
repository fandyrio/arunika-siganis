<div class='row mb-6'>
    <div class="col-12 mb-3" style='min-height:100px;'>
        <h5 style='color:#1BC5BD;font-weight:bold;'>Reviewer</h5>
        @if($jumlah_reviewer > 0)
            <table class='table'>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal Penetapan</th>
                    <th>Tgl Mulai</th>
                    <th>Tgl Selesai</th>
                    <th>Status</th>
                </tr>
                @foreach($reviewer as $list_reviewer)
                    <tr>
                        <td>{!! $list_reviewer['nama'] !!}<br /><span style='color:orange;'>(Reviewer ke {!! $list_reviewer['review_ke'] !!})</span></td>
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
    <div class="col-12 mb-3">
        <div class="separator separator-solid separator-border-2 mb-3"></div>
        <h5 style='color:#1BC5BD;font-weight:bold;'>Data Review</h5>
    </div>
    @for($x=0;$x<count($data_review->data_review);$x++)
        @php 
            $token_r=$data_review->data_review[$x]->id_review;
            $token_a=$data_review->data_review[$x]->id_artikel;
        @endphp    
        <div class='col-12 mb-6'>
            <h4>Review ke {!! $data_review->data_review[$x]->review_ke !!}</h4>
            <b>Hasil :</b>
            @if($data_review->data_review[$x]->sent_at !== null)
                @if($data_review->data_review[$x]->step_id === 4)
                    <span style='color:orange;font-weight:bold;'>Sedang direview</span>
                @elseif($data_review->data_review[$x]->step_id === 5)
                    <span style='color:orange;font-weight:bold;'>Perbaikan</span>
                @elseif($data_review->data_review[$x]->step_id === 6)
                    <span style='color:green;font-weight:bold;'>Diterima</span>
                @endif
            @else
                <span style='color:orange;font-weight:bold;'>Sedang direview</span>
            @endif
            <br />
            <b>Catatan Reviewer : {!! $data_review->data_review[$x]->sent_at === null ? '-' :  $data_review->data_review[$x]->catatan_reviewer !!}</b><br />
            <br />
            {!! $data_review->data_review[$x]->catatan_jm  !== null ? "<span style='color:red;font-weight:bold;'>Catatan dari Journal Manager : ".$data_review->data_review[$x]->catatan_jm."</span>" : '' !!}
            <div class="separator separator-dashed separator-border-2 mb-6" ></div>
            @if($data_review->data_review[$x]->step_id === 6 || $data_review->data_review[$x]->step_id === 7)
                <b>Accepted eDoc : </b><a href="download/{!! Crypt::encrypt($data_review->data_review[$x]->edoc_perbaikan) !!}/edoc_artikel"><span class='fas fa-file-download'></span> Download</a>
            @endif
            @php
                $display="";
                $class="";
                if($x > 0){
                    $jlh_hasil_review=count($data_review->data_review[$x]->hasil_review);
                    $class='review_stage';
                    $display="none";
                    echo "
                    <b>Hasil Review : </b>
                    <ol>";
                        for($y=0;$y<$jlh_hasil_review;$y++){
                            echo "
                                <li><b>".$data_review->data_review[$x]->hasil_review[$y]->hasil_review."</b><br />
                                    ".$data_review->data_review[$x]->hasil_review[$y]->keterangan."
                                </li>";
                        }
                    echo"
                    </ol>
                    <a href='#' class='driven' data-target='$x'><span class='icon_change_ icon_change_$x fas fa-chevron-right' data-target='$x'></span>
                    <span class='text_keterangan_ text_keterangan_$x'> Lihat detil</span></a>
                    ";
                }
            @endphp
            <div class='row mb-6 {!! $class !!} review_{!! $x !!}' style="padding:10px;display:{!! $display !!}">
                <div class='col-12'>
                    <div class="alert alert-primary" role="alert">
                        1. Checklist Artikel
                    </div>
                    <span style='color:blue;font-weight:bold;'></span>
                    <table class='table table-hover table-striped' style='font-size:1rem;'>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Ya</th>
                            <th>Tidak</th>
                            <th>Keterangan</th>
                        </tr>
                        @if($data_review->data_review[$x]->jumlah_checklist_result === 0 || $data_review->data_review[$x]->sent_at === null)
                            <tr><td colspan="5">Data tidak ditemukan</td></tr>
                        @else
                            @php $no=1 @endphp
                            @foreach($data_review->checklist_result[$x] as $checklist)
                                <tr>
                                    <td>{!! $no !!}</td>
                                    <td>{!! $checklist->pertanyaan !!}</td>
                                    <td>{!! $checklist->hasil === 1 ? "<span class='fas fa-check' style='color:green;'></span>" : '' !!}</td>
                                    <td><center>{!! $checklist->hasil === 0 ? "<span style='color:red;font-weight:bold;font-size:1vw;'>X</span>" : '' !!}</center></td>
                                    <td>{!! $checklist->keterangan !!}</td>
                                </tr>
                                @php $no++ @endphp
                            @endforeach
                        @endif
                    </table>
                    <!-- ============================================================= -->
                    <br /><br />
                    <div class="separator separator-dashed separator-border-2"></div>
                    
                    <br /><br />
                    <!-- ============================================================= -->
                    <div class="alert alert-primary" role="alert" style='font-weight:bold;'>
                        2. Hasil Review
                    </div>
                    
                    <table class='table table-hover table-striped' style='font-size:1rem;'>
                        <tr>
                            <th>No.</th>
                            <th>Hasil Review</th>
                            <th>Keterangan</th>
                        </tr>
                        @if(count($data_review->data_review[$x]->hasil_review) === 0 || $data_review->data_review[$x]->sent_at === null)
                            <tr>
                                <td colspan="3">Belum ada data</td>
                            </tr>
                        @else
                            @php $no=1; @endphp
                            @for($y=0;$y<count($data_review->data_review[$x]->hasil_review);$y++)
                                <tr>
                                    <td>{!! $no !!}</td>
                                    <td>{!! $data_review->data_review[$x]->hasil_review[$y]->hasil_review !!}</td>
                                    <td>{!! $data_review->data_review[$x]->hasil_review[$y]->keterangan !!}</td>
                                </tr>
                                @php $no++; @endphp
                            @endfor
                        @endif
                    </table>
                     <!-- ============================================================= -->
                     <br /><br />
                    <div class="separator separator-dashed separator-border-2"></div>
                    
                    <br /><br />
                    <!-- ============================================================= -->
                    <div class="alert alert-primary" role="alert" style='font-weight:bold;'>
                        3. Informasi Pengiriman Hasil Review
                    </div>
                    <b>Dikirim oleh :</b> {!! $data_review->data_review[$x]->sent_by; !!} <br />
                    <b>Dikirim Pada : </b> {!! $data_review->data_review[$x]->sent_at === null ? '' : date('d-M-Y', strtotime($data_review->data_review[$x]->sent_at)) !!} Pukul : {!! $data_review->data_review[$x]->sent_at === null ? '-' : date('H:i', strtotime($data_review->data_review[$x]->sent_at)) !!} wib<br /><br />
                    @if(isYourArtikel($data_review->data_review[$x]->id_artikel))
                        @if($data_review->data_review[$x]->step_id === 5 && $data_review->data_review[$x]->sent_at !== null)
                            <br /><br />
                            <div class="separator separator-dashed separator-border-2"></div>
                            
                            <br /><br />
                            <!-- ============================================================= -->
                            <div class="alert alert-primary" role="alert" style='font-weight:bold;'>
                                4. Form Perbaikan
                            </div>
                            @if($data_review->data_review[$x]->edoc_perbaikan_penulis === null && $data_review->data_review[$x]->step_id === 5)
                                <form action="save-perbaikan-artikel">
                                    @csrf
                                    <div class='row mb-6'>
                                        <div class='col-lg-12'>
                                            <label>Catatan Penulis</label>
                                            <textarea class="form-control" name="catatan_penulis"></textarea>
                                        </div>
                                    </div>
                                    <div class='row mb-6'>
                                        <div class='col-lg-12'>
                                            <label>File Perbaikan</label>
                                            <input type="file" class="form-control required_field edoc_artikel" name="edoc_perbaikan">
                                            <input type='hidden' name='token_r' value='{!! Crypt::encrypt($data_review->data_review[$x]->id_review) !!}'>
                                            <input type='hidden' name='token_a' value='{!! Crypt::encrypt($data_review->data_review[$x]->id_artikel) !!}'>
                                            <i><span style='color:red;font-size:0.7vw;'>* file berformat doc / docx & Maksimal 6 mb</span></i>
                                        </div>
                                    </div>
                                    <div class='row mb-6'>
                                        <div class="col-12">
                                            <hr />
                                            <center>
                                            <button class='btn btn-success btn-sm saveArtikel'>Simpan</button>
                                            </center>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <b>Edoc Perbaikan :</b> <a href="download/{!! Crypt::encrypt($data_review->data_review[$x]->edoc_perbaikan_penulis) !!}/edoc_artikel">Download</a>&nbsp&nbsp | <a href="#" class='hapusEdoc' data-target="{!! Crypt::encrypt($token_r) !!}" data-artikel="{!! Crypt::encrypt($token_a) !!}"><span class='fas fa-trash'></span> Hapus Edoc</a><br />
                                <b>Catatan dari Penulis : </b> {!! $data_review->data_review[$x]->catatan_penulis !!}
                            @endif
                             <!-- ============================================================= -->
                            <br /><br />
                            <div class="separator separator-dashed separator-border-2"></div>
                            
                            <br /><br />
                            <!-- ============================================================= -->
                            <div class="alert alert-primary" role="alert" style='font-weight:bold;'>
                                5. Kirim Perbaikan
                            </div>
                            @if($data_review->data_review[$x]->send_reviewer_at === null)
                                {!! $data_review->data_review[$x]->edoc_perbaikan_penulis === null ? "<span style='color:red;font-weight:bold;'>Belum dapat mengirimkan perbaikan" : "<br />
                                    <button class='btn btn-success btn-sm sendReviewToAuthor' data-link='send-perbaikan-penulis' data-token='".Crypt::encrypt($token_a)."' data-target='".Crypt::encrypt($token_r)."'><span class='fab fa-telegram-plane'></span> Kirim Perbaikan</button>" !!}
                            @else
                                <br />
                                <b>Waktu Kirim :</b>{!! date('d M Y', strtotime($data_review->data_review[$x]->send_reviewer_at)) !!} Pukul {!! date('H:i', strtotime($data_review->data_review[$x]->send_reviewer_at)) !!} wib
                            @endif
                        @endif
                    @endif
                    <div class="alert alert-primary mt-12" role="alert" style='font-weight:bold;'>&nbsp</div>
                </div>
            </div>
        </div>
        <div class="col-12 mb-6">
            @if($x === 0)
                <h3>Riwayat Review</h3>
            @endif
            <div class="separator separator-dashed separator-border-2 separator-success"></div>
        </div>
    @endfor
</div>
<script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/arunika_services.js?q=30') !!}"></script>