<h1>Registration form for our club!</h1>
<form action="{{ url('validation/registration') }}" method="POST">
{{ csrf_field() }}

<!--
    "$errors" é uma instância da classe MessageBag conforme https://laravel.com/api/5.4/Illuminate/Support/MessageBag.html.
    -->

    <!--Todas as mensagens-->
    <ul class="errors">
        @foreach($errors->all() as $error)
            <li><p>{{ $error }}</p></li>
        @endforeach
    </ul>

    <!--username-->
    <!--
    <span class="error">{{ $errors->first('username') }}</span>
    -->
    @if($errors->has('username'))
        <small>{{ $errors->first('username') }}</small>
    @endif

    <label for="username">Username</label>
    <input type="text" name="username"/>


    <!--email-->
    <!--
    <span class="error">{{ $errors->first('email') }}</span>
    -->
    @if($errors->has('email'))
        <small>{{ $errors->first('email') }}</small>
    @endif

    <label for="email">Email</label>
    <input type="text" name="email"/>

    <!--password-->
    <!--
    <span class="error">{{ $errors->first('password') }}</span>
    -->
    @if($errors->has('password'))
        <small>{{ $errors->first('password') }}</small>
    @endif

    <label for="password">Password</label>
    <input type="password" name="password"/>

    <!--password_confirmation-->
    <!--
    <span class="error">{{ $errors->first('password_confirmation') }}</span>
    -->
    @if($errors->has('password_confirmation'))
        <small>{{ $errors->first('password_confirmation') }}</small>
    @endif

    <label for="password_confirmation">Password confirmation</label>
    <input type="password" name="password_confirmation"/>

    <input type="submit" value="Register"/>
</form>