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
              <h6>Tabel Material</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kg Persheet</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kg Perpart</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ukuran</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Supplier</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated At</th>
                      <th  class="text-secondary opacity-7"></th>
                      @if(auth()->user()->position=='admin')
                      <th rowspan="2" class="text-secondary opacity-7"><a class="btn btn-success btn-md" href="{{ url('material_add') }}"><i class="fa fa-plus"></i></a></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($material as $mat)
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $mat->nama_barang }}</h6>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $mat->kg_persheet }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $mat->kg_perpart }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $mat->ukuran }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $mat->supplier->nama_supplier }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $mat->customer->nama_customer }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $mat->updated_at }}
                        </td>
                        @if(auth()->user()->position=='admin')
                        <td class="align-middle">
                          <a href="{{route('materials.showmat',$mat->id_material)}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <form method="post" action="{{route('materials.destroy',$mat->id_material)}}">
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
