<?php
class YiiAjaxFindByAttributesAction extends YiiAjaxFindAction {

	/**
	 * @var array
	 */
	public $requestAttributesNames = array();

	/**
	 * @var callable|Closure
	 */
	public $requestAttributeValueValidator;

	/**
	 * You need to fill $response or $scope
	 *
	 * @return void
	 */
	protected function find() {

		//  set default validator
		if (!$this->requestAttributeValueValidator) {
			$this->requestAttributeValueValidator = function ($attribute, $value) {
				return !($value === '');
			};
		}

		//  fetch attributes
		$attributes = array();
		foreach ($this->requestAttributesNames as $attribute) {
			$value = Yii::app()->getRequest()->getParam($attribute);
			if (call_user_func($this->requestAttributeValueValidator, $attribute, $value)) {
				$attributes[$attribute] = $value;
			}
		}

		if ($this->requestModel) {
			$this->requestModel->setAttributes($attributes);
			if (!$this->requestModel->validate()) {
				throw new CHttpException(400, 'You request is invalid!');
			}
			$attributes = $this->requestModel->getAttributes();
		}

		//  find models
		$models = array();
		if (!empty($attributes)) {
			$models = $this->model->findAllByAttributes($attributes);
		}

		//  set response
		if ($this->enableViewRender) {
			$this->scope['models'] = $models;
		} else {
			foreach ($models as $model) {
				$this->response[] = $this->getAttributes($model);
			}
		}
	}
}