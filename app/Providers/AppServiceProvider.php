<?php

namespace App\Providers;

use App\Models\Supercategoria;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        // me permite utilizar categoria en todas las vistas
        View::composer('*', function ($view) {


            $supercategorias = Supercategoria::where('visible', 1) // Filtra solo supercategorías visibles
                    ->whereHas('categorias', function ($query) {
                        $query->where('visible', 1) // Filtra solo categorías visibles
                                ->whereHas('productos', function ($q) {
                                    $q->where('eliminado', 0)->where('stock', '>', 0);
                                });
                    })
                    ->with(['categorias' => function ($query) {
                            $query->where('visible', 1) // Asegura que solo se carguen categorías visibles
                                    ->whereHas('productos', function ($q) {
                                        $q->where('eliminado', 0);
                                    });
                        }])
                    ->get();

            $view->with('supercategorias', $supercategorias);

            $imagenes = collect(File::files(public_path('img')))
                    ->map(fn($file) => $file->getFilename())
                    ->filter(fn($name) => preg_match('/\.(jpg|jpeg|png|webp)$/i', $name))
                    ->values()
                    ->all();

            $view->with('imagenes', $imagenes);
        });
    }
}
