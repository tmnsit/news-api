<?php

namespace App\Console\Commands;

use App\Actions\NewsParserAction;
use Illuminate\Console\Command;


class ParserNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(NewsParserAction $parser): int
    {
        $parser->handle();
        info('OK');
        return Command::SUCCESS;
    }
}
