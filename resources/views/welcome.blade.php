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

    {{-- <div>
        <form action="/send" method="post" id="form">
            @csrf
            <div>
                <textarea name="body" id="text-area" placeholder="Write a message" rows="5" cols="30"></textarea>
                <input type="submit" value="Send">
            </div>
        </form>
    </div> --}}

    <footer class="footer">
        <small><i>app by <strong>Bonstana</strong></i></small>
    </footer>
@endsection