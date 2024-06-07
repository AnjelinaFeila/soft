@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ ('Add Riwayat Barang') }}</h6>
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
                                <div class="@error('email')border border-danger rounded-3 @enderror">
                                    <input class="form-control" name="nomor_preorder" value="0" type="" id="number" value=" " required>
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Nama Supplier') }}</label>
                                <div class="@error('email')border border-danger rounded-3 @enderror">
                                    <select name="id_supplier" class="form-control">
                                        @foreach($supplier as $sup)
                                            <option value="{{$sup->id_supplier}}">{{$sup->nama_supplier}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Nomor') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" name="nomor" value="0" type="number" id="number" value=" " required>
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Nomor SO') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" name="nomor_so" value="0" type="number" id="number" value=" ">
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
                                <label for="user.phone" class="form-control-label">{{ __('Tanggal Terima') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" name="tanggal_terima" type="date" id="number" value="2024-01-01" required>
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Kode Part') }}</label>
                                <div class="@error('user.location') border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text"  id="name" name="kode_part" value="" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Part Number') }}</label>
                                <div class="@error('user.location') border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text"   id="name" name="part_number" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.location" class="form-control-label">{{ __('Jumlah Part') }}</label>
                                <div class="@error('user.location') border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="number"  value="0"  id="name" name="jumlah_part" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Nama Material') }}</label>
                                <div id="material-selects">
                                    <div class="material-select">
                                        <select name="id_materials[]" class="form-control">
                                            @foreach($material as $mat)
                                                <option value="{{$mat->id_material}}">{{$mat->nama_barang}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="button" id="add-material" class="btn btn-success mt-2"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Jumlah Material') }}</label>
                                <div id="material-amounts">
                                    <div class="material-select">
                                        <input type="number" required="" name="jumlah_barangs[]" class="form-control">
                                    </div>
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
<script>
    document.getElementById('add-material').addEventListener('click', function() {
        var materialSelects = document.getElementById('material-selects');
        var materialAmounts = document.getElementById('material-amounts');

        var newSelect = document.createElement('div');
        newSelect.classList.add('material-select', 'mt-2');
        newSelect.innerHTML = `
            <select name="id_materials[]" class="form-control">
                @foreach($material as $mat)
                    <option value="{{$mat->id_material}}">{{$mat->nama_barang}}</option>
                @endforeach
            </select>`;

        var newAmount = document.createElement('div');
        newAmount.classList.add('material-amount', 'mt-2');
        newAmount.innerHTML = `
            <input type="number" name="jumlah_barangs[]" class="form-control" placeholder="" required="">`;
        
        materialAmounts.appendChild(newAmount);
        materialSelects.appendChild(newSelect);
    });
</script>
@endsection