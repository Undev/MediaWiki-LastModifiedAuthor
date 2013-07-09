<?php
/**
 * Author: Denisov Denis
 * Email: denisovdenis@me.com
 * Date: 28.05.13
 * Time: 15:06
 */


$wgExtensionFunctions[] = 'wfSetupLastModifiedAuthor';
$wgExtensionCredits['other'][] = array(
    'path' => __FILE__,
    'name' => 'LastModifiedAuthor',
    'author' => '[http://www.facebook.com/denisovdenis Denisov Denis]',
    'url' => 'https://github.com/Undev/wiki-last-modified-author',
    'description' => 'Displays the author of the last change at the end of the article',
    'version' => 0.3,
);

class LastModifiedAuthor
{
    function __construct()
    {
        global $wgHooks;

        $wgHooks['SkinTemplateOutputPageBeforeExec'][] = $this;

    }

    public function onSkinTemplateOutputPageBeforeExec($sk, &$tpl)
    {
        try {
            $revision = RequestContext::getMain()->getWikiPage()->getRevision();
            if ($revision) {
                $title = RequestContext::getMain()->getOutput()->getTitle();
                $context = RequestContext::getMain()->getOutput()->getContext();
                $article = Article::newFromTitle($title, $context);

                $user = $article->getPage()->getUser();
                $userText = $article->getPage()->getUserText();
                $userLink = Linker::userLink($user, $userText);

                $tpl->set('lastmod', $tpl->data['lastmod'] . "; <b>автор изменения</b> — $userLink.");

            }
        } catch (Exception $e) {

        }
        return true;
    }
}

function wfSetupLastModifiedAuthor()
{
    global $wgLastModifiedAuthor;

    $wgLastModifiedAuthor = new LastModifiedAuthor;
}