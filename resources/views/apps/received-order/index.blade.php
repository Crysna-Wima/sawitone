@extends('partial.app')
@section('title', 'Received Order')
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pencarian Delivery Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Masukkan Nomor Surat Jalan</label>
                            <input type="text" id="fc_dono" class="form-control">
                        </div>
                    </div>
                    <div class="card-footer bg-smokewhite">
                        <button class="btn btn-primary float-right" id="button_cari" onclick="click_cari_delivery_order()"><i class="fa fa-searach"></i> Cari Delivery Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function click_cari_delivery_order(){
        $('#button_cari').html('<i class="fa fa-refresh fa-spin"></i> Mencari..');
        $('#button_cari').prop('disabled',true);
        var fc_dono = window.btoa($('#fc_dono').val());
        $.ajax({
        url: '/apps/received-order/cari-do/' + fc_dono,
        type: "GET",
        dataType: 'JSON',
        success: function( response, textStatus, jQxhr ){
            $('#button_cari').html('<i class="fa fa-searach"></i> Cari Delivery Order');
            $('#button_cari').prop('disabled',false);

            if(response.status == 201){
                swal(response.message, { icon: 'success', });
                $("#modal").modal('hide');
                location.href = response.link;
            }
            else if(response.status == 300){
                swal(response.message, { icon: 'error', });
            }
        },
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
            console.warn(jqXhr.responseText);
        },
        });
    }
</script>
@endsection
