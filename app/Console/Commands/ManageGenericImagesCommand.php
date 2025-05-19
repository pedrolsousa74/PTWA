<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ManageGenericImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:generic {action? : Action to perform (list, add, update)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerenciar imagens genéricas usadas para artigos sem imagem';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        if (!$action) {
            $action = $this->choice(
                'Escolha uma ação:',
                ['list', 'add', 'update'],
                0
            );
        }

        switch ($action) {
            case 'list':
                $this->listImages();
                break;
            case 'add':
                $this->addImage();
                break;
            case 'update':
                $this->updateConfig();
                break;
            default:
                $this->error('Ação inválida. Use list, add, ou update.');
                break;
        }
    }

    /**
     * Lista todas as imagens no diretório Icones e indica quais estão configuradas como genéricas
     */
    private function listImages()
    {
        $this->info('Imagens disponíveis no diretório Icones:');
        
        $images = File::files(public_path('Icones'));
        
        // Lista todas as imagens no diretório
        $table = [];
        foreach ($images as $image) {
            $fileName = $image->getFilename();
            // Verifica se a imagem está configurada como genérica no ArtigoController
            $isConfigured = $this->isImageConfigured($fileName);
            
            $table[] = [
                'arquivo' => $fileName,
                'tamanho' => round($image->getSize() / 1024, 2) . ' KB',
                'configurada' => $isConfigured ? 'Sim' : 'Não',
            ];
        }
        
        $this->table(['Arquivo', 'Tamanho', 'Configurada como Genérica'], $table);
    }
    
    /**
     * Adiciona uma nova imagem ao diretório Icones
     */
    private function addImage()
    {
        $imagePath = $this->ask('Digite o caminho completo da imagem que deseja adicionar:');
        
        if (!file_exists($imagePath)) {
            $this->error('O arquivo não existe!');
            return;
        }
        
        $info = pathinfo($imagePath);
        $fileName = $this->ask('Nome do arquivo de destino (com extensão):', $info['basename']);
        
        try {
            // Copia a imagem para o diretório Icones
            File::copy($imagePath, public_path('Icones/' . $fileName));
            $this->info('Imagem copiada com sucesso para o diretório Icones.');
            
            // Pergunta se deseja adicionar à configuração de imagens genéricas
            if ($this->confirm('Deseja configurar esta imagem como uma opção de imagem genérica?', true)) {
                $this->updateConfig($fileName);
            }
        } catch (\Exception $e) {
            $this->error('Erro ao copiar a imagem: ' . $e->getMessage());
        }
    }
    
    /**
     * Atualiza a configuração do ArtigoController para incluir/excluir imagens genéricas
     */
    private function updateConfig($newImage = null)
    {
        $controllerPath = app_path('Http/Controllers/ArtigoController.php');
        $controllerContent = file_get_contents($controllerPath);
        
        // Busca a configuração atual das imagens
        preg_match('/\$availableImages\s*=\s*\[(.*?)\];/s', $controllerContent, $matches);
        
        if (!isset($matches[0]) || !isset($matches[1])) {
            $this->error('Não foi possível encontrar a configuração de imagens no ArtigoController.');
            return;
        }
        
        // Se uma nova imagem foi passada, adiciona automaticamente
        if ($newImage) {
            $info = pathinfo($newImage);
            $nameWithoutExt = $info['filename'];
            $ext = $info['extension'];
            
            $imageEntry = "                ['{$nameWithoutExt}', '{$ext}'],\n";
            $replacement = str_replace('];', $imageEntry . '            ];', $matches[0]);
            
            $controllerContent = str_replace($matches[0], $replacement, $controllerContent);
            file_put_contents($controllerPath, $controllerContent);
            
            $this->info("A imagem {$newImage} foi adicionada à configuração.");
            return;
        }
        
        // Lista as imagens para o usuário escolher
        $images = File::files(public_path('Icones'));
        $imageOptions = [];
        
        foreach ($images as $image) {
            $fileName = $image->getFilename();
            $info = pathinfo($fileName);
            $isConfigured = $this->isImageConfigured($fileName);
            
            $imageOptions[$fileName] = ($isConfigured ? '[X] ' : '[ ] ') . $fileName;
        }
        
        $this->info('Selecione as imagens que deseja usar como imagens genéricas:');
        $this->info('(As imagens marcadas com [X] já estão configuradas)');
        
        $selectedImages = $this->choice(
            'Selecione imagens (separadas por vírgula):',
            $imageOptions,
            null,
            null,
            true
        );
        
        // Prepara a nova configuração
        $newConfig = "\$availableImages = [\n";
        foreach ($selectedImages as $selected) {
            $fileName = preg_replace('/^\[.\] /', '', $selected);
            $info = pathinfo($fileName);
            $newConfig .= "                ['{$info['filename']}', '{$info['extension']}'],\n";
        }
        $newConfig .= "            ];";
        
        // Atualiza o arquivo do controlador
        $controllerContent = preg_replace('/\$availableImages\s*=\s*\[(.*?)\];/s', $newConfig, $controllerContent);
        file_put_contents($controllerPath, $controllerContent);
        
        $this->info('Configuração de imagens genéricas atualizada com sucesso.');
    }
    
    /**
     * Verifica se uma imagem está configurada como genérica no ArtigoController
     */
    private function isImageConfigured($fileName)
    {
        $controllerPath = app_path('Http/Controllers/ArtigoController.php');
        $controllerContent = file_get_contents($controllerPath);
        
        $info = pathinfo($fileName);
        $nameWithoutExt = $info['filename'];
        $ext = $info['extension'];
        
        return strpos($controllerContent, "['{$nameWithoutExt}', '{$ext}']") !== false;
    }
}
