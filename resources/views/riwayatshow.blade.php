@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ ('Show Riwayat Barang') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="/riwayat" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Nomor Preorder') }}</label>
                                <p class="border-bottom">{{$riwayat->nomor_preorder}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Nama Supplier') }}</label>
                                <p class="border-bottom">{{$riwayat->supplier->nama_supplier}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Nomor') }}</label>
                                <p class="border-bottom">{{$riwayat->nomor}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Nomor SO') }}</label>
                                <p class="border-bottom">{{$riwayat->nomor_so}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Tanggal Terima') }}</label>
                                <p class="border-bottom">{{$riwayat->tanggal_terima}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Kode Part') }}</label>
                                <p class="border-bottom">{{$riwayat->kode_part}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Part Number') }}</label>
                                <p class="border-bottom">{{$riwayat->part_number}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Jumlah Part') }}</label>
                                <p class="border-bottom">{{$riwayat->jumlah_part}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="user.location" class="form-control-label">{{ __('Nama Material') }}</label>
                            @foreach($materialIds as $index => $materialId)
                                 @foreach($materials as $mat)
                                    @if($mat->id_material == $materialId)
                                        <p class="border-bottom">{{$mat->nama_barang}}</p>
                                    @endif
                                @endforeach
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ url('riwayat') }}" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Back' }}</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection