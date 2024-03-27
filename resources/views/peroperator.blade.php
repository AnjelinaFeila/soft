@extends('layouts.user_type.auth')

@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          @if(session('success'))
              <div class="m-3  alert alert-danger alert-dismissible fade show" id="alert-success" role="alert">
                  <span class="alert-text text-white">{{ session('success') }}</span>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                  </button>
              </div>
          @endif
          <div class="card mb-4">
            <div class="card-header">
              <h6>Tabel {{$op->operator->nama_operator}}</h6>
              @if(auth()->user()->position!='owner')
              <a href="{{route('export-peroperator',$op->id_operator)}}" class="btn btn-primary btn-sm position-relative float-start mx-auto">Export to Excel</a>
              @endif
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Operator</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Material</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Proses</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tonase</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target PCs/jam</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jam Mulai</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jam Selesai</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Jam</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Sheet</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah OK</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah NG</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Target</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">+/-</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($laporan as $report)
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $report->operator->nama_operator }}</h6>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->tanggal }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->Material->nama_barang }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->Proses->nama_proses }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->Tonase->nama_tonase }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->Target->minimal_target }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->jam_mulai }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->jam_selesai }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->jumlah_jam }}
                        </td>
                        <td class="align-middle text-center text-sm">
                            {{ $report->jumlah_sheet }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->jumlah_ok }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->jumlah_ng }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          @php
                            $targetPerWorkingHour = ($report->target->minimal_target / 60) * (Carbon\Carbon::parse($report->jumlah_jam)->hour * 60 + Carbon\Carbon::parse($report->jumlah_jam)->minute);
                            $selisih=$targetPerWorkingHour-$report->jumlah_ok;
                          @endphp

                          @if($targetPerWorkingHour <= $report->jumlah_ok)
                          &#10004;
                          @else
                          &#10006;
                          @endif
                        </td>
                        <td class="align-middle text-center text-sm">
                          @if($selisih<0)
                          {{$report->jumlah_ok-$targetPerWorkingHour}}
                          @else
                          {{ $selisih }}
                          @endif
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $report->keterangan }}
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