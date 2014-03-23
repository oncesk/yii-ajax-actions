<?php
class YiiAjaxFindByPkAction extends YiiAjaxFindAction {

	/**
	 * @var string
	 */
	public $requestVarName = 'id';

	protected function find() {
		$id = Yii::app()->getRequest()->getParam($this->requestVarName, null);
		if ($id) {
			$model = $this->model->findByPk($id);
			if ($model) {
				if ($this->enableViewRender) {
					$this->scope['model'] = $model;
				} else {
					$this->response = $this->getAttributes($model);
				}
			}
		}
	}
}