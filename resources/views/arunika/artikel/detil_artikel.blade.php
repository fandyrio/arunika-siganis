<div class='card card-custom'>
    <div class="card-body">
        <div class="row mb-3">
            <div class='col-md-12'>
                <button class='btn btn-light list_menu' data-target='{!! $target !!}' style='background-color:white;border-color:white;font-size:1.8rem;font-weight:bold;'><span class='fas fa-angle-left' style='cursor:pointer;'></span> Detil Artikel</button>
                <hr />
            </div>
        </div>
        <div class="row mb-6">
            <div class="col-12">
                <ul class="nav nav-tabs nav-pills" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active tabs data_detil_artikel" data-target="data_detil_artikel" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">Detil Artikel</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tabs review" id="profile-tab" data-target="review" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Review</button>
                    </li>
                    <span class='append'>
                    @if($step >= 7)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tabs publsih" data-target="publsih" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Publsih</button>
                    </li>
                    @endif
                    </span>
                </ul>
                <div class="tab-content tab-content-detil-artikel pt-2" id="borderedTabContent">
                    <div class="tab-pane fade show active form_view" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type='hidden' class='required_field token_a' name='token_a' value='{!! $id_artikel !!}'>
<div class="modal fade" id="modal-data-review" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-data" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-data-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
        </div>
    </div>
</div>
<script src="{!! asset('../resources/views/assets/js/arunika_services.js') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>
<script>
    loadDataDetilArtikel();
</script>