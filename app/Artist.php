<?php

namespace App;

use Eloquent;

class Artist extends Eloquent {
    //
    //hasMany retorna um QueryBuilder pré-configurado com a instrução "select * from "discs" where "discs"."artist_id" = ? and "discs"."artist_id" is not null".
    //Permite definir no segundo atributo o nome do campo relacionado se este fugir do formato nome_do_campo_id.
    //Exemplo: return $this->hasMany(Disc::class, 'nome_do_campo_relacionado').
    //
    public function discs() {
        return $this->hasMany(Disc::class);
    }
}