<?php

namespace App;

use Eloquent;

class Listener extends Eloquent {
    //
    //belongsToMany retorna um QueryBuilder pré-configurado com a instrução "select * from "discs" inner join "disc_listener" on "discs"."id" = "disc_listener"."disc_id" where "disc_listener"."listener_id" = ?".
    //A diferença para belongsTo é que belongsToMany efetua a consulta com base na tabela associativa.
    //Permite definir nos demais atributos o nome da tabela associativa e o nome dos campos de relacionamento.
    //Exemplo: return $this->belongsToMany(Disc::class, 'disc_listener', 'listener_id', 'disc_id');
    //
    public function discs() {
        return $this->belongsToMany(Disc::class);
    }
}