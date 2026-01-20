<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * O nome e assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Gera o sitemap do site automaticamente';

    /**
     * Executa o comando.
     */
    public function handle()
    {
        // Garanta que a URL está correta (pode pegar do .env ou chumbar aqui)
        // O crawler vai navegar link por link a partir da Home
        SitemapGenerator::create(config('app.url'))
            ->getSitemap()
            // Aqui você pode adicionar páginas manuais se o crawler não achar
            // ->add(Url::create('/pagina-escondida'))
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap gerado com sucesso em public/sitemap.xml!');
    }
}