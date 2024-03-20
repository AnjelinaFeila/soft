@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>Tabel Laporan Produksi </h6>
              @if(auth()->user()->position=='admin')
              <a class="btn btn-success btn-md" href="{{ url('laporan_add') }}"><i class="fa fa-plus"></i></a>
              @endif
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Material</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Proses</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tonase</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Sheet</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Operator</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jam Mulai</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jam Selesai</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Jam</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah OK</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah NG</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated At</th>
                      <th  class="text-secondary opacity-7"></th>
                      <th rowspan="2" class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($laporan as $lap)
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $lap->tanggal }}</h6>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->material->nama_barang }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->proses->nama_proses }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->tonase->nama_tonase }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->jumlah_sheet }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->operator->nama_operator }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->jam_mulai }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->jam_selesai }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->jumlah_jam }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->jumlah_ok }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->jumlah_ng }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->keterangan }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $lap->updated_at }}
                        </td>
                        @if(auth()->user()->position=='admin')
                        <td class="align-middle">
                          <a href="{{route('laporan.showlaporan',$lap->id_laporan_produksi)}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <form method="post" action="{{route('laporan.destroy',$lap->id_laporan_produksi)}}">
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
