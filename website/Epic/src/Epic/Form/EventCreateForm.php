<?php
namespace Epic\Form;

class EventCreateForm extends EventForm
{
    protected $subFormGroups = array(
        'default' => array(
            'Text' => 'Event\Form\TextForm',
            'EventFile' => 'Event\Form\EventFileForm',
            'CategoryEvent' => array(
                'formClass' => 'Event\Form\CategoryEventForm',
                'collection' => true,
                'optionsCallback' => 'initCategories',
            ),
        ),
    );

    protected $mergeElements = array(
    );

    protected $mergeFilters = array(
        'title' => array(
            'required' => true,
        ),
        'urlName' => array (
            'required' => false,
            'validators' => array (
                'db' => array(
                    'name' => 'Eva\Validator\Db\NoRecordExists',
                    'options' => array(
                        'field' => 'urlName',
                        'table' => 'event_events',
                    ),
                ),
            ),
        ),
    );

    public function beforeBind($data)
    {
        $config = \Eva\Api::_()->getModuleConfig('Epic');
        $status = $config['event']['status']['default'];
        $visibility = $config['event']['visibility']['default'];
        $timezone = $config['event']['timezone']['default'];

        $data['eventStatus'] = $status; 
        $data['visibility'] = $visibility; 
        $data['isFullDayEvent'] = 1; 
        $data['timezone'] = $timezone ? $timezone : 0;

        //Data is array is for display
        if(isset($data['CategoryEvent']) && is_array($data)){
            $categoryEvents = array();
            $subForms = $this->get('CategoryEvent');
            foreach($subForms as $key => $subForm){
                $categoryEvent = array();
                $category = $subForm->getCategory();
                if (!$category) {
                    continue;
                }
                $category = $category->toArray();

                $categoryEvent['category_id'] = $category['id'];
                foreach($data['CategoryEvent'] as $categoryEventArray){
                    if($categoryEvent['category_id'] == $categoryEventArray['category_id']){
                        $categoryEvent = array_merge($categoryEvent, $categoryEventArray);
                        break;
                    }
                }
                $categoryEvents[] = $categoryEvent;
            }
            $data['CategoryEvent'] = $categoryEvents;
        }
        return $data;
    }

    public function prepareData($data)
    {
        if(isset($data['EventFile'])){
            $data['EventFile']['event_id'] = $data['id'];
        }

        if(isset($data['timezone'])){
            $config = \Eva\Api::_()->getModuleConfig('Epic');
            $timezone = $config['event']['timezone']['default'];
            $data['timezone'] = $timezone ? $timezone : 0;
        }

        $categoryEvents = array();
        if(isset($data['CategoryEvent']) && $data['CategoryEvent']){
            foreach($data['CategoryEvent'] as $categoryEvent){
                if(isset($categoryEvent['category_id']) && $categoryEvent['category_id']){
                    $categoryEvents[] = $categoryEvent;
                }
            }
            $data['CategoryEvent'] = $categoryEvents;
        }

        unset($data['recommend']);
        return $data;
    }
}
