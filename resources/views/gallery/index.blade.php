@extends('layouts.main')

@section('content')
    <section class="counts section-bg" style="background-color:#fff;">
        <div class="section-title">
            <h2>Gallery</h2>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($galerrys as $gallery)
                <div class="col-lg-3">
                    <picture style="display: flex; flex-direction: column; align-items: center;">
                        <img src="{{ asset('storage/' . $gallery->gambar) }}" class="img-fluid img-thumbnail"
                            alt="Gallery" style="width: 300px; height: 200px; object-fit: cover;">
                        <p style="text-align: center; margin-top: 10px;">{{ $gallery->keterangan }}</p>
                    </picture>
                </div>
            @endforeach
            </div>
            <div class="paginate my-3" style="text-align: center">
                {{ $galerrys->links() }}
            </div>
        </div>
    </section>
@endsection
