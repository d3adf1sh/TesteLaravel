<?php

/*
Route::put();
Route::patch();
Route::delete();
Route::any();
*/

//
//Rota básica
//
Route::get('/', function() {
    return View::make('simple');
});

Route::get('/books', function() {
    return 'Books index.';
});

//
//Parametrização
//
Route::get('/books/{genre}/{optional?}', function($genre, $optional = null) {
    return "Books in the <b>{$genre}</b> category. Additional: " . ($optional != null ? $optional : 'Nothing.');
});

Route::get('/parametrized/{first}/{second?}', function($first, $second = 'N/A') {
    $data['first'] = $first;
    $data['second'] = $second;
    return View::make('parametrized', $data);
});

//
//Redirecionamento
//
Route::get('redirect/first', function() {
    return Redirect::to('redirect/second');
});

Route::get('redirect/second', function() {
    return 'Second!';
});

//
//Customização do header e do código de retorno
//
Route::get('custom/response', function() {
    $response = Response::make('Hello world!', 200);
    $response->headers->set('Chave', 'Valor');
    return $response;
});

Route::get('markdown/response', function () {
    $response = Response::make('Some bold text.', 200);
    $response->headers->set('Content-Type', 'text/x-markdown');
    return $response;
});

Route::get('our/response', function () {
    $response = Response::make('Bond, James Bond.', 200);
    $response->setTtl(60);
    return $response;
});

//
//Retorno em JSON
//
Route::get('json/response', function () {
    $data = ['iron', 'man', 'rocks'];
    return Response::json($data);
});

//
//Download
//
Route::get('file/download', function () {
    $file = '/home/rafael/Desktop/Facility/Code Smart.pdf';
    return Response::download($file, 'CodeSmart.pdf', ['header1' => 'iron', 'header2' => 'man']);
});

//
//Blade
//
Route::get('blade/example', function () {
    $data['nome'] = 'Teste';
    $data['squirrel'] = 'That\'s it.';
    $data['flag'] = true;
    $data['animal'] = 'Giant Panda';
    $data['nomes'] = ['Ana', 'Maria', 'Paula'];
    return view('example', $data);
});

Route::get('blade/body', function () {
    return view('body');
});

Route::get('blade/inheritance', function () {
    return view('inheritance');
});

//
//Parâmetros
//
Route::get('data/getParameters', function () {
    //http://128.127.1.156:8080/data/getParameters?a=1 -> 1
    //http://128.127.1.156:8080/data/getParameters?x=1 -> 0
    $data = Request::get('a', '0');
    var_dump($data);
});

Route::get('data/hasParameter', function () {
    //http://128.127.1.156:8080/data/hasParameter?a=1 -> true
    //http://128.127.1.156:8080/data/hasParameter?x=1 -> false
    $data = Request::has('a');
    var_dump($data);
});

Route::get('data/onlyParameters', function () {
    //http://128.127.1.156:8080/data/onlyParameters?a=1&b=2&c=3&d=4
    $data = Request::only('a', 'c');
    var_dump($data);
});

Route::get('data/exceptParameters', function () {
    //http://128.127.1.156:8080/data/exceptParameters?a=1&b=2&c=3&d=4
    $data = Request::except('a', 'c');
    var_dump($data);
});

Route::get('data/allParameters', function () {
    $data = Request::all();
    var_dump($data);
});

//
//Formulário
//
Route::get('data/form', function () {
    return view('data');
});

Route::post('data/form', function () {
    $data = Request::all();
    var_dump($data);
});

//
//Redirecionamento com reenvio de parâmetros
//
Route::get('data/redirect/from_1', function() {
    //
    //Redireciona apenas os parâmetros da URL.
    //
    //Exemplo: http://128.127.1.156:8080/data/redirect/from_1?a=1&b=2&c=3&d=4.
    //
    Request::flash();
    //Request::flashOnly('b');
    //Request::flashExcept('b');
    return Redirect::to('data/redirect/to');
});

Route::get('data/redirect/from_2', function() {
    //
    //Redireciona os parâmetros da URL e o formulário.
    //withInput efetua o envio do formulário e permite a omissão do Request::flash();
    //As restrições flashOnly() e flashExcept() podem ser feitas através de argumento para o withInput com
    //Request::only() e Request::except().
    //
    //Exemplo: http://128.127.1.156:8080/data/redirect/from_2?a=1&b=2&c=3&d=4.
    //
    return Redirect::to('data/redirect/to')->withInput();
    //return Redirect::to('data/redirect/to')->withInput(Request::only('b'));
    //return Redirect::to('data/redirect/to')->withInput(Request::except('b'));
});

Route::get('data/redirect/to', function() {
    var_dump(Request::old());
    //var_dump(Request::old('a'));
});

//
//Upload
//
Route::get('data/upload', function () {
    return View::make('upload');
});

Route::post('data/upload', function () {
    $file = Request::file('file'); //retorna uma instância de UploadedFile
    $file->move('/home/rafael/Desktop/Facility/TesteLaravel/storage', $file->getClientOriginalName());
    return 'File was moved.';
});

//
//Cookies
//
Route::get('cookie/create', function () {
    $cookie = Cookie::make('cookie-test', 'almond cookie', 30);
    return Response::make('Created.')->withCookie($cookie);
});

Route::get('cookie/createForever', function () {
    $cookie = Cookie::forever('cookie-test', 'almond cookie');
    return Response::make('Created.')->withCookie($cookie);
});

Route::get('cookie/read', function () {
    $cookie = Cookie::get('cookie-test', 'default');
    var_dump($cookie);
});

Route::get('cookie/check', function () {
    var_dump(Cookie::has('cookie-test'));
});

