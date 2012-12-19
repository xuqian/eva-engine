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
        'city' => array (
            'name' => 'city',
            'type' => 'select',
            'options' => array (
                'label' => 'City',
                'value_options' => array (
                    array(
                        'label' => 'EUROPE',
                        'options' => array(
                            array(
                                'label' => 'Amsterdam',
                                'value' => 'Amsterdam',
                            ),
                            array(
                                'label' => 'Florence',
                                'value' => 'Florence',
                            ),
                            array(
                                'label' => 'Prague',
                                'value' => 'Prague',
                            ),
                            array(
                                'label' => 'Athens',
                                'value' => 'Athens',
                            ),
                            array(
                                'label' => 'Istanbul',
                                'value' => 'Istanbul',
                            ),
                            array(
                                'label' => 'Rome',
                                'value' => 'Rome',
                            ),
                            array(
                                'label' => 'Barcelona',
                                'value' => 'Barcelona',
                            ),
                            array(
                                'label' => 'Lisbon',
                                'value' => 'Lisbon',
                            ),
                            array(
                                'label' => 'Seville',
                                'value' => 'Seville',
                            ),
                            array(
                                'label' => 'Berlin',
                                'value' => 'Berlin',
                            ),
                            array(
                                'label' => 'London',
                                'value' => 'London',
                            ),
                            array(
                                'label' => 'Venice',
                                'value' => 'Venice',
                            ),
                            array(
                                'label' => 'Brussels',
                                'value' => 'Brussels',
                            ),
                            array(
                                'label' => 'Madrid',
                                'value' => 'Madrid',
                            ),
                            array(
                                'label' => 'Vienna',
                                'value' => 'Vienna',
                            ),
                            array(
                                'label' => 'Budapest',
                                'value' => 'Budapest',
                            ),
                            array(
                                'label' => 'Milan',
                                'value' => 'Milan',
                            ),
                            array(
                                'label' => 'Zurich',
                                'value' => 'Zurich',
                            ),
                            array(
                                'label' => 'Copenhagen',
                                'value' => 'Copenhagen',
                            ),
                            array(
                                'label' => 'Naples',
                                'value' => 'Naples',
                            ),
                            array(
                                'label' => 'Dublin',
                                'value' => 'Dublin',
                            ),
                            array(
                                'label' => 'Paris',
                                'value' => 'Paris',
                            ),
                        ),

                    ),

                    array(
                        'label' => 'Africa & Middle EAST',
                        'options' => array(
                            array(
                                'label' => 'Cairo',
                                'value' => 'Cairo',
                            ),
                            array(
                                'label' => 'Marrakech',
                                'value' => 'Marrakech',
                            ),
                            array(
                                'label' => 'Tel Aviv',
                                'value' => 'Tel Aviv',
                            ),
                        ),
                    ),

                    array(
                        'label' => 'Amercia',
                        'options' => array(
                            array(
                                'label' => 'Las Vegas',
                                'value' => 'Las Vegas',
                            ),
                            array(
                                'label' => 'Los Angeles',
                                'value' => 'Los Angeles',
                            ),
                            array(
                                'label' => 'Miami',
                                'value' => 'Miami',
                            ),
                            array(
                                'label' => 'New York',
                                'value' => 'New York',
                            ),
                            array(
                                'label' => 'San Francisco',
                                'value' => 'San Francisco',
                            ),
                            array(
                                'label' => 'Washington D.C.',
                                'value' => 'Washington D.C.',
                            ),
                            array(
                                'label' => 'Buenos Aires',
                                'value' => 'Buenos Aires',
                            ),
                            array(
                                'label' => 'Rio De Janeiro',
                                'value' => 'Rio De Janeiro',
                            ),
                            array(
                                'label' => 'San Paulo',
                                'value' => 'San Paulo',
                            ),
                        ),
                    ),

                    array(
                        'label' => 'Asia',
                        'options' => array(
                            array(
                                'label' => 'Shanghai',
                                'value' => 'Shanghai',
                            ),
                            array(
                                'label' => 'Beijing',
                                'value' => 'Beijing',
                            ),
                            array(
                                'label' => 'Guangzhou',
                                'value' => 'Guangzhou',
                            ),
                            array(
                                'label' => 'Nanjing',
                                'value' => 'Nanjing',
                            ),
                            array(
                                'label' => 'Hong Kong',
                                'value' => 'Hong Kong',
                            ),
                            array(
                                'label' => 'Singapore',
                                'value' => 'Singapore',
                            ),
                        ),
                    ),

                    array(
                        'label' => 'Other',
                        'options' => array(
                            array(
                                'label' => 'Other',
                                'value' => 'Other',
                            ),

                        ),
                    ),

                ),
            ),
            'attributes' => array (
                'value' => '',
            ),
        ),
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

        return $data;
    }
}
