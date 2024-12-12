<div class='card card-custom'>
    <div class="card-body">
        <div class="row">
            <div class='col-md-12 mb-5'>
                <h5>{!! $title !!}</h5>
                <span style='color:grey;'>{!! $keterangan_title !!}</span>
            </div>
            <div class='col-md-12'>
                <table class="table">
                    <tr>
                        <th>Data Penulis</th>
                        <th>Judul</th>
                        <th>Tahapan</th>
                        <th>#</th>
                    </tr>
                    @if($jumlah === 0)
                        <tr>
                            <td colspan="3">Tidak ada data</td>
                        </tr>
                    @else
                        @foreach($data as $list_data)
                            @php
                                if($target === 'artikel_baru'){
                                    $end_point=Crypt::encrypt($list_data['id']);
                                }else{
                                    $end_point="";
                                    $target=Crypt::encrypt($list_data['id']);
                                }
                            @endphp
                            <tr>
                                <td>
                                    <b>{!! $list_data['nama'] !!}</b><br />
                                    <span style='color:green;font-size:1rem'>{!! $list_data['jabatan'] !!}</span><br />
                                    <span style='color:orange;font-size:1rem'>{!! $list_data['satker'] !!}</span>
                                </td>
                                <td>
                                    {!! $list_data['judul'] !!}
                                    <br />
                                    {!! $list_data['name'] === null ? "" : "<span style='color:green;font-weight:bold;font-size:1rem'>Tema : ".$list_data['name']."</span>" !!}
                                </td>
                                <td class='mt-6'><b>{!! $list_data['step_text'] !!}</b></td>
                                <td><button class='btn btn-success btn-sm {!! $class !!}' data-target="{!! $target !!}" data-endpoint="{!! $end_point !!}" type='button' style='border-radius:10%'><span class='fas fa-edit'></span> Detil</button></td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
    </div>
</div>
<script src="{!! asset('assets/js/arunika_services.js') !!}"></script>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>