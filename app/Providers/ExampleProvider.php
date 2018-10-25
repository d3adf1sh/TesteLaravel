<?php

namespace App\Providers;

use App\Classes\SocialManager;
use Illuminate\Support\ServiceProvider;
use \App\Classes\Panda;
use \App\Classes\RedPanda;
use \App\Classes\Bear;
use \App\Classes\Cow;
use \App\Classes\Monkey;
use App\Classes\SocialProvider;
use App\Classes\FacebookSocialProvider;
use App\Classes\TwitterSocialProvider;

class ExampleProvider extends ServiceProvider {
    public function boot() {
    }

    public function register() {
        //
        //bind() cria uma nova instância cada vez que a classe é "resolvida".
        //singleton() como sugere o nome mantém uma única instância da classe. Podemos passar um alias, o caminho ou a própria classe.
        //instance() usa uma instância pré-definida.
        //

        //
        //Alias.
        //
        $this->app->bind('panda', function() {
            echo 'Panda:';
            return new Panda;
        });

        //
        //Caminho da classe.
        //
        $this->app->bind('\App\Classes\RedPanda', function() {
            echo 'RedPanda:';
            return new RedPanda;
        });

        //
        //Classe.
        //
        $this->app->bind(\App\Classes\Bear::class, function() {
            echo 'Bear:';
            return new Bear;
        });

        //
        //Singleton.
        //
        $this->app->singleton(\App\Classes\Cow::class, function() {
            echo 'Cow:';
            return new Cow;
        });

        //
        //Instância.
        //
        $monkey = new Monkey;
        $monkey->value = 1500;
        $this->app->instance(\App\Classes\Monkey::class, $monkey);

        //
        //Interface.
        //
        $this->app->bind(SocialProvider::class, TwitterSocialProvider::class);

        //
        //Conextual.
        //Ao buscar pela classe SocialManager, será de devolvida uma instância de FacebookSocialProvider onde SocialProvider for usado como tipo.
        //
        $this->app->when(SocialManager::class)
            ->needs(SocialProvider::class)
            ->give(FacebookSocialProvider::class);
    }
}