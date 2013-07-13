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
			Yii::import('application.modules.note.models.Note');
			$note = Note::model()->with('url')->find('url.path = :path AND url.object_alias = :objectAlias AND t.status = :status', array(
				':path' => $matches[1],
				':objectAlias' => 'Note',
				':status' => Note::STATUS_OPEN
			));

			if (!$note instanceof Note)
			{
				return FALSE;
			}
			$_GET['id'] = $note->getPrimaryKey();
			return 'note/default/view';
		}
		return false;
	}
}