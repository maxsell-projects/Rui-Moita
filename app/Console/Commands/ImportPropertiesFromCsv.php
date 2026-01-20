<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportPropertiesFromCsv extends Command
{
    /**
     * Assinatura do comando.
     */
    protected $signature = 'properties:import-csv {file=Main.csv : O nome do arquivo CSV na pasta storage/app}';

    /**
     * Descrição do comando.
     */
    protected $description = 'Importa imóveis de um arquivo CSV e baixa as imagens em alta qualidade.';

    /**
     * Execução do comando.
     */
    public function handle()
    {
        $fileName = $this->argument('file');
        $path = storage_path('app/' . $fileName);

        if (!file_exists($path)) {
            $this->error("Arquivo não encontrado em: {$path}");
            return 1;
        }

        // Garante que existe um usuário para associar o imóvel
        $user = User::first();
        if (!$user) {
            $this->error('Nenhum usuário encontrado. Rode php artisan db:seed ou crie um usuário antes de importar.');
            return 1;
        }

        $this->info("Iniciando importação de: {$fileName}...");

        $file = fopen($path, 'r');
        $headers = fgetcsv($file); 
        $headerMap = array_flip($headers);

        $count = 0;

        while (($row = fgetcsv($file)) !== false) {
            $getVal = fn($key) => $row[$headerMap[$key] ?? -1] ?? null;

            // Limpa a referência (Ex: "id. 123" vira "123")
            $reference = str_replace('id. ', '', $getVal('ID'));
            $title = $getVal('Title');

            if (!$title) continue;

            // Evita duplicados
            if (Property::where('reference_code', $reference)->exists()) {
                $this->warn("Imóvel {$reference} já existe. Pulando...");
                continue;
            }

            $this->info("Processando: {$title} ({$reference})");

            // --- TRATAMENTO DE DADOS ---
            $price = (float) preg_replace('/[^0-9.]/', '', str_replace(',', '.', $getVal('Price')));
            $area = (float) preg_replace('/[^0-9.]/', '', str_replace(',', '.', $getVal('Area')));
            $bedrooms = (int) preg_replace('/[^0-9]/', '', $getVal('Bedrooms'));
            $bathrooms = (int) preg_replace('/[^0-9]/', '', $getVal('Bathrooms'));
            
            // Lógica simples de tipo baseada no título
            $type = 'apartment';
            $lowerTitle = Str::lower($title);
            if (Str::contains($lowerTitle, ['moradia', 'casa', 'vivenda'])) $type = 'house';
            if (Str::contains($lowerTitle, ['terreno', 'lote'])) $type = 'land';
            if (Str::contains($lowerTitle, ['loja', 'comercial', 'escritório'])) $type = 'store';

            // --- DOWNLOAD CAPA (HD) ---
            $rawCoverUrl = $getVal('Main Image');
            $coverPath = null;
            
            if ($rawCoverUrl) {
                // Tenta pegar a imagem em HD substituindo o prefixo de redimensionamento
                $hdCoverUrl = str_replace('/ds-l/', '/l-feat/', $rawCoverUrl);
                $coverPath = $this->downloadImage($hdCoverUrl, $reference, 'cover');
            }

            // --- CRIAR PROPERTY ---
            $property = Property::create([
                'user_id' => $user->id,
                'title' => $title,
                'slug' => Str::slug($title . '-' . $reference),
                'description' => $getVal('Description'),
                'price' => $price,
                'location' => $getVal('Location'),
                'city' => $getVal('Location'), // Preenche city para o filtro de localização funcionar
                'type' => $type,
                'status' => 'available', // Status padrão da planilha
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'area_gross' => $area,
                'energy_rating' => $getVal('Energy Class'),
                'reference_code' => $reference,
                'cover_image' => $coverPath,
                'is_visible' => true, // Importante: Garante que apareça no site imediatamente
            ]);

            // --- DOWNLOAD GALERIA (HD) ---
            for ($i = 1; $i <= 24; $i++) {
                $rawImgUrl = $getVal("Image{$i}");
                if ($rawImgUrl) {
                    $hdImgUrl = str_replace('/ds-l/', '/l-feat/', $rawImgUrl);
                    $imgPath = $this->downloadImage($hdImgUrl, $reference, "gallery_{$i}");
                    
                    if ($imgPath) {
                        PropertyImage::create([
                            'property_id' => $property->id,
                            'path' => $imgPath,
                        ]);
                    }
                }
            }

            $count++;
        }

        fclose($file);
        $this->info("Sucesso! {$count} imóveis importados e visíveis no site.");
        return 0;
    }

    /**
     * Lógica de download com Fallback
     */
    private function downloadImage($url, $reference, $suffix)
    {
        try {
            $response = Http::timeout(20)->get($url);
            
            // Se falhar a versão HD, tenta a original
            if ($response->failed()) {
                $fallbackUrl = str_replace('/l-feat/', '/ds-l/', $url);
                $response = Http::timeout(20)->get($fallbackUrl);
            }

            if ($response->failed() || !$response->body()) return null;

            $filename = "properties/{$reference}/{$reference}_{$suffix}.jpg";

            Storage::disk('public')->put($filename, $response->body());

            return $filename; 
        } catch (\Exception $e) {
            $this->error("Erro na imagem {$url}: " . $e->getMessage());
            return null;
        }
    }
}