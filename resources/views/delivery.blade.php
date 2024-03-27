@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>Tabel Delivery</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Surat Jalan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Preorder</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Material</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Part</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kg PerPart</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Produksi</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Delivery</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">QC</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated At</th>
                      <th  class="text-secondary opacity-7"></th>
                      @if(auth()->user()->position!='owner')
                      <th rowspan="2" class="text-secondary opacity-7"><a class="btn btn-success btn-md" href="{{ url('delivery_add') }}"><i class="fa fa-plus"></i></a></th>
                      @endif
                      @if(auth()->user()->position!='owner')
                        <a href="{{ route('export-delivery') }}" class="btn btn-primary btn-sm position-relative float-start mx-auto">Export to Excel</a>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($delivery as $del)
                      <tr>
                        <td class="align-middle text-center text-sm">
                          {{ $del->no_surat_jalan }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->no_preorder }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->material->nama_barang }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->jumlah_part }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->kg_perpart }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->customer->nama_customer }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->tanggal_produksi }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->tanggal_delivery }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->qc }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $del->updated_at }}
                        </td>
                        @if(auth()->user()->position!='owner')
                          <td class="align-middle">
                          <a href="{{route('delivery.showdelivery',$del->id_delivery)}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <form method="post" action="{{route('delivery.destroy',$del->id_delivery)}}">
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
