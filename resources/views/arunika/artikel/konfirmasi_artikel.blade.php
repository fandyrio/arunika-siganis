<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
           <span class='text-warning font-weight-bold' style='font-size:1.5rem;'>Konfirmasi Data</span>
        </h3>
    </div>
    <div class="card-toolbar font-weight-bold" style='font-size:1.5rem;line-height:3;'>
        {!! $pernyataan !!}

        <hr />
        <center>
        <label class="checkbox">
            <input class='agreement' type="checkbox" {!! $checked !!} {!! $checked ? 'disabled' : '' !!}/> Seluruh Pernyataan Saya tersebut benar adanya
            <span></span>
        </label><br />
        <button class='btn btn-danger btn-md {!! $class_btn !!}' disabled>{!! $checked ? 'Sudah Dikirim' : 'Kirim' !!} <span class='far fa-paper-plane'></span>
        </center>
    </div>
</div>
<script src="{!! asset('assets/js/arunika_services.js?q=1') !!}"></script>
<script src="{!! asset('assets/js/fn_arunika.js?q=1') !!}"></script>
