@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Delivery') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{route ('delivery.update',$delivery->id_delivery)}}" method="POST" role="form text-left">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('No Surat Jalan') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" id="number" name="no_surat_jalan" value="{{$delivery->no_surat_jalan}}">
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('No Preorder') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" id="number" name="no_preorder" value="{{$delivery->no_preorder}}">
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Nama Material') }}</label>
                                <div class="@error('email')border border-danger rounded-3 @enderror">
                                    <select name="id_material" class="form-control">
                                        <option value="{{$delivery->material->id_material}}">{{$delivery->material->nama_barang}}</option>
                                        @foreach($material as $mat)
                                            <option value="{{$mat->id_material}}">{{$mat->nama_barang}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Jumlah Part') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="number" id="number" name="jumlah_part" value="{{$delivery->jumlah_part}}">
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Customer') }}</label>
                                <div class="@error('user.location') border border-danger rounded-3 @enderror">
                                    <select name="id_customer" class="form-control">
                                        <option value="{{$delivery->customer->id_customer}}">{{$delivery->customer->nama_customer}}</option>
                                        @foreach($customer as $cus)
                                            <option value="{{$cus->id_customer}}">{{$cus->nama_customer}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Tanggal Produksi') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="date" id="number" name="tanggal_produksi" value="{{$delivery->tanggal_produksi}}">
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Kg PerPart') }}</label>
                                <div class="@error('user.location') border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="number" step="0.01"  id="name" name="kg_perpart" value="{{$delivery->kg_perpart}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Tanggal Delivery') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="date" id="number" name="tanggal_delivery" value="{{$delivery->tanggal_delivery}}">
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Quality Control') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <select name="qc" class="form-control">
                                        <option value="{{$delivery->qc}}">{{$delivery->qc}}</option>
                                        <option value="&#10004;">&#10004;</option>
                                        <option value="&#10006;">&#10006;</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection