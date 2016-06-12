<?php
/**
 * @author Dan Bettles <danbettles@yahoo.co.uk>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace DanBettles\WpToolbox\Helpers;

class Youtube
{
    /**
     * Returns the first video ID found in the specified string, which is expected to be either (1) a video ID, (2) the
     * URL of a video, or (3) the embed code for a video.
     *
     * @param string $input
     * @return string|null
     */
    public static function extractVideoId($input)
    {
        $videoIdPattern = '[a-zA-Z0-9\-]+';

        $matches = [];

        if (preg_match("/^{$videoIdPattern}$/", $input, $matches)) {
            return $matches[0];
        }

        $url = null;

        if (false !== filter_var($input, FILTER_VALIDATE_URL)) {
            $url = $input;
        } else {
            $srcMatches = [];
            $containsEmbedCode = preg_match('/\bsrc="(.*?)"/', $input, $srcMatches);

            if ($containsEmbedCode) {
                $url = $srcMatches[1];
            }
        }

        if (null === $url) {
            return null;
        }

        if (false !== strpos($url, '/embed/')) {
            $idMatches = [];
            $containsId = preg_match("~/embed/({$videoIdPattern})~", $url, $idMatches);

            return $containsId ? $idMatches[1] : null;
        }

        $idMatches = [];
        $containsId = preg_match("~[\?&]v=({$videoIdPattern})~", $url, $idMatches);

        return $containsId ? $idMatches[1] : null;
    }
}
