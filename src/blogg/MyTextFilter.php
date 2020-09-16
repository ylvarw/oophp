<?php
namespace Ylvan\Text;

// namespace Mos\TextFilter;

 /*
 *Supress phpmd warnings

 * 
 * @SuppressWarnings(PHPMD)
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
// namespace Ylvan\Text;
use \Michelf\Markdown as Markdown;

/*
* a class to filter and format text
*
*/
class MyTextFilter
{
    /**
     * @var array $filters Supported filters with method names of 
     *                     their respective handler.
     */
    // private $filters = [
    //     "bbcode"    => "bbcode2html",
    //     "link"      => "makeClickable",
    //     "markdown"  => "markdown",
    //     "nl2br"     => "nl2br",
    // ];



    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filter) 
    {
        $filteredtext = $text;
        // text
        //loop through filter and call filters in order
        foreach ($filter as $f) {
            switch ($f) {
                case "markdown":
                    $newtext = $this->markdown($filteredtext);
                    $filteredtext = $newtext;
                    break;
                case "nl2br":
                    $newtext = $this->nl2br($filteredtext);
                    $filteredtext = $newtext;
                    break;
                case "bbcode":
                    $newtext = $this->bbcode2html($filteredtext);
                    $filteredtext = $newtext;
                    break;
                case "link":
                    $newtext = $this->makeClickable($filteredtext);
                    $filteredtext = $newtext;
                    break;
                default:
                    break;
            }
        }
        return $filteredtext;
    }


    public function parseAll($text) 
    {
        $text1 = $this->makeClickable($text);
        $text2 = $this->markdown($text1);
        $text3 = $this->nl2br($text2);
        $text4 = $this->bbcode2html($text3);

        return $text4; 
    }



    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     */
    public function bbcode2html($text) 
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];
    
        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }



    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string with formatted anchors.
     */
    public function makeClickable($text) 
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";
            },
            $text
        );
    }
    

    // use \Michelf\Markdown;


    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function markdown($text) 
    {
        return Markdown::defaultTransform($text);
    }



    /**
     * For convenience access to nl2br formatting of text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function nl2br($text) 
    {
        $result = str_replace("\n", '<br/>', $text);
        // nl2br(string $text [bool $is_xhtml = true]):string;
        // $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $text);
        // return $string;
        return $result;
    }
}
