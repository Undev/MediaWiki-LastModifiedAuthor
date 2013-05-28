<?php

if (!defined('MEDIAWIKI')) {
    echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/LastModified/LastModified.php" );
EOT;
    exit(1);
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'LastModifiedAuthor',
    'version' => '1.0',
    'author' => '[http://www.facebook.com/denisovdenis Denisov Denis]',
    'url' => 'https://github.com/Undev/wiki-last-modified-author',
    'description' => 'Displays the author of the last change at the end of the article',
    'version' => 0.1,
);

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'lfTOSLink';

function lfTOSLink($sk, &$tpl)
{
    if (empty($tpl->data['lastmod']))
        return false;

    global $wgArticle;

    $user = Linker::userLink($wgArticle->getUser(), $wgArticle->getUserText());
    $tpl->set('lastmod', $tpl->data['lastmod'] . " Последний изменявший пользователь: $user.");

    return true;
}