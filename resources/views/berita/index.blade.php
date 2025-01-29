@extends('layouts.main')

@section('content')
<section class="counts section-bg" style="background-color:#fff;">
    <div class="container">
  
      <div class="section-title">
        <h2>Berita Desa</h2>
      </div>
  
      <div class="row">
        @foreach ($beritas as $berita)
        <div class="col-lg-4 col-md-6 mb-3" data-aos="fade-up">
            <div class="count-box news-card">
                <div class="card" style="border: 2px solid white; border-radius: 15px; overflow: hidden;"> <!-- Inline style for white border and rounded corners -->
                    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" height="300" class="card-img-top" style="border-top-left-radius: 15px; border-top-right-radius: 15px;"> <!-- Image with rounded corners -->
                    <div class="card-body">
                        <h5 class="card-title"><b>{{ $berita->judul }}</b></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-text mb-0">{{ $berita->excerpt }}</p>
                            <a href="/berita/{{ $berita->slug }}" class="btn btn-secondary btn-sm" style="min-width: 100px; text-align: center;background-color:#587187;">Read More</a>
                        </div>
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-between">
                        <small class="news-date">{{ $berita->created_at->diffForHumans() }}</small>
                        <small>Dilihat {{ $berita->views }} kali</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

      {{ $beritas->links() }}

    </div>
  </section>
@endsection