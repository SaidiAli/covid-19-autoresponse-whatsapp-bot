@extends('layout.app')

@section('home')
    <div class="title m-b-md">
        WCB
    <p>Whatsapp Covid Bot</p>
    </div>

    <div>
        <a class="link-btn" href="/updates">Send a Message!!!</a>
    </div>

    <div style="margin-top: 5rem;">
        <a class="link-btn" href="/news">Send News!!!</a>
    </div>

    <footer class="footer">
        <small><i>app by <strong>Bonstana</strong></i></small>
    </footer>
@endsection