<?php

declare(strict_types=1);

namespace Crumbls\Layup\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'layup:install';

    protected $description = 'Install Layup page builder — publish config, run migrations, and print next steps';

    public function handle(): int
    {
        $this->info('Installing Layup...');
        $this->newLine();

        // Publish config
        $this->call('vendor:publish', [
            '--tag' => 'layup-config',
        ]);
        $this->info('✓ Config published');

        // Run migrations
        $this->call('migrate');
        $this->info('✓ Migrations completed');

        // Generate safelist
        $this->callSilent('layup:safelist');
        $this->info('✓ Tailwind safelist generated');

        $this->newLine();
        $this->components->info('Layup installed successfully!');
        $this->newLine();

        $this->comment('Next steps:');
        $this->newLine();
        $this->line('  1. Register the plugin in your Filament panel:');
        $this->newLine();
        $this->line('     ->plugins([');
        $this->line('         \Crumbls\Layup\LayupPlugin::make(),');
        $this->line('     ])');
        $this->newLine();
        $this->line('  2. Add the safelist to your Tailwind config:');
        $this->newLine();
        $this->line('     // tailwind.config.js (v3)');
        $this->line('     content: [\'./storage/layup-safelist.txt\']');
        $this->newLine();
        $this->line('     // app.css (v4)');
        $this->line('     @source "../../storage/layup-safelist.txt";');
        $this->newLine();
        $this->line('  3. Rebuild your frontend assets:');
        $this->newLine();
        $this->line('     npm run build');
        $this->newLine();

        return self::SUCCESS;
    }
}
