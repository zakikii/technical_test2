@extends('layouts.admin')

@section('title')
    Transaksi
@endsection

@section('content')
<!-- Section Content -->
<div
    class="section-content section-dashboard-home"
    data-aos="fade-up"
    >
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Transaksi</h2>
            <p class="dashboard-subtitle">
                List of Transaction
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Dibuat</th>
                                        <!-- <th>Aksi</th> -->
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('addon-script')
    <script>
        // AJAX DataTablenn
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'transaction.user.name', name: 'transaction.user.name' },
                { data: 'transaction.total_price', name: 'transaction.total_price' },
                { data: 'transaction.transaction_status', name: 'transaction.transaction_status' },
                { data: 'created_at', name: 'created_at' },
                //{
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false,
                //     width: '15%'
                // },
            ]
        });
    </script>
@endpush