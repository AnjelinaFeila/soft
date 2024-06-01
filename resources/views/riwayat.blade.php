@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>Tabel Riwayat Barang</h6>
              @if(session('success'))
                <div class="m-3  alert alert-danger alert-dismissible fade show" id="alert-success" role="alert">
                  <span class="alert-text text-white">{{ session('success') }}</span>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                  </button>
                </div>
              @endif
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Suppier</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nomor</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nomor So</th>
                      <th  class="text-secondary opacity-7"></th>
                      <th></th>
                      @if(auth()->user()->position!='owner')
                      <th rowspan="2" class="text-secondary opacity-7"><a class="btn btn-success btn-md" href="{{ url('riwayat_add') }}"><i class="fa fa-plus"></i></a></th>
                      @endif
                      @if(auth()->user()->position!='owner')
                        <form id="export-form" action="{{ route('export-riwayat') }}" method="GET">
                          <input type="month" class="form-control" style="width:20%;" name="date_filter">
                          <button type="submit" class="btn btn-primary mt-2">Export to Excel</button>
                        </form>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($riwayat as $riw)
                      <tr>
                        <td class="align-middle text-center text-sm">
                          {{ $riw->supplier->nama_supplier }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $riw->nomor }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $riw->tanggal_terima }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $riw->nomor_so }}
                        </td>
                        @if(auth()->user()->position!='owner')
                        <td class="align-middle">
                          <a href="{{route('riwayat.riwayatshow',$riw->id_riwayat)}}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-eye"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <a href="{{route('riwayat.showriwayat',$riw->id_riwayat)}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <form method="post" action="{{route('riwayat.destroy',$riw->id_riwayat)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                          </form>
                        </td>
                        @endif
                        
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
