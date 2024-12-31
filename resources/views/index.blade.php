@extends('layouts.main')

@section('content')
    <section id="hero">
        <div class="hero-container">
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

                <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

                <div class="carousel-inner" role="listbox">
                    @foreach ($sliders as $key => $slider)
                        <div class="carousel-item{{ $key === 0 ? ' active' : '' }}"
                            style="background-image: url({{ asset('storage/' . $slider->img_slider) }});">
                            <div class="carousel-container">
                                <div class="carousel-content container">
                                    <h2 class="animate__animated animate__fadeInDown">{{ $slider->judul }}</h2>
                                    <p class="animate__animated animate__fadeInUp">{{ $slider->deskripsi }}</p>
                                    <a href="{{ $slider->link_btn }}"
                                        class="btn-get-started animate__animated animate__fadeInUp scrollto">Baca
                                        Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>

            </div>
        </div>
    </section><!-- End Hero -->

    <!-- ======= Services Section ======= -->
<section id="services" class="services">
  <div class="container" data-aos="fade-up">

    <div class="row">
      <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up">
        <div class="icon"><i class="bi bi-bar-chart-line-fill"></i></div>
        <h4 class="title"><a href="/data-desa">Statistik</a></h4>
      </div>
      <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up">
        <div class="icon"><i class="bi bi-globe-asia-australia"></i></div>
        <h4 class="title"><a href="/peta-desa">Peta Desa</a></h4>
      </div>
      <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up">
        <div class="icon"><i class="bi bi-shop"></i></div>
        <h4 class="title"><a href="/umkm">UMKM Desa</a></h4>
      </div>
      <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up">
        <div class="icon"><i class="bi bi-telephone-forward"></i></div>
        <h4 class="title"><a href="/kontak">Pengaduan</a></h4>
      </div>
    </div>
    
  </div>
</section>

    {{-- <!-- ======= Video Section ======= -->
<section id="services" class="services mx-4">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <h2>Video Profile</h2>
    </div>

    <div class="row">
      <div class="col-lg-10 mx-auto">
        <iframe width="100%" height="500" src="{{ $videoProfil->url_video }}" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</section> --}}


<section class="counts section-bg" style="background-image: url('{{ asset('storage/img-slider/Slide-3.jpg') }}'); background-size: cover; background-position: center; min-height: 400px;">
    <div class="container">
        <div class="section-title">
            <h2 class="text-white">Berita Desa</h2>
        </div>

        <div class="row">
            @foreach ($beritas as $berita)
            <div class="col-lg-4 col-md-6 mb-3" data-aos="fade-up">
                <div class="count-box news-card">
                    <div class="card" style="border: 2px solid white; border-radius: 15px; overflow: hidden;"> <!-- Inline style for white border and rounded corners -->
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" height="120" class="card-img-top" style="border-top-left-radius: 15px; border-top-right-radius: 15px;"> <!-- Image with rounded corners -->
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

            <div class="text-center my-4 d-flex justify-content-end">
                <a class="btn text-white" style="background-color:#587187;" href="/berita" role="button">
                    <i class="bi bi-file-earmark-text"></i> Lihat Berita Lebih Banyak
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
