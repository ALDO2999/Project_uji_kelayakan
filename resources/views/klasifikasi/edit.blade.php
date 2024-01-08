@extends('layouts.template')

@section('content')


<h3 class="mt-4"> Edit Data Surat</h3>

<div class="d-flex">
    <h6 style="margin-right: 0.4rem;"><a class="nav-link text-secondary" href="/home">Home /</a></h6>
    <h6><a class="nav-link text-secondary" href="{{ route('klasifikasi.index') }}">Data Klasifikasi / </a></h6>
    <h6><a class="nav-link text-primary" href="">Edit Data</a></h6>
</div>
<form action="{{ route('klasifikasi.update', $letterType['id'])}}" method="POST" class="card p-5">
    @csrf
    @method('PATCH')

    @if ($errors->any())
    <ul class="alert alert-danger p-3">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    

    <div class="mb-3 row">
        <label for="letter_code" class="col-sm-2 col-form-label">Kode Surat</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="letter_code" name="letter_code" value="{{ $letterType['letter_code']}}">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="name_type" class="col-sm-2 col-form-label">Klasifikasi Surat</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name_type" name="name_type" value="{{ $letterType['name_type'] }}">
        </div>
    </div>


    <div class="mb-3 row">
        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </div>
   
</form>
@endsection