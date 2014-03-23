<?php
class YiiAjaxFindRelatedAction extends YiiAjaxFindByPkAction {

	/**
	 * @var string
	 */
	public $requestRelationVar = 'relation';

	protected function find() {
		$relation = Yii::app()->getRequest()->getParam($this->requestRelationVar);
		$relationConfiguration = array();
		if ($relation) {
			$relations = $this->model->relations();
			if (!array_key_exists($relation, $relations)) {
				throw new CHttpException(400, 'Relation is undefined!');
			}
			$relationConfiguration = $relations[$relation];
		}
		parent::find();
		$default = in_array($relationConfiguration[1], array(
			CActiveRecord::HAS_MANY,
			CActiveRecord::MANY_MANY
		)) ? array() : null;
		$related = $this->foundModel ? $this->foundModel->getRelated($relation) : $default;
		if ($this->enableViewRender) {
			$this->scope['related'] = $related;
			if ($this->foundModel) {
				$this->scope['related'] = $this->foundModel->getRelated($relation);
			}
		} else {
			$this->response = $default;
			if ($this->foundModel) {
				$this->response = $this->foundModel->getRelated($relation);
			}
		}
	}
}