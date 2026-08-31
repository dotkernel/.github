<?php

/*
 * This file is part of the Dotkernel GitHub page.
 * It was copied and adapted from https://github.com/bitExpert/.github/blob/main/build/feed_update.php
 * (c) bitExpert AG
 * (c) Dotkernel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

const MAX_BLOGPOSTS_TO_RENDER = 5;
const FEED_URL               = 'https://www.dotkernel.com/feed/';
const README_FILE            = __DIR__ . '/../profile/README.md';
const MARKER_START           = '<!--- blog_start --->';
const MARKER_END             = '<!--- blog_end --->';

/**
 * Write a message to STDERR and stop with a non-zero exit code, so the
 * calling workflow fails loudly instead of committing an empty blog list.
 */
function fail(string $message): never
{
    fwrite(STDERR, 'ERROR: ' . $message . PHP_EOL);
    exit(1);
}

/**
 * Escape the characters that would break a Markdown link label.
 */
function escapeMarkdownText(string $text): string
{
    return str_replace(['\\', '[', ']'], ['\\\\', '\[', '\]'], $text);
}

/**
 * Wrap the URL in angle brackets when it contains characters that would
 * terminate the Markdown link target early.
 */
function formatMarkdownUrl(string $url): string
{
    return preg_match('/[\s()<>]/', $url) === 1 ? '<' . $url . '>' : $url;
}

echo "Downloading XML blog posts feed...\n";

$context = stream_context_create([
    'http' => [
        'timeout'         => 10,
        'follow_location' => 1,
        'header'          => "Accept: application/rss+xml, application/xml, text/xml\r\n"
            . "User-Agent: dotkernel-feed-update\r\n",
    ],
]);

$xmlFeed = @file_get_contents(FEED_URL, false, $context);
if ($xmlFeed === false || trim($xmlFeed) === '') {
    fail('Could not download the feed from ' . FEED_URL);
}

echo "Parsing feed...\n";

$previousSetting = libxml_use_internal_errors(true);
$feed            = simplexml_load_string($xmlFeed);
$libxmlErrors    = libxml_get_errors();
libxml_clear_errors();
libxml_use_internal_errors($previousSetting);

if ($feed === false) {
    fail('Could not parse the feed: ' . trim($libxmlErrors[0]->message ?? 'unknown libxml error'));
}

if (! isset($feed->channel->item)) {
    fail('The feed contains no channel items.');
}

echo "Extracting latest blog posts from feed...\n";

$blogposts = [];
foreach ($feed->channel->item as $item) {
    $title = trim((string) $item->title);
    $link  = trim((string) $item->link);
    if ($title === '' || $link === '') {
        continue;
    }

    $publishedAt = strtotime(trim((string) $item->pubDate));

    $blogposts[] = [
        'title'       => $title,
        'link'        => $link,
        'publishedAt' => $publishedAt === false ? 0 : $publishedAt,
    ];
}

if ($blogposts === []) {
    fail('No usable blog posts found in the feed.');
}

// Do not rely on the feed being ordered.
usort($blogposts, static fn (array $a, array $b): int => $b['publishedAt'] <=> $a['publishedAt']);

$latestBlogposts = array_slice($blogposts, 0, MAX_BLOGPOSTS_TO_RENDER);

echo "Building Markdown content...\n";

$markdownBlogpostCollection = '';
foreach ($latestBlogposts as $post) {
    $markdownBlogpostCollection .= sprintf(
        " - [%s](%s)\n",
        escapeMarkdownText($post['title']),
        formatMarkdownUrl($post['link'])
    );
}

echo "Updating README.md file...\n";

if (! is_file(README_FILE)) {
    fail('README.md file not found at ' . README_FILE);
}

$readmeFileContents = file_get_contents(README_FILE);
if ($readmeFileContents === false) {
    fail('Could not read ' . README_FILE);
}

$startPosition = strpos($readmeFileContents, MARKER_START);
$endPosition   = strpos($readmeFileContents, MARKER_END);
if ($startPosition === false || $endPosition === false || $endPosition < $startPosition) {
    fail(sprintf('Could not find the %s / %s markers in README.md', MARKER_START, MARKER_END));
}

$endPosition += strlen(MARKER_END);

$updatedContents = substr_replace(
    $readmeFileContents,
    MARKER_START . "\n" . $markdownBlogpostCollection . MARKER_END,
    $startPosition,
    $endPosition - $startPosition
);

if ($updatedContents === $readmeFileContents) {
    echo "README.md is already up to date.\n";
    exit(0);
}

if (file_put_contents(README_FILE, $updatedContents) === false) {
    fail('Could not write ' . README_FILE);
}

echo "Done.\n";
