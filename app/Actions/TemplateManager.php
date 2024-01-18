<?php

namespace App\Actions;

use App\Models\Destination;
use App\Models\Template;
use App\Models\Quote;
use App\Models\Site;
use App\Models\User;
use App\Services\ApplicationContextService;

/**
 * Class TemplateManager
 * @package App\Actions
 */
class TemplateManager
{
    /**
     * Get the computed template with replaced placeholders.
     *
     * @param Template $tpl The original template.
     * @param array $data Data to replace placeholders.
     * @return Template The computed template.
     * @throws \RuntimeException If no template is given.
     */
    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('No template given');
        }

        $replaced = $tpl;
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    /**
     * Replace placeholders in the given text with actual values.
     *
     * @param string $text The text containing placeholders.
     * @param array $data Data to replace placeholders.
     * @return string The text with replaced placeholders.
     */
    private function computeText($text, array $data)
    {
        $quote = $data['quote'] ?? null;
        if ($quote instanceof Quote) {
            $_quoteFromRepository = Quote::getById($quote->id);
            $usefulObject = Site::getById($quote->siteId);
            $destinationOfQuote = Destination::getById($quote->destinationId);

            $text = $this->replaceQuotePlaceholders($text, $_quoteFromRepository, $usefulObject, $destinationOfQuote);
        }

        $appContext = new ApplicationContextService();
        $user = $appContext->getCurrentUser();

        if ($user instanceof User) {
            $text = $this->replaceUserPlaceholders($text, $user);
        }

        return $text;
    }

    /**
     * Replace placeholders related to a quote in the given text.
     *
     * @param string $text The text containing quote placeholders.
     * @param Quote $quote The quote object.
     * @param Site $usefulObject The site object.
     * @param Destination $destinationOfQuote The destination object.
     * @return string The text with replaced quote placeholders.
     */
    private function replaceQuotePlaceholders($text, $quote, $usefulObject, $destinationOfQuote)
    {
        // Replace [quote:destination_link] placeholder
        if (strpos($text, '[quote:destination_link]') !== false) {
            $destination = $destinationOfQuote;
            $text = str_replace('[quote:destination_link]', $usefulObject->url . '/' . $destination->countryName . '/quote/' . $quote->id, $text);
        } else {
            $text = str_replace('[quote:destination_link]', '', $text);
        }

        // Replace [quote:summary_html] and [quote:summary] placeholders
        $containsSummaryHtml = strpos($text, '[quote:summary_html]');
        $containsSummary = strpos($text, '[quote:summary]');

        if ($containsSummaryHtml !== false) {
            $text = str_replace('[quote:summary_html]', $quote->renderHtml(), $text);
        }

        if ($containsSummary !== false) {
            $text = str_replace('[quote:summary]', $quote->renderText(), $text);
        }

        // Replace [quote:destination_name] placeholder
        if (strpos($text, '[quote:destination_name]') !== false) {
            $text = str_replace('[quote:destination_name]', $destinationOfQuote->countryName, $text);
        }

        return $text;
    }

    /**
     * Replace placeholders related to a user in the given text.
     *
     * @param string $text The text containing user placeholders.
     * @param User $user The user object.
     * @return string The text with replaced user placeholders.
     */
    private function replaceUserPlaceholders($text, $user)
    {
        // Replace [user:first_name] placeholder
        if (strpos($text, '[user:first_name]') !== false) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
        }

        return $text;
    }
}
