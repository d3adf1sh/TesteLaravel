{{-- Comentário --}}
<h1>Blade example</h1>
<p>{{ $nome }}</p>
<p>{{ date('d/m/y') }}</p>
@if ($flag)
    <p>Something is true!</p>
@else
    <p>Something is false!</p>
@endif

@if ($animal == 'Red Panda')
    <p>Something is red, white, and brown!</p>
@elseif ($animal == 'Giant Panda')
    <p>Something is black and white!</p>
@else
    <p>Something could be a squirrel.</p>
@endif

@foreach ($nomes as $nome)
    <p>{{ converterParaMaiusculo($nome) }}</p>
@endforeach

@for ($i = 0; $i < 2; $i++)
    <p>Even {{ $i }} red pandas, aren't enough!</p>
@endfor

@php ($i = 0)
@while ($i < 2)
    <p>Even {{ $i }} giant pandas, aren't enough!</p>
    @php($i++)
@endwhile

<p>Even {{ $i }} giant pandas, aren't enough!</p>

<?php echo $squirrel; ?>