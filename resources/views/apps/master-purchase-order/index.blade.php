@extends('partial.app')
@section('title', 'Master Purchase Order')
@section('css')
    <style>
        #tb_wrapper .row:nth-child(2) {
            overflow-x: auto;
        }

        .d-flex .flex-row-item {
            flex: 1 1 30%;
        }

        .text-secondary {
            color: #969DA4 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .btn-secondary {
            background-color: #A5A5A5 !important;
        }

        @media (min-width: 992px) and (max-width: 1200px) {
            .flex-row-item {
                font-size: 12px;
            }

            .grand-text {
                font-size: .9rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Master Purchase Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Dono</th>
                                        <th scope="col" class="text-center">Tgl</th>
                                        <th scope="col" class="text-center">Expired</th>
                                        <th scope="col" class="text-center">Tipe</th>
                                        <th scope="col" class="text-center">Supplier</th>
                                        <th scope="col" class="text-center">Item</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center" style="width: 22%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('js')
    <script>

    </script>
@endsection
