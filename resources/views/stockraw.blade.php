@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>Tabel Stock Raw</h6>
              <a href="{{ route('export-stockraw') }}" class="btn btn-primary btn-sm position-relative float-end mx-auto">Export to Excel</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Nama Material</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Preorder</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Sheet</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah PartperSheet</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kg PerSheet</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ukuran</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Nutt</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Supplier</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated At</th>
                      <th  class="text-secondary opacity-7"></th>
                      @if(auth()->user()->position!='owner')
                      <th rowspan="2" class="text-secondary opacity-7"><a class="btn btn-success btn-md" href="{{ url('stockraw_add') }}"><i class="fa fa-plus"></i></a></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($stockraw as $stock)
                      <tr>
                        <td class="align-middle text-center text-sm">
                            <h6 class="mb-0 text-sm">{{ $stock->material->nama_barang }}</h6>
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->no_preorder }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->jumlah_sheet }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->jumlah_sheet*$stock->material->jumlah_persheet }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->kg_persheet }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->material->ukuran }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->jumlah_nutt }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->supplier->nama_supplier }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->customer->nama_customer }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $stock->updated_at }}
                        </td>
                        @if(auth()->user()->position!='owner')
                        <td class="align-middle">
                          <a href="{{route('stock.showstock',$stock->id_stock_raw)}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <form method="post" action="{{route('stock.destroy',$stock->id_stock_raw)}}">
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
