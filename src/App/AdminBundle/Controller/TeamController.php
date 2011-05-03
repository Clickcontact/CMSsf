<?php

namespace App\AdminBundle\Controller;

class TeamController extends AdminBaseController {

    protected $_name = 'Team';
    
    public function indexAction() {
        $teams = $this->getAll($this->_name);
        return $this->renderTpl($this->_name . ':index', compact('teams'));
    }    

}

