@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>All User</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id Pegawai</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Posisi</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Telepon</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created at</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated at</th>
                      <th rowspan="2" class="text-secondary opacity-7"></th>
                      @if(auth()->user()->position=='superadmin')
                      <th rowspan="2" class="text-secondary opacity-7"><a class="btn btn-success btn-md" href="{{ url('add_user') }}"><i class="fa fa-plus"></i></a></th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($user as $us)
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{ $us->name }}</h6>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $us->id_pegawai }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $us->position }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $us->phone }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $us->created_at }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $us->updated_at }}
                        </td>
                        @if(auth()->user()->position=='superadmin')
                        <td class="align-middle">
                          <a href="{{route('user.showuser',$us->id)}}" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <form method="post" action="{{route('user.destroy',$us->id)}}">
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
