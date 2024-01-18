<?php

namespace App\Console\Commands;

use App\Models\Quote;
use App\Models\Template;
use App\Actions\TemplateManager as TemplateManager;
use Illuminate\Console\Command;

/**
 * Class Message
 *
 * @package App\Console\Commands
 */
class Message extends Command
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
        // Create a new template with placeholders
        $template = new Template([
            'id' => 1,
            'subject' => 'Your delivery to [quote:destination_name]',
            'content' => " Hi [user:first_name], Thanks for contacting us to deliver to [quote:destination_name].
        
            Regards,
        
            SAYNA team "
        ]);

        // Initialize the TemplateManager
        $templateManager = new TemplateManager();

        // Create a new quote
        $quote = new Quote();

        // Get the computed template with replaced placeholders
        $message = $templateManager->getTemplateComputed($template, ['quote' => $quote]);

        // Display the generated message
        $this->info($message->subject . "\n" . $message->content);
    }
}
