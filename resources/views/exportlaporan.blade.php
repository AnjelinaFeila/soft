@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
                   <a href="{{ route('export-laporan') }}" class="btn btn-primary btn-sm position-relative float-start mx-auto">Export to Excel</a>
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
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $dat)
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $dat->tanggal }}</h6>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->material->nama_barang }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->proses->nama_proses }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->tonase->nama_tonase }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->jumlah_sheet }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->operator->nama_operator }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->jam_mulai }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->jam_selesai }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->jumlah_jam }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->jumlah_ok }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->jumlah_ng }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $dat->keterangan }}
                        </td>
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
