<?php 



abstract class Theme_Hook {

    protected $actions = array();

    protected $filters = array();
    
    public function __construct() {

        
        $this->create_hook();
        
        $this->create_filter();
    }


    /**  
     * Latest Hook algorithm
     * 
    */
    protected function create_hook() {

        if(count($this->actions) > 0 ) {
            
            foreach ($this->actions as $tag => $action) {
                if(is_array($action)) {
                    foreach($action as $action_value) {
                        if(array_key_exists("fn", $action)) {
                            $pos = isset($action['pos']) ? $action['pos'] : 10;
                            $param = isset($action['param']) ? $action['param'] : 1;
                            $event = isset($action['event']) ? $action['event'] : 'add';
    
                            add_action($tag,$action['fn'],$pos,$param);
                            break; //no need for further step
                        }
                        else {
                            $pos = isset($action_value['pos']) ? $action_value['pos'] : 10;
                            $param = isset($action_value['param']) ? $action_value['param'] : 1;
                            $event = isset($action_value['event']) ? $action_value['event'] : 'add';
        
                            if($event == 'remove') {
                                remove_action($tag, $action_value['fn'],$pos,$param);
                            }
                            else {
                                add_action($tag, $action_value['fn'], $pos,$param);
                            }
                        }
                    }
                }
                else {
                    add_action($tag,array($this,$action),10);
                }
            }
        }   
    }


    protected function create_filter() {
        if(count($this->filters) > 0 ) {

            foreach ($this->filters as $tag => $filter) {
                if(is_array($filter)) {
                    foreach($filter as $filter_value) {
                        if(array_key_exists("fn", $filter)) {
                            $pos = isset($filter['pos']) ? $filter['pos'] : 10;
                            $param = isset($filter['param']) ? $filter['param'] : 1;
                            $event = isset($filter['event']) ? $filter['event'] : 'add';

                            add_action($tag,$filter['fn'],$pos,$param);

                            break;
                        }
                        else {
                            
                            $pos = isset($filter_value['pos']) ? $filter_value['pos'] : 10;
                            $param = isset($filter_value['param']) ? $filter_value['param'] : 1;
                            $event = isset($filter_value['event']) ? $filter_value['event'] : 'add';
        
                            if($event == 'remove') {
                                remove_action($tag, $filter_value['fn'],$pos,$param);
                            }
                            else {
                                add_action($tag, $filter_value['fn'], $pos,$param);
                            }
                        }
                    }
                }
                else {
                    add_action($tag,array($this,$filter),10);
                }
            }
        }   
    }
    

}