<?php
class YiiAjaxFindByPkAction extends YiiAjaxFindAction {

	/**
	 * @var string
	 */
	public $requestVarName = 'id';

	/**
	 * @var CActiveRecord
	 */
	public $foundModel;

	protected function find() {
		$id = Yii::app()->getRequest()->getParam($this->requestVarName, null);
		if ($id) {
			$this->foundModel = $this->model->findByPk($id);
			if ($this->foundModel) {
				if ($this->enableViewRender) {
					$this->scope['model'] = $this->foundModel;
				} else {
					$this->response = $this->getAttributes($this->foundModel);
				}
			}
		}
	}
}