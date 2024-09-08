<?php

namespace App\Services\Parsers;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DuskParser extends DuskTestCase
{
    public function parse()
    {
        $this->browse(function (Browser $browser) {

            // Navigate to the website
            $browser->visit('https://buff.163.com')
                ->pause(2000)  // Optionally pause for loading
                // Get page content
                ->with('body', function (Browser $body) {
                    // Example: Get text of a specific element
                    $headerText = $body->text('h1');
                    $paragraphText = $body->text('p');

                    // Example: Capture elements' values
                    echo 'Header: ' . $headerText . PHP_EOL;
                    echo 'Paragraph: ' . $paragraphText . PHP_EOL;

                    // You can store or manipulate the data as needed
                });
        });
    }


}
