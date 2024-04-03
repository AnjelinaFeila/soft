@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>Tabel Work In Progress</h6>
              @if(auth()->user()->position!='owner')
              <a href="{{ route('export-wip') }}" class="btn btn-primary btn-sm position-relative float-end mx-auto">Export to Excel</a>
              @endif
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Material</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kg Perpart</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Part</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Produksi</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Proses</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated At</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                      @if(auth()->user()->position!='owner')
                      <th rowspan="2" class="text-secondary opacity-7"><a class="btn btn-success btn-md" href="{{ url('wip_add') }}"><i class="fa fa-plus"></i></a></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($workin as $wip)
                      <tr>
                        <td class="align-middle text-center text-sm">
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $wip->material->nama_barang }}</h6>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $wip->material->kg_perpart }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $wip->jumlah_part }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $wip->last_produksi }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $wip->proses->nama_proses }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $wip->updated_at }}
                        </td>
                        @if(auth()->user()->position!='owner')
                        <td class="align-middle">
                          <a href="{{route('wip.showwip',$wip->id_wip)}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <form method="post" action="{{route('wip.destroy',$wip->id_wip)}}">
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
