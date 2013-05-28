<?php
/**
 * Author: Denisov Denis
 * Email: denisovdenis@me.com
 * Date: 28.05.13
 * Time: 15:06
 */

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
    $tpl->set('lastmod', $tpl->data['lastmod'] . "; <b>автор изменения</b> — $user.");

    return true;
}