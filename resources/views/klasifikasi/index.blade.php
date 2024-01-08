@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}</div>
    @endif
    @if (Session::get('deleted'))
        <div class="alert alert-warning"> {{ Session::get('deleted') }}</div>
    @endif

    <h3 style="">Data Klasifikasi</h3>

    <div class="d-flex">
        <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/home">Home /</a></h6>
        <h6><a class="nav-link text-primary" href="">Data Klasifikasi</a></h6>
    </div>

    <div class="container bg-light p-5" style="border-radius: 10px;">

        <a href="{{ route('klasifikasi.create') }}" type="submit" class="btn" style="background-color:grey; color:aliceblue; margin-bottom:10px; margin-top:30px;">TambahSurat</a>
        <a href="{{ route('klasifikasi.download-excel') }}" class = "btn" style="background-color:grey; color:aliceblue; margin-bottom:10px; margin-top:30px;">Export Excel</a>

        <table class="table table-striped table-bordered tabel-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Surat</th>
                    <th>Klasifikasi Surat</th>
                    <th>Surat Tertaut</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @php $no = 1; @endphp
                @foreach ($letterTypes as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->letter_code }}-@if (isset($letterCounts[$item->id]))
                                {{ $letterCounts[$item->id] }}
                            @else
                                0
                            @endif
                        </td>
                        <td>{{ $item['name_type'] }}</td>
                        <td>
                            @if (isset($letterCounts[$item->id]))
                                {{ $letterCounts[$item->id] }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('klasifikasi.detail', $item['id']) }}" class="nav-link mt-1 text-primary"
                                style="margin-right: 5px;">Lihat</a>
                            <a href="{{ route('klasifikasi.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                            <button type="submit" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-{{ $item->id }}">
                                Hapus
                            </button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="exampleModal-{{ $item->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('klasifikasi.delete', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
