<?php namespace Inerba\Embedd\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Inerba\Embedd\Classes\Embedd;
use Cms\Classes\Controller;

/**
 * Embedd Form Widget
 */
class EmbeddWidget extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'embedd';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('embedd');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $value = $this->getLoadValue();

        if(isset($value['url'])) {
            $this->vars['value'] = $value['url'];
        } else {
            $this->vars['value'] = null;
        }

        $this->vars['name'] = $this->formField->getName();
        $this->vars['model'] = $this->model;
        $this->vars['form'] = $this;

    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/extractmedia.css', 'Inerba.Embedd');
        $this->addJs('js/extractmedia.js', 'Inerba.Embedd');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        $media_url = $value;

        if( !empty($media_url) ) {

            $Embedd = new Embedd();
            $media = $Embedd->retrieve($media_url);

            if($media->code) {
                $value = $media;
            }
        }
        return $value;
    }

    public function onExtractMedia(){
        $formFieldValue = post(post('embedd_name'));
        $media = $this->ExtractMedia($formFieldValue);

        if(isset($media->code)){
            return $this->vars['media'] = $media->code;
        }
        return $this->vars['media'] = false;
    }

    public function ExtractMedia($value){
        $media_url = $value;

        if( !empty($media_url) ) {

            $Embedd = new Embedd();
            $media = $Embedd->retrieve($media_url);

            if($media) {
                $value = $media;
            }
        }

        return $value;
    }
}
