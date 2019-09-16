<?php

namespace src\Core\Parser;

use DOMElement;
use GuzzleHttp\Client;
use DOMDocument;
use src\components\ConfigStorage;

/**
 * Class Parser
 * @package src\Core\Parser
 */
class Parser
{
    private const TMP_HTML_PATH = __ROOT_DIR__ . '/tmp/temp.html';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var ConfigStorage
     */
    private $configStorage;

    /**
     * @var FileSaver
     */
    private $fileSaver;

    /**
     * @var DOMDocument
     */
    private $dom;

    /**
     * @var string
     */
    private $pageTitle;

    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['curl' => [CURLOPT_SSL_VERIFYPEER => false]]);
        $this->configStorage = new ConfigStorage();
        $this->dom = new DOMDocument();
        $this->fileSaver = new FileSaver();
    }

    /**
     * Common parse method
     */
    public function parse(): void
    {
        $this->setHTML();
        $this->dom->loadHTMLFile(self::TMP_HTML_PATH);
        $this->setTitle();
        $this->parsePosts();
    }

    /**
     * Set temporary html
     */
    private function setHTML(): void
    {
        $response = $this->client->get($this->configStorage->getParam('themeUrl'));
        $html = $response->getBody()->getContents();
        file_put_contents(self::TMP_HTML_PATH, $html);
    }

    /**
     * Set page title
     */
    private function setTitle(): void
    {
        $titleBlock = $this->dom->getElementById('pagetitle')->getElementsByTagName('a');
        $this->pageTitle = $titleBlock->item(0)->textContent;
    }

    /**
     * Parse all posts on page
     */
    private function parsePosts(): void
    {
        $postNodeList = $this->dom->getElementById('postlist')->getElementsByTagName('li');

        /** @var DOMElement $post */
        foreach ($postNodeList as $post) {
            $this->fileSaver->save($this->parsePost($post));
        }
    }

    /**
     * @param DOMElement $post
     *
     * @return array
     */
    private function parsePost(DOMElement $post): array
    {
        $date = trim($post->getElementsByTagName('span')->item(0)->textContent);
        $textBlocks = $post->getElementsByTagName('div');

        $text = '';
        /** @var DOMElement $block */
        foreach ($textBlocks as $block) {
            if ($block->getAttribute('class') === 'content') {
                $text .= trim($block->textContent);
            }
        }

        return [
            'fileName' => $this->pageTitle . '-' . $date,
            'postTitle' => trim($post->getElementsByTagName('h2')->item(0)->textContent),
            'author' => trim($post->getElementsByTagName('a')->item(3)->textContent),
            'date' => $date,
            'text' => $text,
        ];
    }
}