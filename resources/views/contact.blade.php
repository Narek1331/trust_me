@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h2 class="text-center">
            Обратная связь
        </h2>
    </div>
    <div class="card bg-white">
        <div class="card-body">
            <div class="mb-4">
                <h3 class="fw-bold">Используйте эту форму обратной связи только для следующих случаев:</h3>
                <p>1. Если Вы не можете по какой-то причине зарегистрироваться и ранее не имели регистраций (в письме необходимо указать какая ошибка выдается сервером).</p>
                <p>2. Если Вы нашли ошибку в работе сервиса (в письме обязательно указать свои емаil и ошибку, которую Вы нашли).</p>
                <p>3. По всем вопросам связанным с аккаунтом - указывать Логин. Все письма с заблокированных ip, за нарушение правил нашего сервиса, игнорируются.</p>
            </div>
            <h3 class="fw-bold">Для связи с администрацией сервиса используйте форму ниже:</h3>
            <form action="{{route('feedback.store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="client_login-2" class="form-label">Ваше имя</label>
                    <input type="text" name="name" class="form-control" id="client_login-2" required value="@if(auth()->user() && auth()->user()->name){{auth()->user()->name}}@endif">
                </div>
                <div class="mb-3">
                    <label for="client_email" class="form-label">Ваш E-mail</label>
                    <input type="email" name="email" class="form-control" id="client_email" required value="@if(auth()->user() && auth()->user()->email){{auth()->user()->email}}@endif">
                </div>
                <div class="mb-3">
                    <label for="client_theme" class="form-label">Тема сообщения</label>
                    <input type="text" name="title" class="form-control" id="client_theme" required>
                </div>
                <div class="mb-3">
                    <label for="field" class="form-label">Текст сообщения</label>
                    <textarea name="text" id="field" class="form-control" maxlength="5000" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="captcha-addon">
                            @captcha
                        </span>
                        <input required type="text" class="form-control" aria-describedby="captcha-addon" id="captcha" name="captcha" autocomplete="off">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </div>
</div>
@endsection
