<?php

namespace App;

use Eloquent;

class Disc extends Eloquent {
    //
    //belongsTo retorna um QueryBuilder pré-configurado com a instrução "select * from "artists" where "artists"."id" = ?".
    //Permite definir no segundo atributo o nome do campo relacionado se este fugir do formato nome_do_campo_id.
    //Exemplo: return $this->belongsTo(Artist::class, 'nome_do_campo_relacionado').
    //
    public function artist() {
        return $this->belongsTo(Artist::class);
    }

    //
    //belongsToMany retorna um QueryBuilder pré-configurado com a instrução "select * from "listeners" inner join "disc_listener" on "listeners"."id" = "disc_listener"."listener_id" where "disc_listener"."disc_id" = ?".
    //A diferença para belongsTo é que belongsToMany efetua a consulta com base na tabela associativa.
    //Permite definir nos demais atributos o nome da tabela associativa e o nome dos campos de relacionamento.
    //Exemplo: return $this->belongsToMany(Listener::class, 'disc_listener', 'disc_id', 'listener_id');
    //
    public function listeners() {
        return $this->belongsToMany(Listener::class);
    }
}