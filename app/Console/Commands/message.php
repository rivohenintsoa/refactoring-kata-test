<?php

namespace App\Console\Commands;

use App\Models\Quote;
use App\Models\Template;
use App\Services\TemplateManagerService as TemplateManager;
use Illuminate\Console\Command;

class message extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $template = new Template([
            'id' => 1,
            'subject' => 'Your delivery to [quote:destination_name]',

            'content' => " Hi [user:first_name], Thanks for contacting us to deliver to [quote:destination_name].
        
            Regards,
        
            SAYNA team "
        ]);

        $templateManager = new TemplateManager();

        $quote = new Quote();
        $message = $templateManager->getTemplateComputed($template, ['quote' => $quote]);

        $this->info($message->subject . "\n" . $message->content);

        echo "ahahahaha" . $message->subject . "\n" . $message->content;
    }
}
