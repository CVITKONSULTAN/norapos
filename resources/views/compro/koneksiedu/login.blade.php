@extends('compro.koneksiedu.layouts.app')

@push('styles')
    <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <style>
        section#login_comp {
            padding: 8rem 1rem 2rem 1rem;
            background: rgb(55 55 203 / 62%);
        }
    </style>
@endpush

@section('main')
    <section id="login_comp">
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    Silahkan login dibawah ini
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="login-form">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <input class="form-control" 
                          placeholder="username"
                          name="username"
                          required
                          />
                        </div>
                        <div class="form-group mt-3">
                          <input class="form-control" 
                          placeholder="password"
                          name="password"
                          required
                          type="password"
                          />
                        </div>
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary btn-block">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush