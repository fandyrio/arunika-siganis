<div class='card card-custom'>
    <div class="card-body">
        <div class="row">
            <div class='col-md-12'>
                <h5>Form New Artikel</h5>
            </div>
            <div class='col-md-12'>
                @php $no=1 @endphp
                <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active tabs data_pribadi" data-target="data_pribadi" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">{!! $no !!}. Data Pribadi</button>
                        @php $no++ @endphp
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tabs artikel" id="profile-tab" data-target="artikel" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">{!! $no !!}. Artikel</button>
                        @php $no++ @endphp
                    </li>
                    @if($jumlah_review > 0)
                        @php $no=3; @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabs review" id="profile-tab" data-target="review-author" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">{!! $no !!}. Review Artikel</button>
                        </li>
                        @php $no++ @endphp
                    @else
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabs confirmation_form" data-target="confirmation" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! $no !!}. Confirmation</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabs finish" data-target="finish" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">4. Finish</button>
                        </li>
                    @endif
                    @if($step === 6 || $step === 7)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tabs finish" data-target="finish" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">{!! $no++ !!}. Publish Data</button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content tab-content-artikel pt-2" id="borderedTabContent">
                    <div class="tab-pane fade show active form_view" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type='hidden' class='required_field token_a' name='token_a' value='{!! $id_artikel !!}'>
<div class="modal fade" id="modal-data" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-data" aria-hidden="true" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-data-content">
            test
        </div>
    </div>
</div>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/arunika_services.js?q=1') !!}"></script>
<script>
    // setTimeout(function(){
    //     loadDataPribadi();
    // }, 4000);
    loadDataPribadi('view');
</script>