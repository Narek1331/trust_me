<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoScriptCode implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Define patterns to detect various script types
        $patterns = [
            '/<\?(php|=|[^>]*)>/i',                  // PHP code, including short tags
            '/<script\b[^>]*>(.*?)<\/script>/is',    // JavaScript
            '/<style\b[^>]*>(.*?)<\/style>/is',      // CSS within style tags
            '/<\!--.*?-->/s',                        // HTML comments
            '/on\w+="[^"]*"/i',                      // Inline event handlers like onclick, onload, etc.
            '/<iframe\b[^>]*>(.*?)<\/iframe>/is',    // IFrames
            '/<embed\b[^>]*>(.*?)<\/embed>/is',      // Embeds
            '/<object\b[^>]*>(.*?)<\/object>/is',    // Objects
            '/<applet\b[^>]*>(.*?)<\/applet>/is',    // Applets
            '/<meta\b[^>]*>/i',                      // Meta tags (often used in XSS attacks)
            '/<link\b[^>]*>/i',                      // Link tags (e.g., loading external scripts)
        ];

        // Check each pattern against the value
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute field contains invalid script code.';
    }
}
