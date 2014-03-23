<?php
abstract class YiiAjaxFindAction extends YiiAjaxViewRenderAction {

	/**
	 * @var CActiveRecord
	 */
	public $model;

	/**
	 * @var CDbCriteria
	 */
	public $criteria;

	/**
	 * @var array
	 */
	public $responseAttributes = array();

	/**
	 * @var callable|Closure
	 */
	public $responseAttributesFormatter;

	public function onBeforeFind() {}
	public function onAfterFind() {}

	/**
	 * You need to fill $response or $scope
	 *
	 * @return void
	 */
	abstract protected function find();

	/**
	 * @param CActiveRecord $model
	 *
	 * @return array
	 */
	protected function getAttributes(CActiveRecord $model) {
		return call_user_func($this->responseAttributesFormatter, $model, $this);
	}

	public function run() {

		if (!$this->responseAttributesFormatter) {
			$attributes = $this->responseAttributes;
			$this->responseAttributesFormatter = function (CActiveRecord $model) use ($attributes) {
				if (empty($attributes)) {
					return $model->getAttributes();
				}
				return $model->getAttributes($attributes);
			};
		}

		$this->raiseEvent('onBeforeFind', new CEvent($this));

		$this->find();

		$this->raiseEvent('onAfterFind', new CEvent($this));

		parent::run();
	}
}