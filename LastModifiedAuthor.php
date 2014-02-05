<?php
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

	function onSkinTemplateOutputPageBeforeExec($sk, &$tpl)
	{
		if (RequestContext::getMain()->getOutput()->isArticle()) {
			$data = $tpl->data['credits'];
			if (!empty($data)) {
				$data .= '<br>';
			}

			$article = Article::newFromTitle(
				RequestContext::getMain()->getOutput()->getTitle(),
				RequestContext::getMain()->getOutput()->getContext());

			$user = $article->getPage()->getUser();
			$userText = $article->getPage()->getUserText();
			$userLink = Linker::userLink($user, $userText);

			$data .= '<p>Автор изменения &dash; ' . $userLink . '.</p>';

			$tpl->set('credits', $data);
		}

		return true;
	}
}

function wfSetupLastModifiedAuthor()
{
	global $wgLastModifiedAuthor;

	$wgLastModifiedAuthor = new LastModifiedAuthor;
}
