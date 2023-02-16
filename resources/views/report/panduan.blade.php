@extends('master')

@push('title')
    Help
@endpush

@section('content')
    <div class="card border-success">
        <div class="card-header bg-success">
            <h4 class="mb-0 text-white">Table of Contents</h4>
        </div>
        <form id="save" enctype="multipart/form-data">
            <div class="card-body">
                <h5>Buku Panduan Pengguna IT Specialist</h5>
                <a href="{{ Storage::url($data[3]->rp_img) }}" target="_blank" class="btn btn-primary">
                    <i class="ti-eye me-1"></i>
                    View
                </a>
                @if (auth()->user()->m_flag == 0)
                    <input type="file" value="null" name="file1[]">
                    <input type="hidden" value="4" name="id_old[]">
                @endif
                <br><br>
                <h5>Buku Panduan Pengguna IT Coordinator</h5>
                <a href="{{ Storage::url($data[2]->rp_img) }}" target="_blank" class="btn btn-primary">
                    <i class="ti-eye me-1"></i>
                    View
                </a>
                @if (auth()->user()->m_flag == 0)
                    <input type="file" value="null" name="file1[]">
                    <input type="hidden" value="3" name="id_old[]">
                @endif
                <br><br>
                <h5>Buku Panduan Pengguna IT Lead</h5>
                <a href="{{ Storage::url($data[1]->rp_img) }}" target="_blank" class="btn btn-primary">
                    <i class="ti-eye me-1"></i>
                    View
                </a>
                @if (auth()->user()->m_flag == 0)
                    <input type="file" value="null" name="file1[]">
                    <input type="hidden" value="2" name="id_old[]">
                @endif
                <br><br>
                <h5>Buku Panduan Pengguna IT Manager</h5>
                <a href="{{ Storage::url($data[0]->rp_img) }}" target="_blank" class="btn btn-primary">
                    <i class="ti-eye me-1"></i>
                    View
                </a>
                @if (auth()->user()->m_flag == 0)
                    <input type="file" value="null" name="file1[]">
                    <input type="hidden" value="1" name="id_old[]">
                    <button class="btn btn-warning save" type="button">
                        <i class="fa fa-upload"></i>
                        Upload
                    </button>
                @endif
                <br><br>
            </div>
        </form>
    </div>
@endsection