Route::get('cookie/forget', function () {
    $cookie = Cookie::forget('cookie-test');
    return Response::make('Forgeted.')->withCookie($cookie);
});

///
///Rotas com nome.
///
Route::get('advanced/redirect/from', function() {
    return Redirect::route('redirect_to_route');
});

Route::get('advanced/redirect/to', ['as' => 'redirect_to_route', function() {
    return View::make('redirect_to');
}]);

//
//Consistência de argumentos.
//A rota não é executada caso as condições não sejam atentidas.
//
Route::get('validation/{nome}/{cpf}', function($nome, $cpf) {
    return "Nome: {$nome}; CPF: {$cpf}";
})->where('nome', '[A-Za-z]+')
    ->where('cpf', '[0-9]+');

//
//Agrupamento de rotas por prefixo
//
Route::group(['prefix' => 'group'], function () {
    //http://192.168.15.10:8080/group/third
    Route::get('/first', function () {
        return 'The Colour of Magic';
    });

    //http://192.168.15.10:8080/group/second
    Route::get('/second', function () {
        return 'Reaper Man';
    });

    //http://192.168.15.10:8080/group/third
    Route::get('/third', function () {
        return 'Lords and Ladies';
    });
});

//
//Agrupamento de rotas por domínio: Exemplo: Route::group(['domain' => 'myapp.dev'], function() {...
//Partes do domínio podem ser capturadas e direcionadas para as rotas. Exemplo:
//    Route::group(['domain' => '{user}.myapp.dev'], function () {
//        Route::get('profile/{page}', function($user, $page) {
//        });
//    });
//

//
//Ligação de rota à controlador
//
Route::get('article', 'ArticleController@index');
Route::get('article/show/{articleID}', 'ArticleController@show');

//
//Ligação de rota à um controlador de resource
//
Route::resource('panda', 'PandaController');

//
//Geração de URLs para rotas.
//
Route::get('the/{first}/avenger/{second}', [
    'as' => 'ironman',
    function($first, $second) {
        return "Tony StarkController, the {$first} avenger {$second}.";
    }
]);

Route::get('tony/the/{first}/genius', 'StarkController@tony');

Route::get('/url/routes', function () {
    //
    //Ao gerar a partir de um nome (route()), o laravel injeta os argumentos que houverem nos espaços da URL. Se não houverem
    //espaços ou houverem argumentos excedentes, os argumentos são acrescentados ao final da URL. Exemplo:
    //1) URL::route('ironman', ['best', 'ever'])
    //   http://128.127.1.156:8080/the/best/avenger/ever
    //
    //2) URL::route('ironman', ['best', 'ever', 'a' => 1, 'b' => 2])
    //   http://128.127.1.156:8080/the/best/avenger/ever?a=1&b=2
    //
    $rotas = URL::to('another/route') . PHP_EOL .
             URL::to('another/route', ['foo', 'bar']) . PHP_EOL .
             URL::to('another/route', ['foo', 'bar'], true) . PHP_EOL .
             URL::secure('another/route') . PHP_EOL .
             URL::secure('another/route', ['foo', 'bar']) . PHP_EOL .
             URL::route('redirect_to_route') . PHP_EOL .
             URL::route('ironman', ['best', 'ever']) . PHP_EOL .
             URL::route('ironman', ['best', 'ever', 'a' => 1, 'b' => 2]) . PHP_EOL .
             URL::action('StarkController@tony', ['narcissist']);
    return $rotas;
});

//
//Geração de URLs para assets.
//
Route::get('/url/assets', function () {
    //
    //URL::asset pode ser substituído por asset()
    //URL::secureAsset pode ser substituido por secure_asset()
    //
    $rotas = URL::asset('img/logo.png') . PHP_EOL .
        URL::asset('img/logo.png', true) . PHP_EOL .
        URL::secureAsset('img/logo.png');
    return $rotas;
});

//
//Schema
//

#
# Incluir, renomear, alterar e excluir uma tabela
#
Route::get('/schema/createUsers', function() {
    //
    //O Schema permite a execução em uma conexão específica através de "Schema::connection('XXX')->...".
    //$table (BluePrint): /vendor/laravel/framework/src/Illuminate/Database/Schema/Blueprint.php
    //
    Schema::create('users', function($table) {
        $table->increments('id'); //integer//users_pkey//users_id_seq
        $table->string('username', 32); //varchar
        $table->string('login', 15); //varchar
        $table->string('email', 320); //varchar
        $table->string('password', 60); //varchar
        $table->timestamps(); //varchar
    });
});

Route::get('/schema/renameUsers', function() {
    Schema::rename('users', 'users_renamed');
});

Route::get('/schema/modifyRenamedUsers', function() {
    Schema::table('users_renamed', function($table) {
        //
        //Renomear coluna.
        //
        $table->renameColumn('username', 'nome');

        //
        //Alterar o tamanho da coluna.
        //
        $table->string('login', 50)->change();

        //
        //Novo campo.
        //
        $table->string('novo_campo', 32);

        //
        //Exclusão de campos.
        //Podemos passar um array: $table->dropColumn(['email', 'password']);
        //
        $table->dropColumn('email');
        $table->dropColumn('password');
    });
});

Route::get('/schema/dropRenamedUsers', function() {
    //
    //Ou Schema::dropIfExists.
    //
    Schema::drop('users_renamed');
});

