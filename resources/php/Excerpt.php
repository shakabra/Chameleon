<?php
/**
 * Used to encapsulate an excerpt of a blog post and associated 
 * meta-data from a database into an Excerpt object which can be
 * to print to a Web document.
 *
 */

class Excerpt
{
    /**
     * @var $id The unique identifer of this instance of Excerpt.
     */
    private $id = null;

    /**
     * @var $title The title of the associated blog post.
     */
    private $title = null;

    /**
     * @var $pub_date The date of the blog post the excerpt was taken from.
     */
    private $pub_date = null;

    /**
     * @var $content  The main content of the excerpt.
     */
    private $content = null;

    /**
     * @var $category If categorized, store category here.
     */
    private $category = null;

    /**
     * @var $url A hyperlink to the associated blog post.
     */
    private $url = null;

    /**
     * Uses the give data array to construct a new Excerpt Object.
     *
     * @param $data array Properly formated array for constructing the
     * Excerpt Object.
     */
    public function __construct($data) {
        foreach ($data as $key => $value) {
            switch ($key) {
            case 'excerpt':
                $this->content = $value;
                break;
            case 'id':
                $this->id = $value;
                $this->create_url();
                break;
            case 'pub_date':
                $this->pub_date = $value;
                break;
            case 'category':
                $this->category = $value;
                break;
            case 'title':
                $this->title = $value;
                break;
            }
        }

    }

    /**
     * Creates a url to link to the blog post that the Excerpt was created
     * from.
     *
     * @return null
     */
    private function create_url() {
        if ($this->id) {
            $this->url = "posts?id=$this->id";
        }
    }

    /**
     * Prints the Excerpt object as HTML
     */
    public function toHTML() {
        $html = <<<EOT
<h2>$this->title</h2>
<span class="timestamp">$this->pub_date</span>
$this->content
<span>$this->category</span><br>
<a href="/$this->url">Read Article</a>
EOT;
        return $html;
    }
}
