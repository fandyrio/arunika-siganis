@php
    $action="save-issue-artikel";
    $tema=null;
    $year=null;
    $description=null;
    $flyer=null;
    $input_file="";
    $required="required_field";
    $token_id="";
    $status="";
    $status_call_for_paper="";
    $status_publish="";
    $status_arsip="";
    $disabled="";
    $cfp=false;
    if(isset($data)){
        $action="update-issue-artikel";
        $tema=$data['name'];
        $cfp=$data['cfp'];
        $year=$data['year'];
        $description=$data['description'];
        $flyer=$data['flyer'];
        $input_file="none";
        $token_id=Crypt::encrypt($data['id']);
        $required="";
        if($data['status'] === 1){
            $status_call_for_paper="selected";
        }else if($data['status'] === 2){
            $status_publish="selected";
        }else{
            $status_arsip="selected";
        }
        
    }
@endphp
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Form Tambah Konfigurasi</h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{!! $action !!}">
        @csrf
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Tema</label>
                    <input type='text' class='form-control required_field' name='name' value="{!! $tema === null ? '' : $tema !!}">
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Tahun</label>
                    <input type='number' class='form-control required_field' name='year' value="{!! $year === null ? '' : $year !!}">
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Status</label>
                    <select class="form-control required_field" name="status" {!! $disabled !!}>
                        <option value="">Pilih Status</option>
                        <option value="1" {!! $status_call_for_paper !!}>Call For Paper</option>
                        <option value="2" {!! $status_publish !!}>Publish</option>
                        <option value="3" {!! $status_arsip !!}>Archive</option>
                    </select>
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Call For Paper</label>
                    {!! $cfp === 1 ? "<span style='color:red;'>Ya</span>" : "<span style='color:green;'>Tidak</span>" !!}
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Deksripsi</label>
                    <textarea class="form-control" name="description">{!! $description === null ? '' : $description !!}</textarea>
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Flyer</label>
                    <br />
                    <div class="row">
                        <div class="col-md-6">
                            @if($input_file === "none")
                                <button class='btn btn-success btn-sm changeFlyer' type="button">Ganti Fyer</button>
                                <br />
                                <div class="filename_baru"></div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($input_file === "none")
                                <span class='img_flyer'><img src="{!! $flyer !!}" width="100%"></span>
                            @endif
                        </div>
                    <div>
                    <input type="file" class="form-control file_input {!! $required !!}"  name="flyer" style="display:{!! $input_file !!}">
                    <input type="hidden" name="token_i" value="{!! $token_id !!}">
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <hr />
                    <button class='btn btn-success btn-md saveArtikel'>Simpan</button>
                    <button class="btn btn-danger btn-md back" type="button" onClick="callLink('list-issue-artikel')">Kambali</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services_config.js?q=1234') !!}"></script>
