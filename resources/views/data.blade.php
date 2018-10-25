<!--
A função URL monta a URL com o IP/porta de destino.
A função csrf_field gera um atributo de segurança que é verificado pelo PHP para garantir que a solicitação não foi efetuada por outro website.
-->
<form action="{{ url('/data/form') }}?a=1&b=2&c=3" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="foo" value="bar" />
    <input type="hidden" name="baz" value="boo" />
    <input type="submit" value="Send" />
</form>