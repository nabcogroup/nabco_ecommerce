<?php 



abstract class Nb_ActionHook {

    protected $actions = array();

    protected $filters = array();
    
    public function __construct() {

        if(count($this->actions) > 0 ) {
            foreach ($this->actions as $tag => $actions) {
                foreach($this->actions as $value) {

                    $pos = isset($value['pos']) ? $value['pos'] : 10;

                    if(isset($value['func']) && $value['func'] == 'remove') {
                        remove_action($tag, $value['action'],$pos);
                    }
                    else if(isset($value['func']) && $value['func'] == 'wc') {
                        add_action($tag, $value['action'],$pos);
                    }
                    else {
                        add_action($tag, array($this,$value['action']),$pos);
                    }
                }
            }
        }
    }

    public function __call($method,$args) {
        
        $call_actions = explode("_",$method);
        
        if($call_actions[0] == 'set') {

            if(isset($this->{$call_action[1]})) {
                $this->{$call_action[1]} = $args[0];
            }
            
        }
    }

    

}