<?php
class NoteUrlRule extends CBaseUrlRule
{
	public $connectionID = 'db';

	public function createUrl($manager,$route,$params,$ampersand)
	{
		if ($route==='note/default/view' && isset($params['path']))
		{
			return $params['path'];
		}
		return false;
	}

	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
	{
		if (preg_match('/^([a-z0-9-]+)$/i', $pathInfo, $matches))
		{
			$url = Url::model()->find('path = :path AND object_alias = :objectAlias', array(
				':path' => $matches[1],
				':objectAlias' => 'Note',
			));
			if (!$url instanceof Url)
			{
				return FALSE;
			}
			$_GET['id'] = $url->getPrimaryKey();
			return 'note/default/view';
		}
		return false;
	}
}