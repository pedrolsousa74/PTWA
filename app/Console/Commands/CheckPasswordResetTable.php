<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckPasswordResetTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:password-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check password reset tokens table structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking password_reset_tokens table...');
        
        if (Schema::hasTable('password_reset_tokens')) {
            $this->info('Table exists!');
            
            $columns = Schema::getColumnListing('password_reset_tokens');
            $this->info('Columns: ' . implode(', ', $columns));
            
            try {
                $structure = DB::select('DESCRIBE password_reset_tokens');
                $this->info('Table structure:');
                foreach ($structure as $column) {
                    $this->line("- {$column->Field} ({$column->Type}) " . 
                                ($column->Key ? "Key: {$column->Key}" : ''));
                }
            } catch (\Exception $e) {
                $this->error('Error getting structure: ' . $e->getMessage());
            }
        } else {
            $this->error('Table does not exist!');
        }
    }
}
