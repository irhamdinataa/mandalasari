@extends('layouts.main')

@section('content')
<style>
    .counts {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .news-header {
        margin-bottom: 30px;
    }

    .news-header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .news-header .news-date {
        font-size: 14px;
        color: #6c757d;
    }

    .news-header .news-date i {
        margin-right: 5px;
    }

    .news-content {
        padding: 20px;
    }

    .news-content img {
        width: 35%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .news-content p {
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .news-content .tags {
        margin-top: 20px;
    }

    .news-content .tags a {
        color: #fff;
        background-color: #007bff;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        margin-right: 5px;
    }

    .news-content .tags a:hover {
        background-color: #0056b3;
    }

    .comment-section {
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .comment-section h4 {
        margin-bottom: 20px;
    }

    .comment-container {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .comment-container:last-child {
        border-bottom: none;
    }

    .comment-avatar img {
        border: 2px solid #dee2e6;
        border-radius: 50%;
    }

    .comment-header h5 {
        margin-bottom: 0;
    }

    .comment-header a {
        color: #007bff;
        text-decoration: none;
    }

    .comment-header a:hover {
        text-decoration: underline;
    }

    .reply-form {
        margin-top: 15px;
    }

    .reply-form .form-control {
        border-radius: 5px;
    }

    @media (max-width: 768px) {
        .col-lg-8 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    .news-header {
    padding: 20px;
    border-bottom: 1px solid #dee2e6;
    }
    .news-title {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 10px;
    }
    .news-details {
    font-size: 1rem;
    color: #6c757d;
    }
    .news-details span {
    display: flex;
    align-items: center;
    }
    .news-details i {
    margin-right: 5px;
    font-size: 1.25rem;
    }
    .news-date, .news-author, .news-views {
    margin-right: 15px;
    }
    .news-date:last-child, .news-author:last-child, .news-views:last-child {
    margin-right: 0;
    }

</style>

<section class="counts section-bg" >
    <div class="container" style="background-color:#fff;border-radius: 10px;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="row">
            <div class="col-lg-12">
                <div class="news-header">
                    <h1 class="news-title">{{ $berita->judul }}</h1>
                    <div class="news-details d-flex align-items-center">
                        <span class="news-date mr-3">
                            <i class="bi bi-stopwatch-fill"></i> {{ $berita->created_at->diffForHumans() }}
                        </span>
                        {{-- <span class="news-author mr-3">
                            <i class="bi bi-person-fill"></i> {{ $berita->user->name }}
                        </span> --}}
                        <span class="news-views">
                            <i class="bi bi-eye-fill"></i><small>Dibaca {{ $berita->views }} Kali </small> 
                        </span>
                    </div>
                </div>
                

                <div class="news-content">
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Berita" class="img-fluid" style="max-width: 80%; height: auto;">
                    </div>
                    <p class="lead">{!! $berita->body !!}</p>

                    <div class="tags">
                        <i class="bi bi-tags"></i> 
                        <button href="#" class="btn btn-secondary btn-sm my-2">{{ $berita->kategori->kategori }}</button>
                    </div>
                </div>

                <div class="comment-section">
                    <h4>Komentar</h4>

                    @foreach ($berita->comments as $comment)
                        @php
                            $emailHash = md5(strtolower(trim($comment->email)));
                            $avatarUrl = "https://www.gravatar.com/avatar/{$emailHash}?s=65";
                        @endphp

                        <div class="comment-container mb-4 d-flex align-items-start">
                            <div class="comment-avatar me-3">
                                <img class="rounded-circle shadow-1-strong" src="{{ $avatarUrl }}" alt="Avatar" width="45" height="45">
                            </div>
                            <div class="comment-content flex-grow-1">
                                <div class="comment-header d-flex justify-content-between align-items-center">
                                    <h5>{{ $comment->nama }}</h5>
                                    <a href="javascript:void(0)" onclick="toggleReplyForm({{ $comment->id }})" class="reply"><i class="bi bi-reply-fill"></i> Balas</a>
                                </div>
                                <time datetime="2020-01-01" class="text-muted">{{ $comment->created_at->diffForHumans() }}</time>
                                <p class="mt-2">{{ $comment->body }}</p>
                            </div>
                        </div>

                        <!-- Comment Reply -->
                        @foreach ($comment->replies as $reply)
                            @php
                                $replyEmailHash = md5(strtolower(trim($reply->email)));
                                $replyAvatarUrl = "https://www.gravatar.com/avatar/{$replyEmailHash}?s=65";
                            @endphp
                            <div class="comment-container my-4 ms-5 d-flex align-items-start">
                                <div class="comment-avatar me-3">
                                    <img class="rounded-circle shadow-1-strong" src="{{ $replyAvatarUrl }}" alt="Avatar" width="65" height="65">
                                </div>
                                <div class="comment-content flex-grow-1">
                                    <div class="comment-header d-flex justify-content-between align-items-center">
                                        <h5>{{ $reply->nama }}</h5>
                                    </div>
                                    <time datetime="2020-01-01" class="text-muted">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</time>
                                    <p class="mt-2">{{ $reply->body }}</p>
                                </div>
                            </div>
                        @endforeach

                        <!-- Comment Reply Form -->
                        <div id="replyForm{{ $comment->id }}" class="reply-form mb-3" style="display: none;">
                            <form action="/berita/{{ $berita->slug }}/reply" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $comment->id }}" name="comment_id">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Nama" name="replyNama">
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Email" name="replyEmail">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" placeholder="Balasan Komentar" name="replyBody" rows="3"></textarea>
                                </div>
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <button type="submit" class="btn btn-secondary btn-sm">Kirim Balasan</button>
                            </form>
                        </div>
                    @endforeach

                    <div class="card">
                        <div class="card-body">
                            {{-- <h5 class="mb-4">Tinggalkan Komentar : </h5> --}}
                            <form method="POST" action="/berita/{{ $berita->slug }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="body" class="form-label">Komentar</label>
                                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="6"></textarea>
                                    @error('body')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-secondary float-end">Kirim Komentar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleReplyForm(commentId) {
        var replyForm = document.getElementById('replyForm' + commentId);
        var formDisplayStyle = window.getComputedStyle(replyForm).getPropertyValue('display');
        if (formDisplayStyle === 'none') {
            replyForm.style.display = 'block';
        } else {
            replyForm.style.display = 'none';
        }
    }
</script>

@endsection
