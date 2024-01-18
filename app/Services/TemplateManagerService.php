<?php

namespace App\Services;

use App\Models\Destination;
use App\Models\Template;
use App\Models\Quote;
use App\Models\Site;
use App\Models\User;


class TemplateManagerService
{
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
        $currentUser = $appContext->getCurrentUser();
        dd($currentUser);
        if ($user instanceof User) {
            $text = $this->replaceUserPlaceholders($text, $user);
        }

        return $text;
    }

    private function replaceQuotePlaceholders($text, $quote, $usefulObject, $destinationOfQuote)
    {
        if (strpos($text, '[quote:destination_link]') !== false) {
            $destination = $destinationOfQuote;
            $text = str_replace('[quote:destination_link]', $usefulObject->url . '/' . $destination->countryName . '/quote/' . $quote->id, $text);
        } else {
            $text = str_replace('[quote:destination_link]', '', $text);
        }

        $containsSummaryHtml = strpos($text, '[quote:summary_html]');
        $containsSummary = strpos($text, '[quote:summary]');

        if ($containsSummaryHtml !== false) {
            $text = str_replace('[quote:summary_html]', $quote->renderHtml(), $text);
        }

        if ($containsSummary !== false) {
            $text = str_replace('[quote:summary]', $quote->renderText(), $text);
        }

        if (strpos($text, '[quote:destination_name]') !== false) {
            $text = str_replace('[quote:destination_name]', $destinationOfQuote->countryName, $text);
        }

        return $text;
    }


    private function replaceUserPlaceholders($text, $user)
    {
        if (strpos($text, '[user:first_name]') !== false) {
            $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
        }

        return $text;
    }
}