#
# Tipos de dado.
#
Route::get('/schema/fieldsTest', function() {
    //
    //Sem citação:
    //
    //table->char('name', 4);
    //$table->double('column', 15, 8);
    //$table->json('options');
    //$table->jsonb('options');
    //$table->longText('description');
    //$table->morphs('taggable');
    //$table->nullableTimestamps();
    //$table->text('description');
    //$table->timestamp('added_on');
    //
    Schema::create('fields', function($table) {
        //
        //auto-increment
        //Gera um campo inteiro com sequência e chave.
        //Apenas um por tabela.
        //A sequência é gerada no formato [tabela]_[campo]_seq (exemplo fields_auto_incremento_grande_seq).
        //A chave é gerada no formato [tabela]_pkey (exemplo fields_pkey).
        //
        $table->bigIncrements('auto_incremento_grande'); //bigint

        //string
        $table->string('texto', 32); //varchar

        //
        //integer
        //O segundo argumento indica se o campo é auto-incremento.
        //O terceiro argumento indica se o campo é unsigned (inteiros "unsigned" podem ser apenas positivos).
        //
        $table->integer('inteiro'); //integer
        $table->integer('inteiro_positivo_negativo', false, false); //integer
        $table->integer('inteiro_positivo', false, true); //integer

        //big-integer
        $table->bigInteger('inteiro_longo'); //biginteger
        $table->bigInteger('inteiro_longo_positivo_negativo', false, false); //biginteger
        $table->bigInteger('inteiro_longo_positivo', false, true); //biginteger

        //medium-integer
        $table->mediumInteger('inteiro_medio'); //integer
        $table->mediumInteger('inteiro_medio_positivo_negativo', false, false); //integer
        $table->mediumInteger('inteiro_medio_positivo', false, true); //integer

        //small-integer
        $table->smallInteger('inteiro_pequeno'); //smallint
        $table->smallInteger('inteiro_pequeno_positivo_negativo', false, false); //smallint
        $table->smallInteger('inteiro_pequeno_positivo', false, true); //smallint

        //tiny-integer
        $table->tinyInteger('inteiro_curto'); //smallint
        $table->tinyInteger('inteiro_curto_positivo_negativo', false, false); //smallint
        $table->tinyInteger('inteiro_curto_positivo', false, true); //smallint

        //float
        $table->float('float_8_2', 8, 2); //double precision
        $table->float('float_18_4', 18, 4); //double precision

        //decimal
        $table->decimal('decimal_8_2', 8, 2); //numeric
        $table->decimal('decimal_18_4', 18, 4); //numeric

        //boolean
        $table->boolean('flag'); //boolean

        //enumerações
        $table->enum('tipo', ['a', 'b', 'c']); //varchar(255)

        //date
        $table->date('data'); //date

        //date_time_
        $table->dateTime('data_hora'); //timestamp

        //time
        $table->time('hora'); //time

        //binary
        $table->binary('imagem'); //bytea

        //timestamps()
        //created_at/updated_at
        $table->timestamps(); //timestamp

        //softDeletes()
        //deleted_at
        $table->softDeletes(); //timestamp
    });
});

#
# Chave primária, chave única e índice.
#
Route::get('/schema/modifiersTest_1', function() {
    Schema::create('modifiers_1', function($table) {
        //
        //Chave primária
        //Gera a PK modifiers_1_pkey.
        //
        $table->string('cpf', 15)->primary();

        //
        //Chave única
        //Gera a UK modifiers_1_cns_unique.
        //
        $table->string('cns', 15)->unique();

        //
        //Indexado
        //Gera o índice modifiers_1_nome_index
        //
        $table->string('nome', 50)->index();
    });
});

#
# Chave primária, chave única e índice com múltiplos campos.
#
Route::get('/schema/modifiersTest_2', function() {
    Schema::create('modifiers_2', function($table) {
        //
        //Múltiplos campos na chave primária
        //Gera a PK modifiers_2_pkey.
        //
        $table->string('cpf', 15);
        $table->string('cns', 15);
        $table->primary(['cpf', 'cns']);

        //
        //Múltiplos campos na chave única
        //Gera a UK modifiers_2_unico_1_unico_2_unique.
        //
        $table->string('unico_1', 10);
        $table->string('unico_2', 10);
        $table->unique(['unico_1', 'unico_2']);

        //
        //Múltiplos campos indexados
        //Gera o índice modifiers_2_nome_cidade_index.
        //
        $table->string('nome', 50);
        $table->string('cidade', 50);
        $table->index(['nome', 'cidade']);
    });
});

#
# Exclusão de chaves e índices.
#
Route::get('/schema/dropModifiersTest_2Constraints', function() {
    Schema::table('modifiers_2', function($table) {
        //
        //Exclusão da chave primária.
        //
        $table->dropPrimary();

        //
        //Exclusão de chave única.
        //Através de um array com o nome dos campos.
        //Podemos usar opcionalmente o nome da chave: $table->dropUnique('modifiers_2_unico_1_unico_2_unique');
        //
        $table->dropUnique(['unico_1', 'unico_2']);

        //
        //Exclusão de índice.
        //Através de um array com o nome dos campos.
        //Podemos usar opcionalmente o nome do índice: $table->dropIndex('modifiers_2_nome_cidade_index');
        //
        $table->dropIndex(['nome', 'cidade']);
    });
});

#
# Relacionamento.
#
Route::get('/schema/relationships_1', function() {
    Schema::create('categories', function($table) {
        //
        //Gera a PK categories_pkey.
        //
        $table->integer('code')->primary();
        $table->string('description', 50);
    });

    Schema::create('clients', function($table) {
        //
        //Gera a PK clients_pkey.
        //Gera a FK clients_category_code_foreign.
        //Aceita "...onDelete('cascade')".
        //
        $table->integer('code')->primary();
        $table->string('name', 50);
        $table->integer('category_code');
        $table->foreign('category_code')->references('code')->on('categories');
    });
});

#
# Relacionamento com múltiplos campos.
#
Route::get('/schema/relationships_2', function() {
    Schema::create('categories_2', function($table) {
        //
        //Gera a PK categories_2_pkey.
        //
        $table->integer('code_1');
        $table->integer('code_2');
        $table->primary(['code_1', 'code_2']);
        $table->string('description', 50);
    });

    Schema::create('clients_2', function($table) {
        //
        //Gera a PK clients_2_pkey.
        //Gera a FK clients_2_category_code_1_category_code_2_foreign.
        //Aceita "...onDelete('cascade')".
        //
        $table->integer('code')->primary();
        $table->string('name', 50);
        $table->integer('category_code_1');
        $table->integer('category_code_2');
        $table->foreign(['category_code_1', 'category_code_2'])->references(['code_1', 'code_2'])->on('categories_2');
    });
});

#
# Exclusão de relacionamentos.
#
Route::get('/schema/dropRelationships_2', function() {
    Schema::table('clients_2', function($table) {
        //
        //Através de um array com o nome dos campos.
        //Podemos usar opcionalmente o nome da chave: $table->dropForeign('clients_2_category_code_1_category_code_2_foreign');
        //
        $table->dropForeign(['category_code_1', 'category_code_2']);
    });
});

#
# Campos opcionais e valor padrão.
#
Route::get('/schema/modifiersTest_3', function() {
    Schema::create('modifiers_3', function($table) {
        //
        //Chave primária.
        //Cria a PK modifiers_3_pkey.
        //
        $table->integer('codigo')->primary();

        //
        //Campos opcionais.
        //Via de regra os campos são marcados como obrigatórios.
        //Assume-se true quando o argumento é omitido.
        //
        $table->string('nome', 50)->nullable();
        $table->string('cidade', 50)->nullable(true);

        //
        //Campo com valor padrão.
        //
        $table->string('uf', 2)->default('SP');

        //
        //Inteiro apenas com valores positivos
        //Apenas para conhecimento, pois o postgres não diferencia signed e unsigned.
        //
        $table->integer('idade')->unsigned();
    });
});

#
# Inclusão de tabela e campo condicionada à inexistência do objeto.
#
Route::get('/schema/createTable/{tableName}', function($tableName) {
    if (!Schema::hasTable($tableName)) {
        Schema::create($tableName, function($table) {
            $table->integer('id')->primary();
        });
    }
});

Route::get('/schema/addColumn/{tableName}/{columnName}', function($tableName, $columnName) {
    if (Schema::hasTable($tableName)) {
        if (!Schema::hasColumn($tableName, $columnName)) {
            Schema::table($tableName, function($table) use ($columnName) {
                $table->string($columnName);
            });
        }
    }
});

//
//Eloquent
//CRUD
//

Route::get('/orm/game/insert/{name}/{description}', function($name, $description) {
    //
    //Ao chamar save() novamente o Laravel irá alterar o registro.
    //Para inserir um novo registro é preciso criar uma nova instância.
    //
    $game = new \App\Game;
    $game->name = $name;
    $game->description = $description;
    $game->save();
    return $game->id;
});

Route::get('/orm/game/find/{id}', function($id) {
    $game = \App\Game::find($id);
    if (isset($game)) {
        return $game->name;
    }
    else {
        return 'Código não encontrado.';
    }
});

Route::get('/orm/game/update/{id}', function($id) {
    //
    //http://128.127.1.156:8080/orm/game/update/1?name=xxx&description=zzz
    //
    $game = \App\Game::find($id);
    if (isset($game)) {
        $game->name = Request::get('name');
        $game->description = Request::get('description');
        $game->save();
        return 'OK';
    }
    else {
        return 'Código não encontrado.';
    }
});

Route::get('/orm/game/delete/{id}', function($id) {
    //
    //Pode ser efetuada também com:
    //  \App\Game::destroy(1);
    //  \App\Game::destroy(1, 2, 3);
    //  \App\Game::destroy([1, 2, 3]);
    //
    $game = \App\Game::find($id);
    if (isset($game)) {
        $game->delete();
        return 'OK';
    }
    else {
        return 'Código não encontrado.';
    }
});

//
//Eloquent/Listagem
//
Route::get('/orm/albums/generate', function() {
    $album = new \App\Album;
    $album->title = 'Some Mad Hope';
    $album->artist = 'Matt Nathanson';
    $album->genre = 'Acoustic Rock';
    $album->year = 2007;
    $album->save();

    $album = new \App\Album;
    $album->title = 'Please';
    $album->artist = 'Matt Nathanson';
    $album->genre = 'Acoustic Rock';
    $album->year = 1993;
    $album->save();

    $album = new \App\Album;
    $album->title = 'Leaving Through The Window';
    $album->artist = 'Something Corporate';
    $album->genre = 'Piano Rock';
    $album->year = 2002;
    $album->save();

    $album = new \App\Album;
    $album->title = '...Anywhere But Here';
    $album->artist = 'The Ataris';
    $album->genre = 'Punk Rock';
    $album->year = 1997;
    $album->save();

    $album = new \App\Album;
    $album->title = '...Is A Real Boy';
    $album->artist = 'Say Anything';
    $album->genre = 'Indie Rock';
    $album->year = 2006;
    $album->save();
});

#
# Retorna um registro específico
#
Route::get('/orm/albums/find/{id}', function($id) {
    //
    //Ao retornar a instância ou coleção de instâncias o PHP executa automaticamente o método __toString().
    //O Laravel customiza a implemementação do método e converte o resultado para JSON.
    //O mesmo acontece com os métodos all() e first().
    //
    $album = \App\Album::find($id);
    if (isset($album)) {
        return $album;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Retorna os registros com os códigos especificados
#
Route::get('/orm/albums/find/{first}/{second}', function($first, $second) {
    $albums = \App\Album::find([$first, $second]);
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Retorna todos os registros
#
Route::get('/orm/albums/all', function() {
    $albums = \App\Album::all();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Retorna o primeiro registro
#
Route::get('/orm/albums/first', function() {
    $album = \App\Album::first();
    if (isset($album)) {
        return $album;
    }
    else {
        return 'Nada encontrado.';
    }
});

//
//Eloquent
//Constraints
//

#
# =
#
Route::get('/orm/albums/filter/{id}', function($id) {
    //
    //O get() permite especificar as colunas de retorno através de um array: "...get(['title']);".
    //Se o retorno for de apenas uma coluna, o get() pode ser substituído por pluck(): "...pluck('title');".
    //Diferente do que é citado no livro, há apenas pluck(), lists() foi descontinuado.
    //Operadores: = < > => =<
    //
    //Pode usar apenas "\App\Album::where('id', $id);" para filtrar por igualdade.
    //
    $album = \App\Album::where('id', '=', $id)
        ->get();
    if (isset($album)) {
        return $album;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# %
#
Route::get('/orm/albums/filter/partial/{artist}', function($artist) {
    //
    //'%'.xxx.'%'
    //xxx.'%'
    //'%'.xxx
    //
    $albums = \App\Album::where('artist', 'like', $artist.'%')
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# or
#
Route::get('/orm/albums/filter/or/{year}/{anotherYear}', function($year, $anotherYear) {
    $albums = \App\Album::where('year', '=', $year)
        ->orWhere('year', '=', $anotherYear)
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Manual
#
Route::get('/orm/albums/filter/raw/{year}/{anotherYear}', function($year, $anotherYear) {
    //
    //Disponível também orWhereRaw().
    //
    $albums = \App\Album::whereRaw('year = ? or year = ?', [$year, $anotherYear])
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# between
#
Route::get('/orm/albums/filter/between/{year}/{anotherYear}', function($year, $anotherYear) {
    //
    //Disponível também orWhereBetween().
    //
    $albums = \App\Album::whereBetween('year', [$year, $anotherYear])
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Subcondições
#
Route::get('/orm/albums/filter/nested/{year}/{anotherYear}', function($year, $anotherYear) {
    //
    //Resultado: select * from "albums" where ("year" >= ? and "year" <= ?).
    //Não há orWhereNested(), mas pode ser usado orWhere().
    //
    $albums = \App\Album::whereNested(function($query) use ($year, $anotherYear) {
        $query->where('year', '>=', $year);
        $query->where('year', '<=', $anotherYear);
    })->get();

    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Subcondições/or
#
Route::get('/orm/albums/filter/nested2/{year}/{anotherYear}/{anotherAnotherYear}', function($year, $anotherYear, $anotherAnotherYear) {
    //
    //Resultado: select * from "albums" where ("year" >= ? and "year" <= ?) or ("year" = ?).
    //
    $albums = \App\Album::whereNested(function($query) use ($year, $anotherYear) {
        $query->where('year', '>=', $year);
        $query->where('year', '<=', $anotherYear);
    })->orWhere(function($query) use ($anotherAnotherYear) {
        $query->where('year', '=', $anotherAnotherYear);
    })->get();

    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# in
#
Route::get('/orm/albums/filter/in/{year}/{anotherYear}', function($year, $anotherYear) {
    //
    //Disponível também orWhereIn.
    //
    $albums = \App\Album::whereIn('year', [$year, $anotherYear])
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# not in
#
Route::get('/orm/albums/filter/notIn/{year}/{anotherYear}', function($year, $anotherYear) {
    //
    //Disponível também orWhereNotIn.
    //
    $albums = \App\Album::whereNotIn('year', [$year, $anotherYear])
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});


#
# null
#
Route::get('/orm/albums/filter/null/isNull', function() {
    //
    //Disponível também orWhereNull.
    //
    $albums = \App\Album::whereNull('artist')
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# not null
#
Route::get('/orm/albums/filter/null/notIsNull', function() {
    //
    //Disponível também orWhereNotNull.
    //
    $albums = \App\Album::whereNotNull('artist')
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Alteração
#
Route::get('/orm/albums/update/{id}', function($id) {
    \App\Album::where('id', '=', $id)
        ->update(['artist' => Request::get('artist')]);
    return 'OK';
});

#
# Exclusão
#
Route::get('/orm/albums/delete/{id}', function($id) {
    \App\Album::where('id', '=', $id)
        ->delete();
    return 'OK';
});

#
# SQL
#
Route::get('/orm/albums/sql/{id}', function($id) {
    return \App\Album::where('id', '=', $id)->toSql();
});

//
//Eloquent
//Resultados
//

#
# Ordenação.
#
Route::get('/orm/albums/order', function() {
    //
    //orderBy() pode ser usado avulso ou após instruções where().
    //
    $albums = \App\Album::orderBy('artist')
        ->orderBy('genre', 'desc')
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Limite.
#
Route::get('/orm/albums/limit', function() {
    //
    //Pode ser combinado com orderBy() ou instruções where().
    //Resultado: select * from "albums" limit 3
    //
    $albums = \App\Album::take(3)
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

#
# Offset.
#
Route::get('/orm/albums/offset', function() {
    //
    //Pode ser combinado com take(), orderBy() ou instruções where().
    //Resultado: select * from "albums" limit 2 offset 1
    //
    $albums = \App\Album::take(2)
        ->skip(1)
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

//
//Eloquent
//Condições mágicas
//
Route::get('/orm/albums/filter/magical/{id}', function($id) {
    //
    //Nome do campo no formato NomeDoCampo.
    //Apenas filtro por igualdade.
    //Pode ser combinado com orderBy() ou outras instruções where().
    //
    $album = \App\Album::whereId($id)
        ->get();
    if (isset($album)) {
        return $album;
    }
    else {
        return 'Nada encontrado.';
    }
});

//
//Eloquent
//Filtro por escopo
//
Route::get('/orm/albums/filter/scope/{year}/{anotherYear}', function($year, $anotherYear) {
    //
    //O Laravel irá procurar pelo método scopeYear() no modelo e executá-lo.
    //Métodos de escopo devem começar obrigatoriamente com "scope".
    //O primeiro parâmetro em scopeYear() é a query onde a condição deverá ser gerada.
    //Os demais podem ser customizados ou omitidos.
    //
    $albums = \App\Album::year($year, $anotherYear)
        ->get();
    if (isset($albums)) {
        return $albums;
    }
    else {
        return 'Nada encontrado.';
    }
});

//
//Eloquent
//Collections
//
Route::get('/orm/collections/all', function() {
    //
    //Retorna um array com as instâncias.
    //
    $albums = \App\Album::all();
    var_dump($albums->all());
});

Route::get('/orm/collections/first', function() {
    //
    //Retorna o primeiro item da coleção.
    //Usar shift() para retornar e remover o primeiro item da coleção.
    //
    $albums = \App\Album::all();
    var_dump($albums->first());
});

Route::get('/orm/collections/last', function() {
    //
    //Retorna o último item da coleção.
    //Usar pop() para retornar e remover o último item da coleção.
    //
    $albums = \App\Album::all();
    var_dump($albums->last());
});

Route::get('/orm/collections/each', function() {
    //
    //Percorre os itens da coleção.
    //
    $albums = \App\Album::all();
    $albums->each(function($album, $index) {
        var_dump($index.': '.$album->title);
    });
});

Route::get('/orm/collections/map', function() {
    //
    //Percorre os itens da coleção e retorna uma nova coleção com o retorno especificado.
    //
    $albums = \App\Album::all();
    $newAlbums = $albums->map(function($album, $index) {
        return $index.': '.$album->title;
    });

    var_dump($newAlbums);
});

Route::get('/orm/collections/filter', function() {
    //
    //Percorre os itens da coleção e retorna uma nova coleção com as instâncias que atendem à condição.
    //
    $albums = \App\Album::all();
    $newAlbums = $albums->filter(function($album) {
        if ($album->artist == 'Something Corporate') {
            return true;
        }
    });

    var_dump($newAlbums->all());
});

Route::get('/orm/collections/sort', function() {
    //
    //Retorna uma nova coleção com os instâncias ordenadas.
    //A closure é responsável por aplicar a comparação.
    //Retornar zero se forem iguais, 1 se $a for maior que $b e -1 se $a for menor que $b.
    //Pode-se usar strcmp(), strcasecmp(), strnatcmp() ou strnatcasecmp() para comparar os valores.
    //
    $albums = \App\Album::all();
    $albums = $albums->sort(function($a, $b) {
        $a = $a->year;
        $b = $b->year;
        if ($a == $b) {
            return 0;
        }
        else {
            return ($a > $b) ? 1 : -1;
        }
    });

    $albums->each(function($album) {
        var_dump($album->year);
    });
});

Route::get('/orm/collections/reverse', function() {
    //
    //Retorna uma nova coleção com as instâncias listadas de trás para frente.
    //
    $albums = \App\Album::all();
    $newAlbums = $albums->reverse();
    var_dump($newAlbums->all());
});

Route::get('/orm/collections/merge', function() {
    //
    //Mescla uma coleção com outra.
    //
    $albums_1 = \App\Album::where('artist', '=', 'Something Corporate')->get();
    $albums_2 = \App\Album::where('artist', '=', 'Matt Nathanson')->get();
    $albums = $albums_1->merge($albums_2);
    var_dump($albums->all());
});

Route::get('/orm/collections/slice', function() {
    //
    //Extrai partes da coleção.
    //O primeiro argumento indica a posição de início e o segundo a quantidade de elementos.
    //O primeiro argumento quando negativo indica que a operação começa a partir do final da coleção.
    //Exemplo: slice(-3, 3) é equivalente à slice(1, 3).
    //
    $albums = \App\Album::all();
    $newAlbums = $albums->slice(1, 3);
    var_dump($newAlbums->all());
});

Route::get('/orm/collections/isEmpty', function() {
    //
    //Retorna True se a coleção está vazia.
    //
    $albums = \App\Album::all();
    var_dump($albums->isEmpty());
});

Route::get('/orm/collections/toArray', function() {
    //
    //Converte a coleção para array.
    //toArray() retorna um array multidimensional, pois converte também a instâncias.
    //
    $albums = \App\Album::all();
    var_dump($albums->toArray());
});

Route::get('/orm/collections/toJson', function() {
    //
    //Converte a coleção para JSON.
    //
    $albums = \App\Album::all();
    var_dump($albums->toJson());
});

Route::get('/orm/collections/count', function() {
    //
    //Retorna a quantidade de itens da coleção.
    //
    $albums = \App\Album::all();
    var_dump($albums->count());
});

//
//Eloquent
//Relacionamentos
//

#
# Artist
#
Route::get('/orm/artist/insert', function() {
    //
    //Exemplo: http://128.127.1.156:8080/orm/artist/insert?name=Eve%206
    //
    $artist = new \App\Artist;
    $artist->name = Request::get('name');
    $artist->save();
    return $artist->id;
});

Route::get('/orm/artist/find/{id}', function($id) {
    //
    //Usar "$artist->discs()->get()" ou "$artist->load('discs')" para obter a lista de discos.
    //A diferença do primeiro para o segundo é que load() mantém os resultados na instância.
    //
    $artist = \App\Artist::find($id);
    return $artist->toJson();
});

Route::get('/orm/artist/findWithoutLazyLoad/{id}', function($id) {
    //
    //Usar with() com os atributos de relacionamento para carregá-los junto com registro.
    //with() permite encadeamento para carregar subrelacionamentos.
    //
    $artist = \App\Artist::with(['discs'])->find($id);
    return $artist->toJson();
});

Route::get('/orm/artist/findWithDetailConstraints/{id}', function($id) {
    //
    //Pode-se customizar o carregamento dos relacionamentos com uma closure no argumento do método with().
    //A closure pode ser aplicada também no método load().
    //
    $artist = \App\Artist::with(['discs' => function($query) {
        $query->where('name', 'like', 'Teste%');
        $query->orderBy('created_at', 'desc');
    }])->find($id);
    return $artist->toJson();
});

#
# Disc
#
Route::get('/orm/disc/insert', function() {
    //
    //Exemplo: http://128.127.1.156:8080/orm/disc/insert?name=Horrorscope&artist_id=1
    //O artista pode ser preenchido também com "$disc->artist_id = $artist->id;".
    //Usar "$disc->artist()->dissociate();" ou "$disc->artist_id = null;" para desfazer.
    //
    $artist = \App\Artist::find(Request::get('artist_id'));
    $disc = new \App\Disc;
    $disc->name = Request::get('name');
    $disc->artist()->associate($artist);
    $disc->save();
    return $disc->id;
});

Route::get('/orm/disc/find/{id}', function($id) {
    //
    //Usar "$disc->artist()->get()" ou "$disc->load(['artist', 'listeners']);" para obter o artista.
    //A diferença do primeiro para o segundo é que load() mantém os resultados na instância.
    //
    $disc = \App\Disc::find($id);
    return $disc->toJson();
});

Route::get('/orm/disc/findWithoutLazyLoad/{id}', function($id) {
    //
    //Usar with() com os atributos de relacionamento para carregá-los junto com registro.
    //with() permite encadeamento para carregar subrelacionamentos.
    //
    $disc = \App\Disc::with(['artist', 'listeners'])->find($id);
    return $disc->toJson();
});

#
# Listener
#
Route::get('/orm/listener/insert', function() {
    //
    //Exemplo: http://128.127.1.156:8080/orm/listener/insert?name=Rafael
    //
    $listener = new \App\Listener;
    $listener->name = Request::get('name');
    $listener->save();
    return $listener->id;
});

Route::get('/orm/listener/insertDisc/{listener_id}/{disc_id}', function($listener_id, $disc_id) {
    //
    //Exemplo: http://128.127.1.156:8080/orm/listener/insertDisc/1/1
    //attach() aceita no segundo argumento um array de valores para gravação na tabela associativa. Exemplo: "$listener->discs()->attach($disc->id, ['nome_do_campo' => $valor]);".
    //attach() aceita também um array de IDs.
    //
    $disc = \App\Disc::find($disc_id);
    $listener = \App\Listener::find($listener_id);
    $listener->discs()->attach($disc->id);
    return $listener->discs()->get()->toJson();
});

Route::get('/orm/listener/removeDisc/{listener_id}/{disc_id}', function($listener_id, $disc_id) {
    //
    //Exemplo: http://128.127.1.156:8080/orm/listener/removeDisc/1/1
    //Para remover todos os discos usar "$listener->discs()->detach();".
    //detach() aceita também um array de IDs.
    //
    $disc = \App\Disc::find($disc_id);
    $listener = \App\Listener::find($listener_id);
    $listener->discs()->detach($disc->id);
    return $listener->discs()->get()->toJson();
});

Route::get('/orm/listener/find/{id}', function($id) {
    //
    //Usar "$listener->discs()->get()" ou "$listener->load('discs.artist');" para obter os discos.
    //
    $listener = \App\Listener::find($id);
    return $listener->toJson();
});

Route::get('/orm/listener/findWithoutLazyLoad/{id}', function($id) {
    //
    //Usar with() com os atributos de relacionamento para carregá-los junto com registro.
    //with() permite encadeamento para carregar subrelacionamentos.
    //
    $listener = \App\Listener::with(['discs.artist'])->find($id);
    return $listener->toJson();
});

//
//Validação
//

#
# Customização
#
class Validations {
    public function validation1($field, $value, $params) {
        return strlen($value) > 10;
    }
}

Validator::extend('validation1', 'Validations@validation1');
Validator::extend('validation2', function ($field, $value, $params) {
    //
    //$params recebe um array de argumentos adicionais.
    //
    return strlen($value) > 15;
});

#
# Execução
#
Route::get('/validation/registration', function() {
    return View::make('registration');
});

Route::post('/validation/registration', function() {
    //
    //Validator::make() recebe um array com os argumentos e outro com as regras que devem ser aplicadas.
    //Pode receber também um terceiro com mensagens alternativas.
    //Podemos passar mais de uma condição para o atributo com array ou pipe: "'username' => 'alpha_num|min:3'", "'username' => ['alpha_num', 'min:3']".
    //No caso de múltiplas condições, podemos acrescentar a identificador "bail" no primeiro argumento para que o Laravel pare de validar o atributo assim que alguma condição não seja satisfeita. Exemplo: "'username' => 'bail|required|alpha_num|min:3|max:32'".
    //Regras disponíveis: https://laravel.com/docs/5.7/validation#available-validation-rules
    //
    //"$validator->passes();" pode ser substituido por "$validator->fails();".
    //Usar "$validator->messages();" para ver as mensagens que porventura sejam geradas.
    //As mensagens podem ser configuradas em uma rota ou redirecionamento com withErrors() passando o validador.
    //Usar o atributo "$errors" na template para acessar as mensagens.
    //"$errors" é uma instância da classe MessageBag conforme https://laravel.com/api/5.4/Illuminate/Support/MessageBag.html.
    //
    //Usar "$validator->validate();" para efetuar o redirecionamento automático em caso de erro.
    //
    $formData = Request::all();
    $rules = [
        'username' => 'required|alpha_num|min:3|max:32|validation1|validation2',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:3'
    ];

    $messages = [
        'required' => 'O campo \':attribute\' é obrigatório.',
        'username.required' => 'Preencha o usuário.',
        'validation1' => 'O campo deve ter mais de 10 caracteres.',
        'validation2' => 'O campo deve ter mais de 15 caracteres.'
    ];

    $validator = Validator::make($formData, $rules, $messages);
    if ($validator->passes()) {
        return 'OK';
    }
    else {
        return Redirect::to('/validation/registration')->withErrors($validator);
    }

    /*
    $validator->validate();
    return 'OK';
    */
});

//
//Events
//

#
# Via Event::listen().
#
# O terceiro parâmetro do listener define a prioridade de execução.
# Listeners com valores mais altos são executados primeiro.
#
class EventListener {
    public function process($a, $b, $c) {
        echo '(3:'.$a.' '.$b.' '.$c.')';
        ///return false;
    }
}

Event::listen('my.event1', 'EventListener@process', 3);
Event::listen('my.event1', function($a, $b, $c) {
    echo '(2:'.$a.' '.$b.' '.$c.')';
}, 2);

Event::listen('my.event1', function($a, $b, $c) {
    echo '(1:'.$a.' '.$b.' '.$c.')';
}, 1);

Route::get('/events/fire1', function() {
    Event::fire('my.event1', [1, 2, 3]);
});

#
# Via Event::subscribe().
#
class EventListeners {
    public function listener1($a, $b, $c) {
        echo '(2:'.$a.' '.$b.' '.$c.')';
    }

    public function listener2($a, $b, $c) {
        echo '(1:'.$a.' '.$b.' '.$c.')';
    }

    public function subscribe($events) {
        $events->listen('my.event2', 'EventListeners@listener1', 1);
        $events->listen('my.event2', 'EventListeners@listener2', 2);
    }
}

Event::subscribe(new EventListeners);

Route::get('/events/fire2', function() {
    Event::fire('my.event2', [1, 2, 3]);
});

//
//Injeção de dependência
//

#
# Via app/container.
#
class Dependencia {
    public $valor = 'Teste';
}

Route::get('/dependencyInjection/container', function() {
    $dependencia = app()->make(Dependencia::class);
    return $dependencia->valor;
});

#
# Via controlador.
#
Route::get('/dependencyInjection/controller/first/{argument}', 'Injection@first');
Route::get('/dependencyInjection/controller/second/{argument}', 'Injection@second');

//
//Middlewares
//

#
# Registro através da classe.
#
Route::get('/teste1', function() {
    echo 'Teste1.';
})->middleware(App\Http\Middleware\MyMiddleware1::class);

Route::get('/teste2', function() {
    echo 'Teste2.';
})->middleware(App\Http\Middleware\MyMiddleware2::class);

#
# Registro através do alias.
# A alias deve estar configurado no atributo "$routeMiddleware" em "/app/Http/Kernel.php".
# No primeiro exemplo, a closure do atributo "uses" pode ser substituída pelo método de um controlador.
#
Route::get('/teste3', ['middleware' => ['middle3'], 'uses' => function() {
    echo 'Teste3.';
}]);

Route::get('/teste4', function() {
    echo 'Teste4.';
})->middleware('middle4');

#
# Parâmetros
# Apenas quando o registro for feito através de alias.
# Passá-los após o nome com ":".
# Estarão disponíveis no método "handle()" do middleware após o argumento "$next".
#
Route::get('/teste5', ['middleware' => ['middle5:1,2'], 'uses' => function() {
    echo 'Teste5.';
}]);

Route::get('/teste6', function() {
    echo 'Teste6.';
})->middleware('middle6:3,4');

#
# Grupos de middlewares.
# A alias deve estar configurado no atributo "$middlewareGroups" em "/app/Http/Kernel.php".
#
Route::get('/teste7', function() {
    echo 'Teste7.';
})->middleware('middle_group');

//
//Container
//

#
# Resolve.
# O bind da classe é feito na classe ExampleProvider.
# ExampleProvider por sua vez é configurado em "config/app.php".
#
# Via alias.
#
Route::get('/container/resolve/alias', function() {
    $panda = App::make('panda');
    echo $panda->execute();
});

#
# Via caminho da classe.
#
Route::get('/container/resolve/path', function() {
    $redPanda = App::make('\App\Classes\RedPanda');
    echo $redPanda->execute();
});

#
# Via classe.
#
Route::get('/container/resolve/class', function() {
    $bear = App::make(\App\Classes\Bear::class);
    echo $bear->execute();
});

#
# Singleton.
#
Route::get('/container/resolve/singleton', function() {
    $firstCow = App::make(\App\Classes\Cow::class);
    $secondCow = App::make(\App\Classes\Cow::class);
    echo $firstCow === $secondCow ? 'Igual.' : 'Diferente.';
});

#
# Instância.
#
Route::get('/container/resolve/instance', function() {
    $monkey = App::make(\App\Classes\Monkey::class);
    echo $monkey->value;
});

#
# Interface.
#
Route::get('/container/resolve/interface', 'SocialController@execute');

//
//Performance
//
Route::get('/hello', function() {
    return 'Hello World!';
});
